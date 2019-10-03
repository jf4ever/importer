<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
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
                width: 90%;
                padding: 0 20px;
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

            .main-btns{
                text-align: center;
                margin: 10px;
            }

            button,
            .main-btns a:visited,
            .main-btns a:hover,
            .main-btns a{
                display: inline-block;
                padding: 10px 20px;
                text-decoration: none;
                color: #d4d4d4;
                background: #1d643b;
                border-radius: 5px;
            }

            .item_list_row{
                width: 100%;
                display: grid;
                border-top: #c4c4c4 1px solid;
                grid-template-columns: 50px auto 100px 100px;
            }
        </style>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="main-btns">
                    <a href="/">Главная</a>
                    <a href="/imports">Импорт</a>
                </div>
                @yield('content')
            </div>
        </div>
    </body>
</html>
