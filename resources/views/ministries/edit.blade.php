@extends('layouts.admin-template')
@section('title')
    @lang("Update Ministry")
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("Update Ministry')"</h5>
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
            {{Form::model($ministry,['url'=>'ministries/update'])}}
            {{Form::hidden('id',$ministry->id)}}

            <label>@lang("Name")</label>
            {{Form::text('name',null,['required'=>'required','class'=>'col-sm-6'])}}
            <label>@lang("Categories")</label>
            {{Form::select('cat',DB::table('ministry_cats')->pluck('name','id'),null,['class'=>'col-sm-6'])}}
            <label>@lang("Status")</label>
            {{Form::select('active',['1'=>__("Posted"),'0'=>__("Draft")],null,['class'=>'col-sm-6'])}}
            <label>@lang("Description")</label>
            {{Form::textarea('desc',null,['required'=>'required','class'=>'col-sm-6'])}}

            <p></p>
            <button class="btn btn-default">@lang("Submit")</button>
            {{Form::close()}}
        </div>
    </div>
@endsection
@push('scripts')

@endpush
@include('partials.tinymce')