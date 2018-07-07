@extends('layouts.admin-template')
@section('title')
    @lang("Templates")
@endsection

@section('content')

    <a href="/messaging/admin" class="btn btn-default"><i class="fa fa-inbox"></i> @lang("Messaging")</a>
    <a href="/templates/create" class="btn btn-default"><i class="fa fa-plus"></i> @lang("New template")</a>
    <div class="card card-default">
        <div class="card-header"><span class="icon"><i class="fa fa-th"></i></span>
            <h5>@lang("Message templates")</h5>
        </div>
        <div class="card-body nopadding">
            <table class="table table-striped " id="table">
                <tr>
                    <th>@lang("Name")</th>
                    <th>@lang("Description")</th>
                    <td>@lang("Status")</td>
                    <td></td>
                </tr>
                @foreach($templates as $temp)
                    <tr>
                        <td>{{$temp->name}}</td>
                        <td>{{$temp->desc}}</td>
                        <td>{!! ($temp->active==1)?'<span class="label label-success">Active</span>':'<span class="label label-danger">Disabled</span>' !!}</td>
                        <td>
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Copy to start new message"
                               href="/messaging/admin?tmp={{$temp->id}}"><i class="fa fa-copy"></i> </a>
                            <a class="btn btn-default btn-sm" data-toggle="tooltip" title="Edit"
                               href="/templates/{{$temp->id}}/edit"><i class="fa fa-pencil"></i> </a>
                            <a class="btn btn-danger btn-sm delete" data-toggle="tooltip" title="Delete"
                               href="/templates/delete/{{$temp->id}}"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$templates->render()}}
        </div>
    </div>

@endsection