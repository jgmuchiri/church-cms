<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{config('app.name')}} - {{strtoupper(__("kiosk"))}}</title>

    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="/css/kiosk.css" rel="stylesheet">
    @stack('styles')
</head>

<body id="page-top">


<header class="">
    <div class="header-content ">
        <div class="header-content-inner">
            <h1 id="homeHeading">{{config('app.name')}} - {{strtoupper(__("kiosk"))}}</h1>
            <hr>
            <p>@lang("Thank you for your support!")</p>
            @yield('content')
        </div>
    </div>
</header>
<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script src="/plugins/numeraljs/numeral.min.js" type="text/javascript"></script>
<script src="/js/kiosk.js" type="text/javascript"></script>
@include('partials.flash')
@stack('scripts')
@stack('modals')
</body>
</html>
