@extends('emails.template')

@section('content')

    <strong>Hello, {{$first_name}}</strong>
    <p>Thank you for your generous giving.</p>

    <p>We have processed your contribution:</p>
        <hr/>
    {{$desc}}
       -  {{env('CURRENCY_SYMBOL').number_format($amount,2)}}

<hr/>
    <p>You can login to your account to see transaction history</p>

    Thank you once again.

    <p>
        <br/>
        Sincerely,
        <br/>
        Your friends at<br/>
        {{env('COMPANY_NAME')}}
    </p>
@endsection