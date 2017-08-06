@extends('layouts.template')
@section('title')
    System Settings
@endsection
@section('content')
    <div class="row-fluid">
        @include('admin.settings-menu')

        <div class="span10">
            <div class="widget-box no-top">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
                    <h5>Settings</h5>
                    <div class="buttons">

                    </div>
                </div>
                <div class="widget-content">
                    <div class="alert content-alert alert-danger alert-white rounded">
                        {{--<a href="#" class="close"><i class="icon-times-circle-o"></i> </a>--}}
                        <div class="icon">
                            <i class="icon-warning"></i>
                        </div>
                        <p class="category small">
                            All site configurations are managed in <code>.evn</code> file located in the root
                            of your application.<br/>
                            <span class="text-danger">
                    Change these settings only if you know what you are doing!
                </span>
                        </p>
                    </div>
                    <div class="alert alert-danger">
                        {!! Form::open(['url'=>'settings/backup']) !!}
                        <button class="btn btn-warning"><i class="icon-database"></i> Backup First!</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! Form::open() !!}
                            {!! Form::textarea('envContent',$envContent,['rows'=>20,'class'=>'span12']) !!}
                            <button class="btn btn-default"><i class="icon-save"></i> Update</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <hr/>
                    {!! Form::open(['url'=>'settings/logo','method'=>'post','files'=>'true']) !!}
                    <label>Upload logo </label>

                    <img class="thumbnail" src="/images/logo.png"
                         style="width:300px;"/>

                    {{Form::file('logo')}}
                    <hr/>

                    <button class="btn btn-success">Update</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>

@endsection
