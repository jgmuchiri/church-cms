<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #ff3407;
                display: table;
                font-weight: 100;
                background: #0c0f20;
                font-family: 'Lato';

            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <img src="/img/logo.png" style="width:200px"/>
                <div class="title">@yield('title')</div>
                <div class="">@yield('content')</div>
            </div>
        </div>
    </body>
</html>
