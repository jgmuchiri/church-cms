<!doctype html>
<html lang="en">
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="UTF-8"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/admin.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', '{{env('GOOGLE_ANALYTICS')}}', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body id="login">

<div id="loginbox">

    <div class="control-group normal_text"><h3><img style="" src="/img/admin-logo.png"></h3></div>
    {!! Form::open(['url'=>'login','method'=>'post','class'=>'form-vertical','id'=>'loginform']) !!}

    <div class="control-group">
        <div class="controls">
            <div class="main_input_box">
                <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                <input id="email" type="email" name="email" placeholder="Enter e-mail address"
                       value="" autofocus>
            </div>
        </div>
    </div>

    <div class="control-group ">
        <div class="controls">
            <div class="main_input_box">
                <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                <input id="password" type="password" name="password" placeholder="Enter password">
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4 offset1 checkbox">
            <input type="checkbox" name="remember"> @lang("Remember Me")
        </div>
    </div>

    <div class="form-actions">
        <span class="pull-left"><a href="#" class="flip-link btn btn-info to-recover">@lang("Lost password?")</a></span>
        <span class="pull-right"><button class="btn btn-success">@lang("Login")</button> </span>
    </div>

    <div class="row-fluid">
        <div class="span6 offset5" style="color:#fff">
            No account?
            <a href="#" class="to-register btn btn-warning btn-mini">@lang("Register")</a>
        </div>
    </div>

    {!! Form::close() !!}

    {!! Form::open(['url'=>'password/email/','id'=>'recoverform','class'=>'form-vertical'])!!}

    <div class="controls"><p class="">
            @lang("Enter your e-mail address below and we will send you instructions how to recover a")
            @lang("password.")
        </p>
        <div class="main_input_box">
            <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
            <input placeholder="E-mail address" name="email" type="email">
        </div>
    </div>

    <div class="form-actions">
            <span class="pull-left">
                <a href="#" class="flip-link btn btn-success to-login">&laquo; Back to login</a>
            </span>
        <span class="pull-right">
            <button class="btn btn-success">@lang("Recover")</button>
        </span>
    </div>
    {!! Form::close() !!}


    {!! Form::open(['url'=>'register','id'=>'registerform','class'=>'form-vertical payment-form']) !!}
    @if(env('ALLOW_REGISTRATION')==true)
        <span class="payment-errors"></span>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                    {{Form::text('first_name',null,['required'=>'required','autofocus'=>'autofocus','placeholder'=>'Firstname'])}}
                </div>
            </div>
        </div>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                    {{Form::text('last_name',null,['required'=>'required','autofocus'=>'autofocus','placeholder'=>'Lastname'])}}
                </div>
            </div>
        </div>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-envelope"> </i></span>
                    {{Form::input('email','email',null,['required'=>'required','placeholder'=>'Email'])}}
                </div>
            </div>
        </div>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-th"> </i></span>
                    {{Form::text('phone',null,['placeholder'=>'Phone number'])}}
                </div>
            </div>
        </div>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                    {{Form::text('username',null,['required'=>'required','placeholder'=>'Username'])}}
                </div>
            </div>
        </div>
        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-lock"> </i></span>
                    {{Form::input('password','password',null,['required'=>'required','placeholder'=>'Password'])}}
                </div>
            </div>
        </div>

        <div class="control-group ">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-lock"> </i></span>
                    {{Form::input('password','password_confirmation',null,['required'=>'required','placeholder'=>'Confirm password'])}}
                </div>
            </div>
        </div>
        <br/>

        <div class="form-actions">
        <span class="pull-left">
            <a href="#" class="flip-link btn btn-success to-login">&laquo; Back to login</a>
        </span>
            <span class="pull-right"><button class="btn btn-success">@lang("Submit")</button> </span>
        </div>
    @else
        <div class="alert alert-danger">@lang("Registration is not allowed at this time.")</div>
    @endif

    {{Form::close()}}

</div>

<br/>
<br/>
<br/>
<div class="row-fluid">
    <div class="span6 offset5">
        &copy;
        <script>document.write(new Date().getFullYear())</script>
        <a href="#">{{env('APP_NAME')}}</a>
        by
        <a href="http://amdtllc.com" target="_blank">@lang("A&M Digital Technologies")</a>
    </div>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/login.js"></script>
@include('partials.flash')
</body>

</html>
