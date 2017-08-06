<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('APP_NAME')}} - KIOSK</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="/css/kiosk.css" rel="stylesheet">
    @stack('styles')
</head>

<body id="page-top">


<header class="">
    <div class="header-content ">
        <div class="header-content-inner">
            <h1 id="homeHeading">{{env('APP_NAME')}} - KIOSK</h1>
            <hr>
            <p>Thank you for your support!</p>
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
