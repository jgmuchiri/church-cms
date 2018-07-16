<!DOCTYPE html>
<html>
<head>
	<title>{{config('app.name')}}</title>
	<meta charset="utf-8">
	<meta name="format-detection" content="telephone=no" xmlns="http://www.w3.org/1999/html"/>
	<meta name="description" content="Church content management system">
	<meta name="title" content="GIVEu - Church content management system">
	<meta name="author" content="A&M Digital Technologies">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	@yield('header')

	<link href="{{asset('themes/default/css/magnific-popup.css')}}" rel="stylesheet">

	<link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
	<link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">

	<link href="{{asset('themes/default/css/style.css')}}" rel="stylesheet">

	{{--use @push('stylesheed') to add stylesheets here--}}
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

            ga('create', '{{config('google.analytics')}}', 'auto');
            ga('send', 'pageview');
		</script>
	@endif

</head>
<body>

{{--top navigation--}}
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	<div class="container">
		<a class="" href="/">
			<img src="/img/logo-single.png" style="height:40px;"/>
			{{config('app.name')}}
		</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
				data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
				aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="/ministries">@lang('Ministries')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="/sermons">@lang('Sermons')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="/events">@lang('Events')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="/blog">@lang('Blog')</a>
				</li>
				<li class="nav-item">
					@if(Auth::check())
						<a class="nav-link js-scroll-trigger" href="/dashboard">@lang('Account')</a>
					@endif
				</li>
				<li class="nav-item">
					@if(Auth::check())
						<a class="nav-link js-scroll-trigger" href="/logout">@lang('Logout')</a>
					@else
						<a class="nav-link js-scroll-trigger" href="/login">@lang('Login')</a>
					@endif
				</li>
				{{--{!! theme()->menu() !!}--}}
			</ul>
		</div>
	</div>
</nav>
{{--end top navigation--}}

{{--homepage content--}}
@if(!empty(request()->segment(1)))
	<section>
		@hasSection('title')
			<div class="container page-title">
				<h4 class="">@yield('title')</h4>
			</div>
		@endif

		<div class="container">
			@yield('content')
		</div>
	</section>
@else
	<header class="masthead text-center text-white d-flex">
		<div class="container my-auto">
			<div class="row">
				<div class="col-lg-12 mx-auto">
					@yield('content')
				</div>
			</div>
		</div>
	</header>
@endif

{{--Contact us--}}
<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 mx-auto text-center">
				<h2 class="section-heading">@lang('Get in touch')</h2>
				<hr class="my-4">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 ml-auto text-center">
				<i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
				<p>
					{{config('app.company.phone')}}
				</p>
			</div>
			<div class="col-lg-4 mr-auto text-center">
				<i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
				<p>
					<a href="mailto:{{config('app.company.email')}}">
						{{config('app.company.email')}}
					</a>
				</p>
			</div>
		</div>
	</div>
</section>

{{--SCRIPTS--}}
<script src="{{asset('js/jquery.min.js')}}"></script>

<script src="{{asset('themes/default/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('plugins/jquery.easing.min.js')}}"></script>
<script src="{{asset('themes/default/js/scrollreveal.min.js')}}"></script>
<script src="{{asset('themes/default/js/jquery.magnific-popup.min.js')}}"></script>

{{--you need this to re-use some of the functions--}}
<script src="{{asset('themes/default/js/script.js')}}"></script>

@yield('footer')
@stack('scripts')
@include('partials.flash')
@stack('modals')
</body>
</html>