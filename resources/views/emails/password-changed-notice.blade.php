@extends('emails.template')
@section('header')
    <h2>Your password was changed</h2>
@endsection
@section('content')
    This is to notify you that your account password was recently changed.

    <p>
        If this was not you, please reset your password immediately.

        <br/>
        <a href="{{url()->to('/login')}}">Click here to login</a>
    </p>

@endsection
