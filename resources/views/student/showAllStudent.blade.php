@extends('layouts.main')

@section('css')
    <link href="{{ URL::to('libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('libs/quill/dist/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/style.min.css') }}" rel="stylesheet" />

    <style>
        input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
            -webkit-box-sizing:border-box;
            -moz-box-sizing: border-box;
        }

    </style>
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

        @include('layouts.partials.pageBreadCrumb', ['title' => '所有學生'])

        <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <!-- editor -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered display" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>姓名</th>
                                            <th>學號</th>
                                            <th>更新資料</th>
                                            <th>系所</th>
                                            <th>年級</th>
                                            <th>班級</th>
                                            <th>聯絡電話</th>
                                            <th>Email</th>
                                            <th>狀態</th>
                                            <th>備註</th>
                                            <th>最近登入時間</th>
                                            <th>動作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)
                                            <tr align="center">
                                                <td id="name">{{ $student->users_name }}</td>
                                                <td id="userID">{{ $student->users_id }}</td>
                                                <td id="profileUpdated">
                                                    @if($student->profileUpdated)
                                                        已更新
                                                    @else
                                                        <p style="color: red">尚未更新</p>
                                                    @endif
                                                </td>
                                                <td id="department">{{ $student->department }}</td>
                                                <td id="grade">{{ $student->grade }}</td>
                                                <td id="myclass">{{ $student->class }}</td>
                                                <td id="phone">{{ $student->user->phone }}</td>
                                                <td id="email">{{ $student->user->email }}</td>
                                                <td id="status" data-status="{{ $student->status }}">
                                                    @if($student->status == 1)
                                                        在學
                                                    @elseif($student->status == 2)
                                                        退學
                                                    @elseif($student->status == 3)
                                                        已畢業
                                                    @elseif($student->status == 0)
                                                        休學
                                                    @endif
                                                </td>
                                                <td id="remark">{{ $student->remark }}</td>
                                                <td>
                                                    @if($student->user->last_login_at != null)
                                                        {{ $student->user->last_login_at->diffForHumans() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.studentDetail', ['id' => $student->users_id]) }}" class="btn btn-info btn-md">
                                                        學生詳情
                                                    </a>
                                                    <button name="add" class="btn btn-primary" data-toggle="modal" data-target="#changeModal" type="submit" data-id="{{ $student->users_id }}">
                                                        編輯
                                                    </button>
                                                    <a href="{{ route('user.deleteStudent', ['id' => $student->users_id]) }}" class="btn btn-danger btn-md" onclick="return confirm('該學生資料將會一併刪除，確定刪除?')">
                                                        刪除
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- start ajax correct assignment window-->
                    <div id="changeModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" id="change_form">
                                    <div class="modal-header">
                                        <h4 class="modal-title">編輯學生資料</h4>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ csrf_field() }}
                                        <span id="form_output"></span>
                                        <div class="form-group">
                                            <label>姓名</label>
                                            <input type="text" id="modal_name" name="name" class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label>學號</label>
                                            <input type="text" id="modal_change_id" name="change_id" class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label>系所</label>
                                            <input type="text" id="modal_department" name="department" class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label>年級</label>
                                            <input type="text" id="modal_grade" name="grade" class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label>班級</label>
                                            <input type="text" id="modal_class" name="class" required>
                                        </div>
                                        <div class="form-group">
                                            <label>聯絡電話</label>
                                            <input type="text" id="modal_phone" name="phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" id="modal_email" name="email" class="form-control" />
                                        </div>
                                        <div class="form-group row">
                                            <label>狀態</label>
                                            <select id="modal_status" name="status" class="form-control m-t-15" style="height: 36px;width: 100%;" required>
                                                <option value=0> 休學</option>
                                                <option value=1> 在學 </option>
                                                <option value=2> 退學 </option>
                                                <option value=3> 已畢業 </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>備註</label>
                                            <input type="text" id="modal_remark" name="remark" class="form-control"/>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="modal_id" name="id" value="" />
                                        <input type="submit" name="submit" id="action" value="確認" class="btn btn-info">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end ajax correct assignment window -->
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
                All Rights Reserved by Chun-Kai Kao. Technical problem please contact: cckaron28@gmail.com
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

        var table = $('#zero_config').DataTable({
            aaSorting: [[1, 'asc'],[2, 'asc']],
            autoWidth: false,
            buttons: [
                {
                    extend: 'colvis',
                    text: '顯示/隱藏欄位',
                    // columns: ':gt(0)'
                    // this will make first column cannot be hided
                },
                {
                    extend: 'copy',
                    title: '所有學生',
                    text: '複製表格內容',
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'excelHtml5',
                    title: '所有學生',
                    filename: '所有學生',
                    text: '匯出 excel',
                    bom : true,
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        //modify text in [A1]
                        $('c[r=A1] t', sheet).text( '所有學生' );
                    }
                },
                {
                    extend: 'csv',
                    title: '所有學生',
                    filename: '所有學生',
                    text: '匯出 csv',
                    exportOptions: {
                        columns: ':visible'
                    },
                    bom: true
                },
                {
                    extend: 'print',
                    title: '所有學生',
                    filename: '所有學生',
                    text: '列印/匯出PDF',
                    exportOptions: {
                        columns: ':visible'
                    },
                },
            ],
            dom: 'lBfrtip',
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "全部"]],
            columnDefs: [
                { "width": "5%", "targets": 0 },
                { "width": "5%", "targets": 1 },
                { "width": "10%", "targets": 2 },
                { "width": "5%", "targets": 3 },
                { "width": "5%", "targets": 4 },
                { "width": "5%", "targets": 5 },
                { "width": "10%", "targets": 6 },
                { "width": "10%", "targets": 7 },
                { "width": "5%", "targets": 8 },
                { "width": "10%", "targets": 9 },
                { "width": "10%", "targets": 10 },
                { "width": "20%", "targets": 11 },
            ],
            language: {
                "processing":   "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu":   "顯示 _MENU_ 項結果",
                "zeroRecords":  "沒有符合的結果",
                "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix":  "",
                "search":       "搜尋全部:",
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

        });

        // Setup - add a text input to each footer cell
        $('#zero_config tfoot th').each( function () {
            var title = $(this).text();
            // $(this).html( '<input type="text" placeholder="搜尋 '+title+' 欄位" />' );
            $(this).html( '<input type="text" placeholder="搜尋" />' );

        } );

        var r = $('#zero_config tfoot tr');
        r.find('th').each(function(){
            $(this).css('padding', 8);
        });
        // $('#zero_config thead').append(r);
        r.appendTo($('#zero_config thead'));

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

    </script>

    <script>
        $('#toggle_event_editing button').click(function(){

            /* reverse locking status */
            $('#toggle_event_editing button').eq(0).toggleClass('locked_inactive locked_active btn-light btn-primary');
            $('#toggle_event_editing button').eq(1).toggleClass('unlocked_inactive unlocked_active btn-primary btn-light');
        });
    </script>

    <script>
        var form = '#change_form';

        $("#changeModal").on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var student = button.parent().parent();
            var name = student.children('#name').html();
            var userID = student.children('#userID').html();
            var department = student.children('#department').html();
            var grade = student.children('#grade').html();
            var myclass = student.children('#myclass').html();
            var phone = student.children('#phone').html();
            var email = student.children('#email').html();
            var status = student.children('#status').attr('data-status');
            var remark = student.children('#remark').html();

            $('#modal_name').val(name);
            $('#modal_id').val(userID);
            $('#modal_change_id').val(userID);
            $('#modal_department').val(department);
            $('#modal_grade').val(grade);
            $('#modal_class').val(myclass);
            $('#modal_phone').val(phone);
            $('#modal_email').val(email);

            var option = "#modal_status option[value="+status+"]";
            $(option).attr('selected', 'selected');
            $('#modal_status').val(status);


            $('#modal_remark').val(remark);

            $(form).off().on('submit', function(event){
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url:'{{ route('student.changeContent') }}',
                    method:"POST",
                    data:form_data,
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.error.length > 0)
                        {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                            }
                            $('#form_output').html(error_html);
                        }
                        else
                        {
                            $('#form_output').html(data.success);
                            student.children('#name').html(data.name);
                            student.children('#userID').html(data.id);
                            student.children('#department').html(data.department);
                            student.children('#grade').html(data.grade);
                            student.children('#myclass').html(data.class);
                            student.children('#phone').html(data.phone);
                            student.children('#email').html(data.email);

                            //modal's id should be changed after post
                            $('#modal_id').val(data.id);

                            if (data.status === '0'){
                                student.children('#status').html('休學');
                            } else if (data.status === '1' ){
                                student.children('#status').html('在學');
                            } else if (data.status === '2'){
                                student.children('#status').html('退學');
                            } else if (data.status === '3'){
                                student.children('#status').html('已畢業');
                            }

                            student.children('#remark').html(data.remark);


                        }
                    }
                })
            });
        });


    </script>
@endsection
