@extends('layouts.admin-template')

@section('title')
    @lang("Access denied")
@endsection
@section('title-icon')exclamation
@endsection

@section('content')
    <h3>@lang("You do not have permission to access that resource")</h3>
    <h3>@lang("Sorry") :(</h3>
@endsection
