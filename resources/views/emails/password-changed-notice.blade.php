@extends('emails.template')
@section('header')
    <h2>@lang("Your password was changed")</h2>
@endsection
@section('content')
    @lang("This is to notify you that your account password was recently changed.")

    <p>
        @lang("If this was not you, please reset your password immediately.")

        <br/>
        <a href="{{url()->to('/login')}}">@lang("Click here to login")</a>
    </p>

@endsection
