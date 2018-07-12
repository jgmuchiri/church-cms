@extends('layouts.admin-template')
@section('title')
    @lang("Events list")
@endsection
@section('crumbs')
    <a href="/events/admin">@lang("Events")</a>
    <a href="#">@lang("Events list")</a>
@endsection

@section('content')

    <div class="card card-default">
        <div class="card-header">
            <div class="buttons">
                <a class="btn btn-info btn-sm" href="/events/admin"><i class="fa fa-chevron-left"></i>
                    @lang('back to calendar')</a>
                <a class="btn btn-info btn-sm newEventBtn" data-toggle="modal" data-target="#new-event" href="#"><i
                            class="fa fa-plus"></i>
                    @lang('New event')</a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="get" class="form-inline">
                <div class="input-group">
                    <input name="s" placeholder="Search" class="form-control">
                    <span class="input-group-btn">
                                <button class="btn btn-inverse">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    @if(isset($_GET['s']))
                        <span class="input-group-btn">
                                <a class="btn btn-danger" href="/events/list"><i class="fa fa-times-circle"></i>
                                    close search</a></span>
                    @endif
                </div>
            </form>
            <table class="table table-striped">
                @foreach($events as $event)
                    <tr>
                        <td colspan="3">
                            <h4>{{$event->title}}</h4>

                            <a href="/events/{{$event->id}}" target="_blank">
                                <i class="fa fa-external-link"></i>
                            </a>
                            <a href="/events/{{$event->id}}/edit">
                                <i class="fa fa-pencil-square"></i>
                            </a>
                            <a href="/events/delete/{{$event->id}}">
                                <i class="fa fa-trash-o"></i> </a>
                        </td>
                        <td>
                            <strong class="label label-info">@lang("Start"):</strong>
                            <span class="label label-success">{{date('d, M y H:i',strtotime($event->start))}}</span>
                            <strong class="label label-info">@lang("End"): </strong>
                            <span class="label label-success">{{date('d, M y H:i',strtotime($event->end))}}</span>
                        </td>
                        <td>
                            <p>{!! strip_tags($event->desc) !!}</p>
                            <a href="{{$event->url}}">{{$event->url}}</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$events->render()}}
        </div>
    </div>


@endsection