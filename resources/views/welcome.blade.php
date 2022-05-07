<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CTF-Platform</title>

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
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        .satodsan-uvemopag h1 {
            color: #636b6f;
            font-size: 60px;
            overflow: hidden;
            font-weight: 200;
            border-right: .17em solid #e29508;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .1em;
            animation:
                typing 1.8s steps(30, end),
                blink-caret 1s step-end infinite;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: orange }}

        .let-me-in {
            opacity: 0;
            transition: 1s;
            animation: swim 2s 1;
            animation-fill-mode: forwards;
            animation-delay: 1.8s;
        }

        @keyframes swim{
            0%{ opacity:0; }
            100% { opacity:1; }
        }

        @media screen and (max-width: 500px){
            .satodsan-uvemopag h1 {
                font-size: 33px;
            }
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="content">
            <div class="satodsan-uvemopag">
                <h1>Добро пожаловать!</h1>
            </div>
            <div class="title m-b-md">
                <a class="let-me-in" href="{{ route('login') }}" style="text-decoration:none; color:#636b6f;">Войти</a>
            </div>
        </div>
    @endif
</div>
</body>
</html>
