@extends('auth.template')
@section('content')
	<p class="text-center py-2">@lang('FORGOT PASSWORD')</p>
	{!! Form::open(['url'=>'password/email/','id'=>'loginForm','class'=>'mb-3'])!!}
	@lang("Enter your e-mail address below and we will send you instructions")

	<div class="form-group">
		<div class="input-group with-focus">
			<input class="form-control border-right-0" id="exampleInputEmail1" type="email"
				   placeholder="@lang('Enter email')" autocomplete="off" required>
			<div class="input-group-append">
				<span class="input-group-text fa fa-envelope text-muted bg-transparent border-left-0"></span>
			</div>
		</div>
	</div>
	<button class="btn btn-block btn-primary mt-3" type="submit">@lang('Submit')</button>

	<a class="btn btn-block btn-secondary" href="{{route('register')}}">@lang('Login')</a>
	{{Form::close()}}
@endsection