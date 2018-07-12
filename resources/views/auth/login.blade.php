@extends('auth.template')
@section('content')
	<p class="text-center py-2">@lang('LOGIN')</p>
	{{Form::open(['url'=>route('login'),'id'=>'loginForm', 'novalidate'=>'', 'class'=>'mb-3'])}}
	<div class="form-group">
		<div class="input-group with-focus">
			{{Form::input('email','email',null,['class'=>'form-control border-right-0','placeholder'=>__('Enter email'),'required'=>''])}}
			<div class="input-group-append">
				<span class="input-group-text fa fa-envelope text-muted bg-transparent border-left-0"></span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group with-focus">
			{{Form::input('password','password',null,['class'=>'form-control border-right-0','placeholder'=>__('Enter password'),'required'=>''])}}
			<div class="input-group-append">
				<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<div class="checkbox c-checkbox float-left mt-0">
			<label>
				<input type="checkbox" value="" name="remember">
				<span class="fa fa-check"></span>@lang('Remember Me')</label>
		</div>
		<div class="float-right to-recover"><a class="text-muted" href="{{route('password.forgot')}}">
				@lang("Lost password?")
			</a>
		</div>
	</div>
	<button class="btn btn-block btn-primary mt-3" type="submit">@lang('Login')</button>

	<p class="pt-3 text-center">@lang('No account?')
		<a href="{{route('register')}}">@lang('Register')</a>
	</p>
	{{Form::close()}}
@endsection