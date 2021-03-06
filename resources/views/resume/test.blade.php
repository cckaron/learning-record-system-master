<!DOCTYPE html>
<html>

<head>
    <title>Desktop_HD</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/resume/css/bundle.css') }}">

    <style>
        .DesktopHd {
            background-image: url('{{ URL::to('/resume/images/background.png') }}');
            background-size: cover;
            position: relative;
            width: 564px;
            height: 814px;
            font-family: HanyiSentyTang;
            font-weight: 400;
            line-height: normal;
            color: #00193F;
        }

        .Title {
            width: 490px;
            height: 38px;
            position: absolute;
            top: 231px;
            left: 35px;
            font-size: 23px;
            letter-spacing: 0;
        }

        .Title- {
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 1px;
            left: 14px;
        }

        .Title-1 {
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 485px;
        }

        .Row1 {
            background-color: #C9D7FF;
            width: 485px;
            height: 30px;
            position: absolute;
            top: 386px;
            left: 40px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row1- {
            position: absolute;
            top: 5px;
            left: 54px;
        }

        .Row1-1 {
            position: absolute;
            top: 5px;
            left: 216px;
        }

        .Row3 {
            background-color: #C9D7FF;
            width: 485px;
            height: 30px;
            position: absolute;
            bottom: 337px;
            left: 40px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row3- {
            position: absolute;
            top: 5px;
            left: 54px;
        }

        .Row3-1 {
            position: absolute;
            top: 5px;
            left: 216px;
        }

        .Row5 {
            background-color: #C9D7FF;
            width: 485px;
            height: 30px;
            position: absolute;
            bottom: 276px;
            left: 40px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row5- {
            position: absolute;
            top: 4px;
            left: 54px;
        }

        .Row5-1 {
            position: absolute;
            top: 4px;
            left: 216px;
        }

        .Row7 {
            background-color: #C9D7FF;
            width: 485px;
            height: 30px;
            position: absolute;
            bottom: 216px;
            left: 40px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row7- {
            position: absolute;
            top: 5px;
            left: 54px;
        }

        .Row7-1 {
            position: absolute;
            top: 4px;
            left: 216px;
        }

        .DesktopHd- {
            font-size: 23px;
            letter-spacing: 4.8px;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 275px;
            left: 48px;
        }

        .DesktopHd-1 {
            font-size: 23px;
            letter-spacing: 0;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 309px;
            left: 48px;
        }

        .DesktopHd-sign {
            position: absolute;
            bottom: 90px;
            left: 48px;
            width: 116px;
        }

        .Row {
            width: 485px;
            height: 20px;
            position: absolute;
            top: 361px;
            left: 94px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row- {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .Row-1 {
            position: absolute;
            top: 0px;
            left: 164px;
        }

        .Row2 {
            width: 485px;
            height: 20px;
            position: absolute;
            bottom: 372px;
            left: 94px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row2- {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .Row2-1 {
            position: absolute;
            top: 0px;
            left: 164px;
        }

        .Row4 {
            width: 485px;
            height: 20px;
            position: absolute;
            bottom: 312px;
            left: 94px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row4- {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .Row4-1 {
            position: absolute;
            top: 0px;
            left: 164px;
        }

        .Row6 {
            width: 485px;
            height: 21px;
            position: absolute;
            bottom: 251px;
            left: 94px;
            font-size: 14px;
            letter-spacing: 0.8px;
        }

        .Row6- {
            position: absolute;
            top: 1px;
            left: 0px;
        }

        .Row6-1 {
            position: absolute;
            top: 4px;
            left: 161px;
        }

        .DesktopHd-logo {
            position: absolute;
            top: 24px;
            left: 140px;
            width: 285px;
        }

        .Footer {
            width: 348px;
            height: 114px;
            position: absolute;
            bottom: 93px;
            left: 183px;
        }

        .Footer- {
            font-size: 27px;
            letter-spacing: 0;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .Manager {
            width: 331px;
            height: 37px;
            position: absolute;
            top: 39px;
            left: 0px;
            font-size: 27px;
        }

        .Manager- {
            letter-spacing: 0;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .Manager-1 {
            letter-spacing: 20px;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 0px;
            left: 128px;
        }

        .Date {
            width: 280px;
            height: 35px;
            position: absolute;
            bottom: 0px;
            left: 0px;
            font-size: 24px;
            letter-spacing: 0;
        }

        .Date- {
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.50);
            position: absolute;
            top: 1px;
            left: 0px;
        }
    </style>
    <style>
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
    </style>

</head>
<body>

<div style="padding-bottom: 30px">
    <button id="btnDownload" type="button" class="button">下載履歷</button>
</div>

<div class='DesktopHd' id="captureSection">
    <div class='Title'>
        <p class='Title-'>
            輔仁大學商業管理學士學位學程產業創新學習履歷
        </p>
        <img class='Title-1' src='{{ URL::to('/resume/images/__.svg') }}'>
    </div>
    <p class='DesktopHd-'>
        {{ $student->users_name }} 君 {{ $courses[0]->year - 1 }} 年度入學至今，完成{{ count($courses) }}項
    </p>
    <p class='DesktopHd-1'>
        「產業創新」報告，共{{ count($courses)*2 }}學分，表現優異特此證明。<br>

    </p>
    <img class='DesktopHd-sign' src='{{ URL::to('/resume/images/sign.png')  }}'>
    @foreach($courses as $key => $course)
        @if($key==0)
            <div class='Row'>
                <p class='Row-'>
                    {{ $course -> common_course_name }}
                </p>
                <p class='Row-1'>
                    {!! $course -> topic !!}
                </p>
            </div>
        @else
            <div class='Row{{$key}}'>
                <p class='Row{{$key}}-'>
                    {{ $course -> common_course_name }}
                </p>
                <p class='Row{{$key}}-1'>
                    {!! $course -> topic !!}
                </p>
            </div>
        @endif
    @endforeach
    <img class='DesktopHd-logo' src='{{ URL::to('/resume/images/logo.png') }}'>
    <div class='Footer'>
        <p class='Footer-'>
            輔仁大學商業管理學士學位學程
        </p>
        <div class='Manager'>
            <p class='Manager-'>
                主任
            </p>
            <p class='Manager-1'>
                顧 宜 錚
            </p>
        </div>
        <div class='Date'>
            @php($year = \Carbon\Carbon::now()->year - 1911)
            <p class='Date-'>
                中華民國 {{ $year }} 年 {{ Carbon\Carbon::now()->month }} 月 {{ Carbon\Carbon::now()->day }} 日
            </p>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    var download = document.getElementById('btnDownload');

    download.onclick = function(){
        html2canvas(document.getElementById('captureSection')).then(function(canvas) {
            var a = document.createElement('a');
            // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
            a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
            a.download = '學習履歷.jpg';
            a.click();
        });
    };


</script>
