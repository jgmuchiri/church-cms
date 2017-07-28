@extends('layouts.template')
@section('title')
    Update Ministry
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>Update Ministry</h5>
            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/ministries/admin">
                    <i class="icon-chevron-left"></i> back</a>

                <a href="/ministries/categories" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> Categories
                </a>
                <a href="/ministries/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> New Ministry
                </a>
            </div>
        </div>
        <div class="widget-content">
            {{Form::model($ministry,['url'=>'ministries/update'])}}
            {{Form::hidden('id',$ministry->id)}}

            <label>Name</label>
            {{Form::text('name',null,['required'=>'required','class'=>'span6'])}}
            <label>Categories</label>
            {{Form::select('cat',DB::table('ministry_cats')->pluck('name','id'),null,['class'=>'span6'])}}
            <label>Status</label>
            {{Form::select('active',['1'=>'Posted','0'=>'Draft'],null,['class'=>'span6'])}}
            <label>Description</label>
            {{Form::textarea('desc',null,['required'=>'required','class'=>'span6'])}}

            <p></p>
            <button class="btn btn-default">Submit</button>
            {{Form::close()}}
        </div>
    </div>
@endsection
@push('scripts')

@endpush
@include('partials.tinymce')