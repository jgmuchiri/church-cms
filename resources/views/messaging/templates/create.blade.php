@extends('layouts.admin-template')
@section('crumbs')
    <a href="#">@lang("New message template")</a>
    @endsection

@section('content')

    <a href="/templates" class="btn btn-inverse"><i class="fa fa-chevron-circle-left"></i> @lang("Back")</a>

    <div class="row">
        <div class="card card-default">
            <div class="card-header bg_lg"><span class="icon"><i class="fa fa-signal"></i></span>
                <h5>@lang("Create a message template")</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    @if(isset($template))
                        {{Form::model($template,['url'=>'templates/'.$template->id.'/edit'])}}
                    @else
                        {{Form::open(['url'=>'templates'])}}
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <label>@lang("Name")</label>
                            {{Form::text('name',null,['required'=>'required'])}}
                        </div>
                        <div class="col-sm-6">
                            <label>@lang("Status")</label>
                            {{Form::select('active',['1'=>'Active','0'=>'Disabled'])}}
                        </div>
                    </div>
                    <label>@lang("Description")</label>
                    {{Form::text('desc',null,['required'=>'required'])}}
                    <label>@lang("Content")</label>
                    {{Form::textarea('body',null,['class'=>'editor'])}}
                    <br/>
                    <button class="btn btn-inverse">@lang("Submit")</button>
                    {{Form::close()}}
                </div>
            </div>

        </div>
    </div>

@endsection
@include('partials.tinymce')