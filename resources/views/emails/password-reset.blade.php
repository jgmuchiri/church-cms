@extends('emails.template')
@section('header')
    <h2>@lang("Your password reset link")</h2>
@endsection
@section('content')
    <p></p>
    @lang("You or someone requested to reset account password. If it was not you, it might be that")
    @lang("there was attempt to access the account. Please login and change your password.")

    <a href="{{ url('password/reset/' . $token) }}">@lang("Reset Your Account Password")</a>.<br/>

    <p>@lang("Or copy paste this link to your browser") {{ url('password/reset/' . $token) }}</p>

@endsection
