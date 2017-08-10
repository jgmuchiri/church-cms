@if(is_null(theme('location')))
@include('themes.default.index')
@else
@include('themes.'.theme('location').'.index')
@endif
        <!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" xmlns="http://www.w3.org/1999/html"/>
    <meta name="description" content="Church content management system">
    <meta name="title" content="GIVEu - Church content management system">
    <meta name="author" content="A&M Digital Technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('header')

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')

    @if(config('app.env')=='production')
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
    @endif
</head>
<body>
{{--CONTENT BODY--}}
@yield('body')
</body>
{{--SCRIPTS--}}

<script src="/js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/public_js.js"></script>

@yield('footer')
@stack('scripts')
@include('partials.flash')
@stack('modals')
</html>


