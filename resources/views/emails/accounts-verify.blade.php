@extends('emails.template')
@section('header')
    <h2>@lang("Verify Your Email Address")</h2>
@endsection
@section('content')
    <p></p>
    @lang("Your new account is almost ready!") <br/>
   @lang("Please follow the link below to verify your email address")
    <a href="{{ url('register/verify/' . $confirmation_code) }}">@lang("Verify Account")</a>.<br/>

    <p>@lang("Or copy paste this link to your browser") {{ url('register/verify/' . $confirmation_code) }}</p>

@endsection

@section('footer')

<<<<<<< HEAD
    <a href="{{ url('register/verify/' . $confirmation_code) }}">
       Veriify account
=======
    <a href="{{url()->to('/')}}">
       @lang("Visit site")
>>>>>>> translated accounts-verify.blade.php
    </a>
    @endsection
