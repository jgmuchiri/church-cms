@extends('layouts.public')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <a href="/events"><i class="icon-chevron-circle-left"></i> back to calendar</a>
                <h3>{{$event->title}}</h3>
                <hr/>

            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="row">
                    <div class="col-sm-6">
                        @if($event->start)
                            From: <i class="icon-clock-o"></i>
                            {{date('d-M-Y H:ia',strtotime($event->start))}}
                        @endif
                    </div>
                    <div class="col-sm-6">
                        @if($event->end)
                            To: <i class="icon-clock-o"></i>
                            {{date('d-M-Y H:ia',strtotime($event->end))}}
                        @endif
                    </div>
                </div>
                <p> {!! $event->desc !!}</p>
                <br/>
                @if($event->url)
                    <a href="{{$event->url}}" target="_blank"><i class="icon-external-link"></i> More...</a>
                @endif

                <p><br/>
                    @if($event->registration)
                        <a href="/events/{{$event->id}}/register"><i class="icon-pencil-square-o"></i> Register for
                            this
                            event</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection