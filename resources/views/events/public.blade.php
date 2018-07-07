@extends('layouts.public')

@section('content')
    <style>
        #calendar {
            margin: 0 auto;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <br/>
                <h3><i class="fa fa-calendar"></i> @lang("Events Calendar")</h3>

                <div id='calendar'></div>
            </div>

            <div class="col-md-2 col-md-offset-1">
                <h4>@lang("Upcoming events")</h4>
                <ul class="list-group">
                    @foreach($latestEvents as $event)
                        <li class="list-group-item">
                            <a href="/events/{{$event->id}}">{{$event->title}}</a><br/>
                            <em class="small">{{date('d, M y H:i',strtotime($event->start))}}</em>
                        </li>
                    @endforeach
                </ul>
                {{$latestEvents->render()}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <link rel="stylesheet" href="/plugins/fullcalendar/calendar.css"/>

    @if(env('APP_ENV')=='local')
        <link rel="stylesheet" href="/plugins/fullcalendar/fullcalendar.min.css"/>
        {{--<link href="/plugins/jquery-ui/jquery-ui.css" type="text/css" rel="stylesheet"/>--}}

        {{--<script src="/pugins/jquery-ui/jquery-ui.min.js"></script>--}}
        <script src="/plugins/moment/moment.min.js"></script>
        <script src="/plugins/fullcalendar/fullcalendar.min.js"></script>
    @else
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
        {{--<link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet"/>--}}
        {{--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>--}}
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    @endif


    <script type="text/javascript">
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '{{date('Y-m-d')}}',
                selectable: true,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: [
                        @foreach($events as $event)
                    {
                        id: "{{$event->id}}",
                        title: "{{$event->title}}",
                        start: '{{$event->start}}',
                        ends: '{{$event->end}}',
                        url: "{{$event->url}}",
                        desc: '{!! preg_replace('/\'/', "", str_limit($event->desc,400,'...')) !!}',
                        registration: '{{$event->registration}}'
                    },
                    @endforeach
                ],
                eventClick: function (event, jsEvent, view) {
                    $('#modalTitle').html(event.title);

                    var s = moment(event.start);
                    var startDate = s.format("D,MMMM YYYY, h:mmA");

                    var e = moment(event.ends);
                    var endDate = ' - ' + e.format("D,MMMM YYYY, h:mmA");
                    if (endDate == " - Invalid date") {
                        endDate = '';
                    }
                    $('#modalDate').html(startDate + endDate);

                    $('#modalBody').html(event.desc);
                    if (event.url == "") {
                        $('#eventUrl').addClass('hide');
                    } else {
                        $('#eventUrl').removeClass('hide');
                        $('#eventUrl').attr('href', event.url);
                    }
                    //registration
                    if (event.registration == 0 || event.registration == "") {
                        $('#eventReg').addClass('hide');
                    } else {
                        $('#eventReg').removeClass('hide');
                        $('#eventReg').attr('href', 'events/' + event.id + '/register');
                    }
                    $('.link').attr('href','events/'+event.id);
                    $('#eventData').modal();
                    return false;
                }
            });

        });
    </script>
    <div id="eventData" class="modal hide">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                    class="fa fa-times"></i> </span> <span class="sr-only">@lang("close")</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                    <span id="modalDate"></span>
                </div>
                <div id="modalBody" class="modal-body"></div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-primary link">@lang("Open")</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Close")</button>
                    <a class="btn btn-primary" id="eventUrl" target="_blank">@lang("Event Page")</a>
                    <a class="btn btn-primary" id="eventReg">@lang("Register to Event")</a>
                </div>
            </div>
        </div>
    </div>
@endpush