<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 15px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }

            .date{
                font-size: 20px;
                font-weight: 600;
                letter-spacing: 3px;
            }
            .text{
                margin-top:-1rem;
            }

            .text p {
                font-size:2rem;
                font-weight:500;
                letter-spacing:3px;
            }

            .time{
                font-size:60px;
                display:flex;
                justify-content :center;
                align-items:center;
            }
            .time span:not(:last-child){
                position: relative;
                margin:0px 5px;
                font-weight: 600;
                letter-spacing: 3px;
            }
            .time span:last-child{
                background: rgb(17 167 255);
                font-size: 23px;
                font-weight: 600;
                text-transform: uppercase;
                color: #fff;
                margin-top:5px;
                border-radius:3px;
                padding: 1px 4px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="datetime m-b-md">
                    <div class="date">
                        <span id="dayname">Day</span>,
                        <span id="daynum">00</span>
                        <span id="month">Month</span>
                        <span id="year">Year</span>
                    </div>
                    <div class="time">
                        <span id="hour">00</span>:
                        <span id="minutes">00</span>:
                        <span id="seconds">00</span>
                        <span id="period">AM</span>
                    </div>
                </div>
                <div class="text">
                    <p>Sistem Absensi Pegawai ({{ config("app.name") }})</p>
                </div>
            </div>
        </div>

        <script type="text/javascript">
             function updateClock(){
                var now = new Date();
                var dname = now.getDay(),
                    mo = now.getMonth(),
                    dnum = now.getDate(),
                    yr = now.getFullYear(),
                    hou = now.getHours(),
                    min = now.getMinutes(),
                    sec = now.getSeconds(),
                    pe = "AM";


                if(hou == 0){
                    hou = 12;
                }

                if(hou > 12){
                    hou = hou - 12;
                    pe = "PM"
                }

                Number.prototype.pad = function (digits) {
                    for(var n = this.toString(); n.length < digits; n = 0 + n);
                    return n;
                }

                var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Desember"];
                var week = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
                var ids = ["dayname", "daynum", "month", "year", "hour", "minutes", "seconds", "period"];
                var values = [week[dname], dnum.pad(2), months[mo], yr, hou.pad(2), min.pad(2), sec.pad(2), pe]

                for (var i = 0; i < ids.length; i++){
                    document.getElementById(ids[i]).firstChild.nodeValue = values[i];
                }
                setTimeout(updateClock, 1000)
            }

            updateClock();

            
        </script>

    </body>
</html>