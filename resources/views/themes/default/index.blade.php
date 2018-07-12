@push('styles')
	<link rel="stylesheet" href="/themes/default/css/style.css"/>
@endpush

@push('styles')
	<link href="{{asset('themes/default/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
		  rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
		  rel='stylesheet' type='text/css'>

	<link href="{{asset('themes/default/css/magnific-popup.css')}}" rel="stylesheet">
	<link href="{{asset('themes/default/css/style.css')}}" rel="stylesheet">

@endpush
@section('body')

	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand js-scroll-trigger" href="/">{{config('app.name')}}</a>
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

	@if(!empty(request()->segment(1)))
		<section id="sermons">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h2 class="section-heading">@yield('title')</h2>
						<hr class="my-4">
					</div>
				</div>
			</div>
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
						{{env('PHONE')}}
					</p>
				</div>
				<div class="col-lg-4 mr-auto text-center">
					<i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
					<p>
						<a href="mailto:your-email@your-domain.com">
							{{env('EMAIL')}}
						</a>
					</p>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<script src="{{asset('themes/default/js/bootstrap.bundle.min.js')}}"></script>

	<script src="{{asset('plugins/jquery.easing.min.js')}}"></script>
	<script src="{{asset('themes/default/js/scrollreveal.min.js')}}"></script>
	<script src="{{asset('themes/default/js/jquery.magnific-popup.min.js')}}"></script>

	<script src="{{asset('themes/default/js/script.min.js')}}"></script>
@endpush