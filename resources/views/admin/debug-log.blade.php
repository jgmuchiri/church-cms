@extends('layouts.template')
@section('title')
    Debug log
@endsection
@section('crumbs')
    <a href="#" class="current">Debug log</a>
@endsection

@section('content')
    <div class="row-fluid">
        @include('admin.settings-menu')

        <div class="span10">
            {!! Form::open(['url'=>route('empty-debug-log')]) !!}
            <textarea name="logContent" style="width:100%" class="controls" rows="20">{!! $logContent !!}</textarea>
            <br/>
            <button class="btn btn-danger">Empty log</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
