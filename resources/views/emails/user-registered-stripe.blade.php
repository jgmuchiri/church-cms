@extends('emails.template')

@section('content')

    <strong>@lang("Hello"),</strong>
    <p>@lang("New user has been registered in your Stripe Account").</p>

    <p>@lang("You can see their information is your Stripe Account Dashboard")</p>

    <p>
        <br/>
        @lang("System generated email"). @lang("Do not reply").
        <br/>
        <strong>{{config('app.name')}}</strong>
    </p>
@endsection