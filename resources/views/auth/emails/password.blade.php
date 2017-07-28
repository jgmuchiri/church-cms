@extends('emails.template')
@section('header')

@endsection
@section('content')

    <h2 style="font-size: 22px;line-height: 28px;margin: 0 0 12px 0;">
        Here is your password reset link
    </h2>
    <p>You or someone has requested to reset password at {{env('COMPANY_NAME')}}</p>
    <a class="button" href="{{url()->to('password/reset/'.$token)}}">Click here to
        to reset your password</a>
    <br>

    If you did not make this request, please visit {{url()->to('/')}} and update your password

@endsection