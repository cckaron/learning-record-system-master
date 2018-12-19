@extends('layouts.main')

@section('css')
    <link href="{{ URL::to('libs/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('libs/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('libs/quill/dist/quill.snow.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('css/style.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')

    @include('layouts.partials.preloader')

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

    @include('layouts.partials.header')

    @include('layouts.partials.leftSidebar')

    <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

        @include('layouts.partials.pageBreadCrumb', ['title' => '所有課程'])

        <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <form action="{{ route('course.addCourse') }}" method="post">

                    <!-- editor -->
                    <div class="row">

                        @if(session()->has('message'))
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">提示</h5>

                                        <div class="alert alert-success" role="alert">
                                            {{ session()->get('message') }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="margin-bottom: 20px"> 進行中的作業</h4>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>作業名稱</th>
                                                <th>隸屬共同課程</th>
                                                <th>課程</th>
                                                <th>學年</th>
                                                <th>學期</th>
                                                <th>指導教師</th>
                                                <th>開課日期</th>
                                                <th>結課日期</th>
                                                <th>上次修改時間</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @for($i=0; $i<count($assignments_processing_id); $i++)
                                                <tr>
                                                    <td>
                                                        {{ $assignments_processing_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $common_course_processing_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_processing_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_processing_year[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_processing_semester[$i] }}
                                                    </td>
                                                    <td>
                                                        @for($j=0; $j<count($teachers_processing[$i]); $j++)
                                                            {{ $teachers_processing[$i][$j] }}
                                                            @if($j!=count($teachers_processing[$i])-1)
                                                                , @endif <!-- 逗號 -->
                                                        @endfor
                                                    </td>
                                                    <td>
                                                        {{ $courses_processing_start_date[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_processing_start_date[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $assignments_processing_update_at[$i] }}
                                                    </td>

                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="margin-bottom: 20px"> 已結束的作業</h4>
                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>作業名稱</th>
                                                <th>隸屬共同課程</th>
                                                <th>課程</th>
                                                <th>學年</th>
                                                <th>學期</th>
                                                <th>指導教師</th>
                                                <th>開課日期</th>
                                                <th>結課日期</th>
                                                <th>上次修改時間</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @for($i=0; $i<count($assignments_finished_id); $i++)
                                                <tr>
                                                    <td>
                                                        {{ $assignments_finished_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $common_course_finished_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_finished_name[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_finished_year[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_finished_semester[$i] }}
                                                    </td>
                                                    <td>
                                                        @for($j=0; $j<count($teachers_finished[$i]); $j++)
                                                            {{ $teachers_finished[$i][$j] }}
                                                            @if($j!=count($teachers_finished[$i])-1)
                                                                , @endif <!-- 逗號 -->
                                                        @endfor
                                                    </td>
                                                    <td>
                                                        {{ $courses_finished_start_date[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $courses_finished_start_date[$i] }}
                                                    </td>
                                                    <td>
                                                        {{ $assignments_finished_update_at[$i] }}
                                                    </td>

                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                    {{ csrf_field() }}
                </form>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Chun-Kai Kao. Technical problem please contact: cg.workst@gmail.com
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

@endsection

@section('scripts')
    <script src="{{ URL::to('libs/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::to('js/pages/mask/mask.init.js') }}"></script>
    <script src="{{ URL::to('libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::to('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ URL::to('libs/jquery-asColor/dist/jquery-asColor.min.js') }}"></script>
    <script src="{{ URL::to('libs/jquery-asGradient/dist/jquery-asGradient.js') }}"></script>
    <script src="{{ URL::to('libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js') }}"></script>
    <script src="{{ URL::to('libs/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
    <script src="{{ URL::to('libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::to('libs/quill/dist/quill.min.js') }}"></script>

    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $('.demo').each(function () {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function (value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-start').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-end').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

    </script>

    {{--<script>--}}

    {{--$('#courseAll').DataTable({--}}
    {{--processing:true,--}}
    {{--serverSide:true,--}}
    {{--ajax: '{!! route('get.allAssignments') !!}',--}}
    {{--columns: [--}}
    {{--{ data: 'name', name: 'name'},--}}
    {{--{ data: 'start_date', name: 'start_date'},--}}
    {{--{ data: 'end_date', name: 'end_date'},--}}
    {{--{ data: 'updated_at', name: 'updated_at'},--}}
    {{--]--}}
    {{--});--}}

    {{--</script>--}}

    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

@endsection
