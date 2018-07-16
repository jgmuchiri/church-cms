@extends('emails.template')

@section('content')
    <h2 style="font-size: 22px;line-height: 28px;margin: 0 0 12px 0;">
@lang("Please confirm your account")
    </h2>
    @lang("Welcome to") {{config('app.name')}}!
    <p>@lang("Your account has been registered but we need you to take one final step to insure")
        @lang("someone else is not")
        @lang"(trying to sign up using your email").</p>
    <a href="{{ url('register/verify/' . $confirmation_code) }}" class="button">@lang("Verify Account")</a>
    <br>
    <p>@lang("Or copy paste this link to your browser") {{ url('register/verify/' . $confirmation_code) }}</p>


    @lang("If you did not sign up, please disregard this email or contact us at")
    {{config('mail.from.address')}}

@endsection
