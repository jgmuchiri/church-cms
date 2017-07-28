@extends('emails.template')
@section('header')
    <h2>Verify Your Email Address</h2>
@endsection
@section('content')
    <p></p>
    Your new account is almost ready! <br/>
    Please follow the link below to verify your email address
    <a href="{{ url('register/verify/' . $confirmation_code) }}">Verify Account</a>.<br/>

    <p>Or copy paste this link to your browser {{ url('register/verify/' . $confirmation_code) }}</p>

@endsection

@section('footer')

    <a href="{{url()->to('/')}}">
       Visit site
    </a>
    @endsection
