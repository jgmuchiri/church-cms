@extends('layouts.template')
@section('title')
    Events list
@endsection
@section('crumbs')
    <a href="/events/admin">Events</a>
    <a href="#">Events list</a>
@endsection

@section('content')

    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5>Events list</h5>

            <div class="buttons">
                <a class="btn btn-info btn-mini" href="/events/admin"><i class="icon-chevron-left"></i>
                    back to calendar</a>
                <a class="btn btn-info btn-mini newEventBtn" data-toggle="modal" data-target="#new-event" href="#"><i
                            class="icon-plus"></i>
                    create event</a>
            </div>
        </div>
        <div class="widget-content">
            <form action="" method="get" class="form-inline">
                <div class="input-group">
                    <input name="s" placeholder="Search" class="form-control">
                    <span class="input-group-btn">
                                <button class="btn btn-default">
                                    <i class="icon-search"></i>
                                </button>
                            </span>
                    @if(isset($_GET['s']))
                        <span class="input-group-btn">
                                <a class="btn btn-danger" href="/events/list"><i class="icon-times-circle"></i>
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
                                <i class="icon-external-link"></i>
                            </a>
                            <a href="/events/{{$event->id}}/edit">
                                <i class="icon-pencil-square"></i>
                            </a>
                            <a href="/events/delete/{{$event->id}}">
                                <i class="icon-trash-o"></i> </a>
                        </td>
                        <td>
                            <strong class="label label-info">Start:</strong>
                            <span class="label label-success">{{date('d, M y H:i',strtotime($event->start))}}</span>
                            <strong class="label label-info">End: </strong>
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