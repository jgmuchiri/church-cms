@extends('layouts.public')
@section('header-title')
    {{$member->name}}
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h3>{{$page->title}}</h3>

                {{$page->content}}
            </div>

            <div class="col-md-3">

            </div>
        </div>
    </div>
@endsection