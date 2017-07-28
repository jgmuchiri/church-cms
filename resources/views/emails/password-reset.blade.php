@extends('emails.template')
@section('header')
    <h2>Your password reset link</h2>
@endsection
@section('content')
    <p></p>
    You or someone requested to reset account password. If it was not you, it might be that
    there was attempt to access the account. Please login and change your password.

    <a href="{{ url('password/reset/' . $token) }}">Reset Your Account Password</a>.<br/>

    <p>Or copy paste this link to your browser {{ url('password/reset/' . $token) }}</p>

@endsection
