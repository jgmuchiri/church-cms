@extends('emails.template')

@section('content')

    <strong>@lang("Hello"), {{$first_name}}</strong>
    <p>@lang("Thank you for your generous giving").</p>

    <p>@lang("We have processed your contribution"):</p>
        <hr/>
    {{$desc}}
       -  {{config('app.currency.symbol').number_format($amount,2)}}

<hr/>
    <p>@lang("You can login to your account to see transaction history")</p>

    @lang("Thank you once again").

    <p>
        <br/>
        @lang("Sincerely"),
        <br/>
        @lang("Your friends at")<br/>
        {{config('app.name')}}
    </p>
@endsection