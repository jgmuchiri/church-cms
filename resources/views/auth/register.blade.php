@extends('auth.template')
@section('content')
	@if(env('ALLOW_REGISTRATION')==true)
		<p class="text-center py-2">@lang('REGISTER')</p>
		{{Form::open(['url'=>route('register'),'class'=>'mb-3','id'=>'registerForm', 'novalidate'=>''])}}
		<div class="form-group">
			{{Form::label('last_name',__('First name'),['class'=>'text-muted'])}}
			<div class="input-group with-focus">
				{{Form::text('first_name',null,['class'=>'form-control border-right-0','required'=>'','id'=>''])}}
				<div class="input-group-append">
					<span class="input-group-text fa fa-user text-muted bg-transparent border-left-0"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('last_name',__('Last name'),['class'=>'text-muted'])}}
			<div class="input-group with-focus">
				{{Form::text('last_name',null,['class'=>'form-control border-right-0','required'=>'','id'=>'','placeholder'=>__('Last name')])}}
				<div class="input-group-append">
					<span class="input-group-text fa fa-user text-muted bg-transparent border-left-0"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('email',__('Email'),['class'=>'text-muted'])}}
			<div class="input-group with-focus">
				{{Form::input('email','email',null,['class'=>'form-control border-right-0','required'=>'','id'=>'signupInputEmail1','placeholder'=>__('Email')])}}
				<div class="input-group-append">
					<span class="input-group-text fa fa-envelope text-muted bg-transparent border-left-0"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('password',__('Password'),['class'=>'text-muted'])}}
			<div class="input-group with-focus">
				{{Form::input('password','password',null,['class'=>'form-control border-right-0','id'=>'signupInputPassword1','required'=>'','placeholder'=>'Password'])}}
				<div class="input-group-append">
					<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{Form::label('password_confirmation',__('Password confirmation'),['class'=>'text-muted','id'=>'signupInputRePassword1'])}}
			<div class="input-group with-focus">
				{{Form::input('password','password_confirmation',null,['class'=>'form-control border-right-0','required'=>'','data-parsley-equalto'=>'#signupInputPassword1','placeholder'=>__('Password confirmation')])}}
				<div class="input-group-append">
					<span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
				</div>
			</div>
		</div>
		<div class="checkbox c-checkbox mt-0">
			<label>
				<input type="checkbox" value="" required name="agreed">
				<span class="fa fa-check"></span>
				I agree with the
				<a class="ml-1" href="#">terms</a>
			</label>
		</div>
		<button class="btn btn-block btn-primary mt-3" type="submit">@lang('Register')</button>
		{{Form::close()}}
		<p class="pt-3 text-center">
			<a class="" href="{{route('login')}}">@lang('Login')</a>
		</p>
	@else
		<div class="alert alert-danger">@lang("Registration is not allowed at this time.")</div>
	@endif
@endsection