@extends('emails.template')
@section('header')
	<h2>@lang("Your account information was updated")</h2>
@endsection
@section('content')
	@lang("This is to notify you that your account information was recently changed")
	<p>
		@lang("If this was not you, please reset your password immediately.")
		<br/>
		<a href="{{url()->to('/login')}}">@lang("Click here to login")</a>
	</p>
@endsection
