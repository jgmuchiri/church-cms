@extends('emails.template')

@section('content')

    <strong>Hello,</strong>
    <p>New user has been registered in your Stripe Account.</p>

    <p>You can see their information is your Stripe Account Dashboard</p>

    <p>
        <br/>
        System generated email. Do not reply.
        <br/>
        <strong>{{env('COMPANY_NAME')}}</strong>
    </p>
@endsection