@extends('emails.template')
@section('header')

@endsection
@section('content')

    <h2 style="font-size: 22px;line-height: 28px;margin: 0 0 12px 0;">
        @lang("Here is your password reset link")
    </h2>
    <p>@lang("You or someone has requested to reset password at") {{env('APP_NAME')}}</p>
    <a class="button" href="{{url()->to('password/reset/'.$token)}}">@lang("Click here 
        to reset your password")</a>
    <br>

    @lang("If you did not make this request, please visit") {{url()->to('/')}} @lang("and update your password")

@endsection