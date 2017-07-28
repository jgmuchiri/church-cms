@extends('layouts.template')
@section('title')
    User Roles
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span2 btn-icon-pg">
            @include('admin.settings-menu')
        </div>
    <div class="span10">
            <div class="widget-box">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-lock"></i></span>
                    <h5>User Roles</h5>
                </div>
                <div class="widget-content" >
                    <div class="row-fluid">
                        <div class="span8">
                            <table class="table table-striped table-full-width">
                                <tr>
                                    <th>Name</th>
                                    <th>Display name</th>
                                    <th>Description</th>
                                </tr>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->display_name}}</td>
                                        <td>{{$role->description}}</td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="span4">
                            <h4><i class="icon-plus"></i> New Role</h4>
                            {!! Form::open(['url'=>'/roles']) !!}
                            <label>Slug</label>
                            {!! Form::text('name') !!}
                            <label>Display name</label>
                            {!! Form::text('display_name') !!}
                            <label>Description</label>
                            {!! Form::textarea('description',null,['rows'=>2]) !!}
                            <br/>
                            <button class="btn btn-default">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection