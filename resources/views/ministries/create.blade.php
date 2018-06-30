@extends('layouts.admin-template')
@section('title')
    @lang("New Ministry")
@endsection
@section('crumbs')
    <a href="/ministries/admin">@lang("Ministries")</a>
    <a href="#">@lang("New ministry")</a>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("New Ministry")</h5>
            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/ministries/admin">
                    <i class="icon-chevron-left"></i> @lang("back")</a>

                <a href="/ministries/categories" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> @lang("Categories")
                </a>
                <a href="/ministries/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> @lang("New Ministry")
                </a>
            </div>
        </div>
        <div class="card-body">
            {{Form::open(['url'=>'ministries/create'])}}
            <label>@lang("Name")</label>
            {{Form::text('name',null,['required'=>'required','class'=>'col-sm-6'])}}
            <label>@lang("Categories")</label>
            {{Form::select('cat',DB::table('ministry_cats')->pluck('name','id'),null,['class'=>'col-sm-6'])}}
            <label>@lang("Status")</label>
            {{Form::select('active',['1'=>'Posted','0'=>'Draft'],null,['class'=>'col-sm-6'])}}
            <label>@lang("Description")</label>
            {{Form::textarea('desc',null,['required'=>'required','class'=>'col-sm-6'])}}

            <p></p>
            <button class="btn btn-default">@lang("Submit")</button>
            {{Form::close()}}
        </div>
    </div>
@endsection
@include('partials.editor')