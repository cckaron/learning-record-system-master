@extends('layouts.main')

@section('css')
    <link href="{{ URL::to('libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/quill/dist/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/style.min.css') }}" rel="stylesheet" />
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

        @include('layouts.partials.pageBreadCrumb', ['title' => '學生資訊'])

        <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
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

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title p-b-10">基本資訊</h4>
                                <p class="card-text"><strong>姓名 </strong> <span class="p-l-30">{{ $student->users_name }}</span></p>
                                <p class="card-text"><strong>系所 </strong> <span class="p-l-30">{{ $student->department }}</span></p>
                                <p class="card-text"><strong>年級 </strong> <span class="p-l-30">{{ $student->grade }}年{{ $student->class }}班 </span></p>
                                <p class="card-text"><strong>狀態 </strong> <span
                                        @if($student->status == 1)
                                        class="p-l-30" >在學中
                                        @elseif($student->status == 0)
                                            class="p-l-30" style="color: red;">休學
                                        @endif
                                        </span>
                                </p>
                                <p class="card-text"><strong>備註 </strong> <span
                                        @if($student->remark != null)
                                        class="p-l-30" style="color: blue;">
                                            {{ $student->remark }}
                                        @else
                                            class="p-l-30">
                                            無
                                        @endif
                                        </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title p-b-10">統計圖表</h4>
                                {{ $courses }}
                                <br>
                                <br>
                                {{ $common_courses }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title m-b-0">修業歷程</h4>
                            </div>

                            <ul class="list-style-none">
                                <li class="d-flex no-block card-body">
                                    <i class="fa fa-check-circle w-30px m-t-5"></i>
                                    <div>
                                        <a href="#" class="m-b-0 font-medium p-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                                        <span class="text-muted">dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="tetx-right">
                                            <h5 class="text-muted m-b-0">20</h5>
                                            <span class="text-muted font-16">Jan</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex no-block card-body border-top">
                                    <i class="fa fa-check-circle w-30px m-t-5"></i>
                                    <div>
                                        <a href="#" class="m-b-0 font-medium p-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                                        <span class="text-muted">dolor sit amet, consectetur adipiscing</span>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="tetx-right">
                                            <h5 class="text-muted m-b-0">20</h5>
                                            <span class="text-muted font-16">Jan</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

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
                $('.demo').each(function() {
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

                        change: function(value, opacity) {
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

            <script>

                $('#courseAll').DataTable({
                    processing:true,
                    serverSide:true,
                    language: {
                        "processing":   "處理中...",
                        "loadingRecords": "載入中...",
                        "lengthMenu":   "顯示 _MENU_ 項結果",
                        "zeroRecords":  "沒有符合的結果",
                        "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                        "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
                        "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                        "infoPostFix":  "",
                        "search":       "搜尋:",
                        "paginate": {
                            "first":    "第一頁",
                            "previous": "上一頁",
                            "next":     "下一頁",
                            "last":     "最後一頁"
                        },
                        "aria": {
                            "sortAscending":  ": 升冪排列",
                            "sortDescending": ": 降冪排列"
                        }
                    },
                    ajax: '{!! route('get.allStudents') !!}',
                    columns: [
                        { data: 'users_name', name: 'users_name'},
                        { data: 'users_id', name: 'users_id' },
                        { data: 'grade', name: 'grade'},
                        { data: 'class', name: 'class'},
                        { data: 'status', name: 'status'},
                        { data: 'remark', name: 'remark'},
                        { data: 'updated_at', name: 'updated_at'},
                        { data: 'motion', name: 'motion'},
                    ]
                });

            </script>
@endsection
