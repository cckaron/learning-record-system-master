<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/signIn', [
    'uses' => 'UserAuthController@signInPage',
    'as' => 'auth.signIn',
    ]);

Route::post('/signIn', [
   'uses' => 'UserAuthController@postSignIn',
   'as' => 'auth.signIn'
]);


Route::get('/home', 'HomeController@index')->name('home');



//使用者共用route
Route::group(['prefix' => 'commonCourse', 'middleware' => 'auth'], function(){
    //列出共同課程 (get)
    Route::get('/', [
        'uses' => 'CommonCourseController@getShowCommonCourses',
        'as' => 'courses.showCommonCourses'
    ]);

    //列出 ->課程 (get)
    Route::get('/{common_courses_id}/courses', [
        'uses' => 'CourseController@getShowSingleCourse',
        'as' => 'courses.showSingleCourse'
    ]);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    //User
    Route::get('/index', [
        'uses' => 'MainController@getIndex',
        'as' => 'dashboard.index'
    ]);


    // User Validation
    Route::group(['prefix' => 'auth'], function(){
        // User Login Page
//        Route::get('/sign-in', [
//            'uses' => 'UserAuthController@signInPage',
//            'as' => 'auth.signIn',
//        ]);
        Route::get('/sign-out', [
            'uses' => 'UserAuthController@getSignOut',
            'as' => 'auth.signOut',
        ]);
    });

    Route::get('/passwords', [
        'uses' => 'UserController@getChangePassword',
        'as' => 'user.changePassword',
    ]);

    Route::post('/passwords', [
        'uses' => 'UserController@postChangePassword',
        'as' => 'user.changePassword',
    ]);
});

// 學生 (type = 4)
Route::group(['prefix' => 'student', 'middleware' => 'auth'], function() {

    Route::get('index', [
        'uses' => 'IndexController@getStudentIndex',
        'as' => 'index.student'
    ]);

    //作業
    Route::group(['prefix' => 'assignments', 'middleware' => 'auth'], function(){

        //列出 (get)
        Route::get('/', [
            'uses' => 'AssignmentController@getAssignments',
            'as' => 'assignment.showAssignments'
        ]);
    });

    //交作業
    Route::group(['prefix' => 'commonCourse', 'middleware' => 'auth'], function(){

        //繳交 (get)
        Route::get('{course_id}/assignments/{assignment_id}/handIn', [
            'uses' => 'AssignmentController@getHandInAssignment',
            'as' => 'assignment.handInAssignment'
        ]);

        //繳交 (post)
        Route::post('{course_id}/assignments/{assignment_id}/handIn', [
            'uses' => 'AssignmentController@postHandInAssignment',
            'as' => 'assignment.handInAssignment'
        ]);
    });

    //資訊
    Route::group(['prefix' => 'details', 'middleware' => 'auth'], function (){
       Route::get('{student_id}', [
           'uses' => 'UserController@getStudentDetail',
           'as' => 'user.studentDetail'
       ]);
    });
});


// 教師 (type = 3)
Route::group(['prefix' => 'teacher', 'middleware' => 'auth'], function(){

    Route::get('index', [
        'uses' => 'IndexController@getTeacherIndex',
        'as' => 'index.teacher'
    ]);

    Route::get('correctAssignment', [
        'uses' => 'AssignmentController@getCorrectAssignment',
        'as' => 'teacher.correctAssignment'
    ]);

    Route::get('announcement', [
        'uses' => 'AnnouncementController@getCreateAnnouncement',
        'as' => 'announcement.create'
    ]);

    Route::post('announcement', [
        'uses' => 'AnnouncementController@postCreateAnnouncement',
        'as' => 'announcement.create'
    ]);

    //共同課程
    Route::group(['prefix' => 'commonCourses', 'middleware' => 'auth'], function(){
        //列出 共同課程->課程->作業 (get)
        Route::get('/{common_courses_id}/courses/{courses_id}/assignments/', [
            'uses' => 'AssignmentController@getSingleAssignments_Teacher',
            'as' => 'courses.showSingleAssignments_Teacher'
        ]);

        //列出 作業狀態列表 (get)
        Route::get('/courses/{course_id}/assignments/{assignment_id}/list', [
            'uses' => 'AssignmentController@getStudentAssignmentsList',
            'as' => 'courses.showStudentAssignmentsList'
        ]);

        Route::get('assignments/delete/{id}', [
            'uses' => 'AssignmentController@deleteAssignment',
            'as' => 'assignments.deleteAssignment',
        ]);
    });

    //課程
    Route::group(['prefix' => 'course', 'middleware' => 'auth'], function(){

        //列出 (get)
        Route::get('/', [
            'uses' => 'CourseController@getShowCourses_Teacher',
            'as' => 'courses.showCourses_Teacher'
        ]);
    });

    //作業
    Route::group(['prefix' => 'assignment', 'middleware' => 'auth'], function(){

        //新增 (get)
        Route::get('/new', [
            'uses' => 'AssignmentController@getCreateAssignment',
            'as' => 'Assignment.createAssignment'
        ]);

        //新增 (post)
        Route::post('/new', [
            'uses' => 'AssignmentController@postCreateAssignment',
            'as' => 'Assignment.createAssignment'
        ]);

        //列出 (get)
        Route::get('/', [
            'uses' => 'AssignmentController@getAssignments_Teacher',
            'as' => 'assignment.showAssignments_Teacher'
        ]);

        //開放繳交作業 (get)
        Route::get('/openHandInAssignment/{student_assignment_id}', [
            'uses' => 'AssignmentController@getOpenHandInAssignment',
            'as' => 'assignment.openHandInAssignment'
        ]);

    });

    //成績
    Route::group(['prefix' => 'grade'], function(){
        //列出 (get)
        Route::get('/list', [
            'uses' => 'GradeController@getGradeList',
            'as' => 'grade.showlist'
        ]);

        Route::group(['prefix' => 'ajax'], function(){
            Route::post('/updatePercentage', [
                'uses' => 'GradeController@postUpdatePercentage',
                'as' => 'grade.ajax.updatePercentage'
            ]);
        });


    });
});

// 工讀生 (type = 2)
Route::group(['prefix' => 'employee', 'middleware' => 'auth'], function() {

});

// 秘書 (type = 1)
Route::group(['prefix' => 'secret', 'middleware' => 'auth'], function() {

});


//管理員 (type = 0)
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

    Route::get('announcement', [
        'uses' => 'AnnouncementController@getCreateSystemAnnouncement',
        'as' => 'admin.announcement.create'
    ]);

    Route::post('announcement', [
        'uses' => 'AnnouncementController@postCreateSystemAnnouncement',
        'as' => 'admin.announcement.create'
    ]);

    //共同課程
    Route::group(['prefix' => 'commonCourse', 'middleware' => 'auth'], function(){

        //新增 (get)
        Route::get('/add', [
            'uses' => 'CommonCourseController@getAddCommonCourse',
            'as' => 'common_course.add'
        ]);

        //新增 (post)
        Route::post('/add', [
            'uses' => 'CommonCourseController@postAddCommonCourse',
            'as' => 'common_course.add'
        ]);

        //刪除 (get)
        Route::get('/delete/{id}', [
            'uses' => 'CommonCourseController@deleteCommonCourse',
            'as' => 'commonCourse.delete'
        ]);

        //列出 (get)
        Route::get('/all', [
            'uses' => 'CommonCourseController@getAllCommonCourses' ,
            'as' => 'common_course.showAll'
        ]);

        //修改狀態 (ajax post)
        Route::post('/change/status', [
            'uses' => 'CommonCourseController@postChangeCommonCourseStatus',
            'as' => 'common_courses.changeStatus'
        ]);

        //修改內容 (ajax post)
        Route::post('/change/content', [
            'uses' => 'CommonCourseController@postChangeCommonCourseContent',
            'as' => 'common_courses.changeContent'
        ]);

    });

    //課程
    Route::group(['prefix' => 'course', 'middleware' => 'auth'], function(){

        //新增 (get)
        Route::get('/add', [
            'uses' => 'CourseController@getAddCourse',
            'as' => 'course.addCourse'
        ]);

        //新增 (post)
        Route::post('/add', [
            'uses' => 'CourseController@postAddCourse',
            'as' => 'course.addCourse'
        ]);

        //查看學生名單 (post)
        Route::get('/showCourseStudent/{courses_id}', [
            'uses' => 'CourseController@showCourseStudents',
            'as' => 'course.showCourseStudents'
        ]);

        //退選 (get)
        Route::get('/drop/{courses_id}/{student_id}', [
            'uses' => 'CourseController@dropCourse',
            'as' => 'course.dropCourse'
        ]);

        //刪除 (get)
        Route::get('/delete/{courses_id}', [
            'uses' => 'CourseController@deleteCourse',
            'as' => 'course.delete'
        ]);

        //列出 (get)
        Route::get('/allCourses', [
            'uses' => 'CourseController@getAllCourses' ,
            'as' => 'course.showCourses'
        ]);

        //修改內容 (ajax post)
        Route::post('/change/content', [
            'uses' => 'CourseController@postChangeCourseContent',
            'as' => 'course.changeContent'
        ]);

    });

    //作業
    Route::group(['prefix' => 'assignment', 'middleware' => 'auth'], function(){

        //列出 (get)
        Route::get('/allAssignments', [
            'uses' => 'AssignmentController@getAllAssignments' ,
            'as' => 'assignment.showAllAssignments'
        ]);

        Route::get('/batchCreateAssignments', [
            'uses' => 'AssignmentController@getBatchCreateAssignments',
            'as' => 'assignment.batchCreateAssignments'
        ]);

        Route::post('batchCreateAssignments', [
            'uses' => 'AssignmentController@postBatchCreateAssignments',
            'as' => 'assignment.batchCreateAssignments'
        ]);

        Route::group(['prefix' => 'ajax'], function(){
            Route::post('/updatePercentage', [
                'uses' => 'GradeController@postUpdatePercentage_admin',
                'as' => 'grade.ajax.updatePercentage_admin'
            ]);
        });
    });

    //使用者
    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){

        //新增 (get)
        Route::get('/add', [
            'uses' => 'UserController@getCreateUser',
            'as' => 'user.createUser'
        ]);

        //新增 (post)
        Route::post('/add', [
            'uses' => 'UserController@postCreateUser',
            'as' => 'user.createUser'
        ]);

        //匯入 (get) -> 搭配 dropZone 上傳
        Route::get('/import', [
            'uses' => 'UserController@importUsers',
            'as' => 'user.importUsers'
        ]);

        //列出學生 (get)
        Route::get('students', [
            'uses' => 'UserController@getAllStudents',
            'as' => 'user.getAllStudents'
        ]);

        //修改學生 (ajax post)
        Route::post('student/change/content', [
            'uses' => 'UserController@postChangeStudentContent',
            'as' => 'student.changeContent'
        ]);

        //刪除學生 (get)
        Route::get('/student/delete/{id}', [
            'uses' => 'UserController@deleteStudent',
            'as' => 'user.deleteStudent'
        ]);

        //列出老師 (get)
        Route::get('teachers', [
            'uses' => 'UserController@getAllTeachers',
            'as' => 'user.getAllTeachers'
        ]);

        //修改老師 (ajax post)
        Route::post('teacher/change/content', [
            'uses' => 'UserController@postChangeTeacherContent',
            'as' => 'teacher.changeContent'
        ]);


        //列出TA (get)
        Route::get('ta', [
            'uses' => 'UserController@getAllTAs',
            'as' => 'user.getAllTAs'
        ]);

        //修改TA (ajax post)
        Route::post('ta/change/content', [
            'uses' => 'UserController@postChangeTAContent',
            'as' => 'ta.changeContent'
        ]);

        //列出秘書 (get)
        Route::get('secrets', [
            'uses' => 'UserController@getAllSecrets',
            'as' => 'user.getAllSecrets'
        ]);

        //修改秘書 (ajax post)
        Route::post('secret/change/content', [
            'uses' => 'UserController@postChangeSecretContent',
            'as' => 'secret.changeContent'
        ]);

        //刪除老師 (get)
        Route::get('/teacher/delete/{id}', [
            'uses' => 'UserController@deleteTeacher',
            'as' => 'user.deleteTeacher'
        ]);

        //刪除TA (get)
        Route::get('/ta/delete/{id}', [
            'uses' => 'UserController@deleteTAs',
            'as' => 'user.deleteTA'
        ]);

        //刪除秘書 (get)
        Route::get('/secret/delete/{id}', [
            'uses' => 'UserController@deleteSecret',
            'as' => 'user.deleteSecret'
        ]);
    });



});

// data tables
Route::group(['prefix' => 'datatables', 'middleware' => 'auth'], function(){
    Route::get('/user', [
        'uses' => 'CourseController@getUsers_dt',
        'as' => 'get.courseUsers'
    ]);

    Route::get('/allCommonCourses', [
        'uses' => 'CommonCourseController@getAllCommonCourses_dt',
        'as' => 'get.allCommonCourses'
    ]);

    Route::get('/allCourses', [
        'uses' => 'CourseController@getAllCourses_dt',
        'as' => 'get.allCourses'
    ]);

    Route::get('/allAssignments', [
       'uses' => 'AssignmentController@getAllAssignments_dt',
       'as' => 'get.allAssignments'
    ]);

    Route::get('allStudents', [
        'uses' => 'UserController@getAllStudents_dt',
        'as' => 'get.allStudents'
    ]);

    Route::get('allTeachers', [
        'uses' => 'UserController@getAllTeachers_dt',
        'as' => 'get.allTeachers'
    ]);
});

// dropZone
Route::group(['prefix' => 'dropZone'], function() {
    Route::group(['prefix' => 'upload'], function() {
        Route::post('/assignments', [
            'uses' => 'AssignmentController@uploadAssignment',
            'as' => 'dropZone.uploadAssignment',
        ]);

        Route::post('/excels/student', [
            'uses' => 'UserController@uploadStudents',
            'as' => 'dropZone.uploadStudents',
        ]);

        Route::post('/excels/teacher', [
            'uses' => 'UserController@uploadTeachers',
            'as' => 'dropZone.uploadTeachers',
        ]);

        Route::post('excels/course', [
            'uses' => 'ExcelController@importCourse',
            'as' => 'dropZone.importCourse'
        ]);

        Route::post('excels/grade', [
            'uses' => 'ExcelController@importGrade',
            'as' => 'dropZone.importGrade'
        ]);
    });

    Route::post('/delete', [
        'uses' => 'AssignmentController@deleteAssignmentFile',
        'as' => 'dropZone.deleteAssignment',
    ]);

    Route::post('/fileDetails', [
        'uses' => 'AssignmentController@getAssignmentFileDetail',
        'as' => 'dropZone.getAssignmentFileDetail'
    ]);

    Route::get('/download/{first}/{second}/{third}/{fourth}', [
        'uses' => 'AssignmentController@downloadAssignment',
        'as' => 'dropZone.downloadAssignment'
    ]);
});

//blade ajax
Route::group(['prefix' => 'ajax'], function(){
   Route::post('correctAssignment', [
       'uses' => 'AssignmentController@correctAssignment',
       'as' => 'ajax.correctAssignment'
   ]);

   Route::post('/signClass', [
       'uses' => 'CourseController@signClass_ajax',
       'as' => 'ajax.signClass'
   ]);

   Route::post('/openHandInAssignment', [
       'uses' => 'AssignmentController@openHandInAssignment',
       'as' => 'ajax.openHandInAssignment'
   ]);
});

Route::group(['prefix' => 'download'], function (){
   Route::get('assignment/{student_id}/{assignment_id}', [
       'uses' => 'ZipController@downloadZIP',
       'as' => 'download.zip'
   ]);
});
