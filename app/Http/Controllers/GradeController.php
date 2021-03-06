<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\CommonCourseService;
use App\Services\CourseService;
use App\Ta;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    private $courseService;
    private $commonCourseService;

    public function __construct(CourseService $courseService, CommonCourseService $commonCourseService)
    {
        $this->courseService = $courseService;
        $this->commonCourseService = $commonCourseService;

    }
    public function getGradeList($status, $year, $semester){
        $user = Auth::user();
        $teachers = collect();

        if ($user->type == 1){ // 秘書
            $courses = $this->courseService->getAllOpenCourse();

            if ( $courses->isNotEmpty() ){
                //讓秘書可以選取特定教師
                foreach($courses as $course){
                    $teachers->push(Course::where('id', $course->id)->first()->teacher()->first());
                    $teachers = $teachers->unique('users_name');
                }

                $teacherID = Input::get('teacherID');
                if ($teacherID != null){
                    $teacher = Teacher::where('users_id', $teacherID)->first();
                } else {
                    $teacher = Teacher::where('users_id', $teachers[0]->users_id)->first();
                }
            } else {
                return redirect()->back();
            }

        } else if ($user->type == 2){ // TA
            $ta = Ta::where('users_id', $user->id)->first();
            $ta->courses_id = $ta->course()
                ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status')
                ->where('status', 1)
                ->pluck('id');

            if (count($ta->courses_id) > 0){
                $courses_id = $ta->course()
                    ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                    ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status')
                    ->where('status', 1)
                    ->pluck("id");

                //讓助教可以選自己的老師來改
                foreach($courses_id as $course_id){
                    $teachers->push(Course::where('id', $course_id)->first()->teacher()->first());
                    $teachers = $teachers->unique('users_name');
                }

                $teacherID = Input::get('teacherID');
                if ($teacherID != null){
                    $teacher = Teacher::where('users_id', $teacherID)->first();
                } else {
                    $teacher = Teacher::where('users_id', $teachers[0]->users_id)->first();
                }
            } else {
                return redirect()->back();
            }
        } else if ($user->type == 3){
            $teacher = Teacher::where('users_id', Auth::user()->id)->first();
        }


        if ($status == 'active'){
            $courses = $teacher->course()
                ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status')
                ->where('status', 1)
                ->get();

            //created for course to use assignment() relationship
            $courses_first = $teacher->course()
                ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status', 'common_courses.year as year', 'common_courses.semester as semester')
                ->where('status', 1)
                ->first();
        } else {
            $courses = $teacher->course()
                ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status')
                ->where('semester', $semester)
                ->where('year', $year)
                ->get();

            //created for course to use assignment() relationship
            $courses_first = $teacher->course()
                ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                ->select('courses.*', 'common_courses.name as common_course_name', 'common_courses.status as status', 'common_courses.year as year', 'common_courses.semester as semester')
                ->where('semester', $semester)
                ->where('year', $year)
                ->first();
        }

        //先取得該課程的學生清單
        $students = collect();
        foreach($courses as $course){
            $course_students = $course->student()->get();
            $common_course_name = $course->common_course_name;

            // flatten the students to 1d object
            foreach($course_students as $course_student){

                // to put common_course_name in course_student, should use this method.
                $course_student->common_course_name = $common_course_name;

                $students->push($course_student);

            }
        }

        $student_assignments = collect();
        $assignments = collect();
        $student_courses = collect();

        //依學生查詢其作業
        foreach($students as $key=> $student){
            if ($status == 'active') {
                $student_assignment = $student->assignment()
                    ->withPivot(['score', 'comment'])
                    ->join('courses', 'courses.id', '=', 'assignments.courses_id')
                    ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                    ->select('assignments.id as assignment_id',
                        'assignments.name as name',
                        'assignments.percentage as percentage',
                        'courses.id as course_id',
                        'student_assignment.score as score',
                        'student_assignment.comment as comment')
                    ->where('common_courses.status', 1)
                    ->whereIn('courses.id', $courses->pluck('id')) //這行很重要！！！！！！！不然會有重複的作業(假如同一學期修兩堂課的話)
                    ->orderBy('name')
                    ->get();

            } else {
                $student_assignment = $student->assignment()
                    ->withPivot(['score', 'comment'])
                    ->join('courses', 'courses.id', '=', 'assignments.courses_id')
                    ->join('common_courses', 'common_courses.id', '=', 'courses.common_courses_id')
                    ->select('assignments.id as assignment_id',
                        'assignments.name as name',
                        'assignments.percentage as percentage',
                        'courses.id as course_id',
                        'student_assignment.score as score',
                        'student_assignment.comment as comment')
                    ->where('common_courses.semester', $semester)
                    ->where('common_courses.year', $year)
                    ->orderBy('name')
                    ->get();
            }

//            $student_assignment = $this->resortStudentAssignment($student_assignment);


            $accumulated_score = 0;

            foreach ($student_assignment as $key2 => $assignment){

                // get the assignment attribute from student_assignment
                // 僅需取一次值 (在任何一個 $key 取值都可以，因為 每個 student_assignment 的 assignment 必須相同)
                if ($key == 0){
                    //add attribute to temp collect
                    $temp = collect();
                    $temp->id = $assignment->assignment_id;
                    $temp->name = $assignment->name;
                    $temp->percentage = $assignment->percentage;

                    $assignments->push($temp);
                }

                // 計算加權分數, 累加總分
                $weighted_score = $assignment->score * $assignment->percentage / 100;
                $assignment->weighted_score = $weighted_score;
                $accumulated_score += $weighted_score;

                if ($key2 == count($student_assignment)-1){
                    $assignment->accumulated_score = $accumulated_score;
                }
            }

            if ($student_assignment->isEmpty()){
                return redirect()->back()->with(['message' => '當學期沒有進行中的作業']);
            }

            $student_assignments->push($student_assignment);

            //取得final score
            $student_course = DB::table('student_course')
                ->where('students_id', $student->users_id)
                ->where('courses_id', $student_assignment[0]->course_id)
                ->first();

            $student_courses->push($student_course);
        }

        return view('grade.gradelist', [
            'user' => $user,
            'teacher' => $teacher,
            'teachers' => $teachers,
            'course' => $courses_first,
            'assignments' => $assignments,
            'students' => $students,
            'student_assignments' => $student_assignments,
            'student_courses' => $student_courses,
        ]);
    }

    public function postUpdatePercentage(Request $request){
        $validation = Validator::make($request->all(), [
            'assignmentID' => 'required',
            'assignmentPercentage' => [
                'required',
                'between:0,99.99',
                function($attribute, $value, $fail) {
                    $total_percentage = 0;
                    foreach($value as $percentage){
                        $total_percentage += $percentage;
                    }

                    if ($total_percentage > 100) {
                        $overPercentage = floor(($total_percentage*100)-10000)/100;
                        return $fail('錯誤：總比率為 '.$total_percentage.'% ,超過 '.$overPercentage.' %');
                    }
                },
                ]
        ]);

        $assignments_id = $request->get('assignmentID');
        $assignments_percentage = $request->get('assignmentPercentage');

        $error_array = array();
        $success_output = '';

        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {

            foreach($assignments_id as $key => $assignment_id){

                $percentage = $assignments_percentage[$key];

                if ($percentage != null){
                    DB::table('assignments')
                        ->where('id', $assignment_id)
                        ->update(['percentage' => $assignments_percentage[$key]]);
                } else {
                    $success_output = '<div class="alert alert-danger"> 錯誤:比率不可為空！ </div>';
                }

            }
            $success_output = '<div class="alert alert-success"> 設定成功！ </div>';
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output,
            'myid' => $assignments_percentage
        );
        echo json_encode($output);
    }

    public function postUpdatePercentage_admin(Request $request){
        $validation = Validator::make($request->all(), [
            'assignmentPercentage' => [
                'required',
                'between:0,99.99',
                function($attribute, $value, $fail) {
                    $total_percentage = 0;
                    foreach($value as $percentage){
                        $total_percentage += $percentage;
                    }

                    if ($total_percentage > 100) {
                        $overPercentage = floor(($total_percentage*100)-10000)/100;
                        return $fail('錯誤：總比率為 '.$total_percentage.'% ,超過 '.$overPercentage.' %');
                    }
                },
            ]
        ]);

        $assignments_percentage = $request->get('assignmentPercentage');

        $assignments_a4_id = $request->get('assignments_a4_id');
        $assignments_attendance_id = $request->get('assignments_attendance_id');
        $assignments_ppt_id = $request->get('assignments_ppt_id');
        $assignments_word_id = $request->get('assignments_word_id');
        $assignments_classParticipation_id = $request->get('assignments_classParticipation_id');

        $year = $request->get('year');
        $semester = $request->get('semester');


        $error_array = array();
        $success_output = '';

        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {

            //index 0 是 A4海報
            for($i=0; $i<count($assignments_a4_id); $i++){

                DB::table('assignments')
                    ->whereIn('id', $assignments_a4_id)
                    ->update(['percentage' => $assignments_percentage[0]]);

                DB::table('assignments')
                    ->whereIn('id', $assignments_attendance_id)
                    ->update(['percentage' => $assignments_percentage[1]]);

                DB::table('assignments')
                    ->whereIn('id', $assignments_ppt_id)
                    ->update(['percentage' => $assignments_percentage[2]]);

                DB::table('assignments')
                    ->whereIn('id', $assignments_word_id)
                    ->update(['percentage' => $assignments_percentage[3]]);

                if ($year == 107 and $semester == 1){
                } else {
                    DB::table('assignments')
                        ->whereIn('id', $assignments_classParticipation_id)
                        ->update(['percentage' => $assignments_percentage[4]]);
                }

                $success_output = '<div class="alert alert-success"> 設定成功！ </div>';

            }
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output,
            'myid' => $assignments_percentage,
        );
        echo json_encode($output);
    }

    public function postEditRemark(Request $request){
        $validation = Validator::make($request->all(), [
            'student_id' => 'required',
            'course_id' => 'required'
        ]);

        $student_id = $request->get('student_id');
        $course_id = $request->get('course_id');
        $remark = $request->get('remark');

        $error_array = array();
        $success_output = '';

        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {
            DB::table('student_course')
                ->where('students_id', $student_id)
                ->where('courses_id', $course_id)
                ->update(['remark' => $remark]);
            $success_output = '<div class="alert alert-success"> 備註成功！ </div>';
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output,
            'remark' => $remark
        );
        echo json_encode($output);
    }

    public function postEditFinalGrade(Request $request){
        $validation = Validator::make($request->all(), [
            'student_id' => 'required',
            'course_id' => 'required'
        ]);

        $student_id = $request->get('student_id');
        $course_id = $request->get('course_id');
        $final_grade = $request->get('finalGrade');

        $error_array = array();
        $success_output = '';

        if ($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {
            DB::table('student_course')
                ->where('students_id', $student_id)
                ->where('courses_id', $course_id)
                ->update(['final_score' => $final_grade]);
            $success_output = '<div class="alert alert-success"> 評分成功！ </div>';
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output,
            'finalGrade' => $final_grade
        );
        echo json_encode($output);
    }

    public function resortStudentAssignment(Collection $student_assignment){
        $temp = collect();

        //第一個作業：口頭報告與PPT
        $key = $student_assignment->search(function ($item, $key) {
            return $item->name == "口頭報告與PPT";
        });

        $temp->push($student_assignment[$key]);
        $student_assignment->forget($key);

        //第二個作業：書面報告Word
        $key = $student_assignment->search(function ($item, $key) {
            return $item->name == "書面報告Word";
        });

        $temp->push($student_assignment[$key]);
        $student_assignment->forget($key);

        //第三個作業：A4海報
        $key = $student_assignment->search(function ($item, $key) {
            return $item->name == "A4海報";
        });

        $temp->push($student_assignment[$key]);
        $student_assignment->forget($key);

        //第四個作業：課堂參與
        $key = $student_assignment->search(function ($item, $key) {
            return $item->name == "課堂參與";
        });

        $temp->push($student_assignment[$key]);
        $student_assignment->forget($key);

        //第五個作業：上課出席
        $key = $student_assignment->search(function ($item, $key) {
            return $item->name == "上課出席";
        });

        $temp->push($student_assignment[$key]);
        $student_assignment->forget($key);

        //其他作業
        while ($student_assignment->count() > 0){
            $temp->push($student_assignment[0]);
            $student_assignment->forget(0);
        }

        return $temp;
    }
}
