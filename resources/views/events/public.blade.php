@extends('layouts.public')

@section('title')
	<i class="fa fa-calendar"></i> @lang("Events Calendar")
@endsection

@section('content')
	<style>
		#calendar {
			margin: 0 auto;
		}
	</style>
	<div class="row">
		<div class="col-sm-9">
			<div id='calendar'></div>
		</div>

		<div class="col-sm-3">
			<h5>@lang("Upcoming events")</h5>
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
@endsection

@push('styles')
	<link rel="stylesheet" href="/plugins/fullcalendar/calendar.css"/>
	<link rel="stylesheet" href="/plugins/fullcalendar/fullcalendar.min.css"/>
	<link href="/plugins/jquery-ui/jquery-ui.css" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')

	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="/plugins/fullcalendar/calendar.js"></script>


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
                        url: "{{'/events/'.$event->id}}",
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
                    if (endDate === " - Invalid date") {
                        endDate = '';
                    }
                    $('#modalDate').html(startDate + endDate);

                    $('#modalBody').html(event.desc);
                    if (event.url === "") {
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
                    $('.link').attr('href', 'events/' + event.id);
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
					<h4 id="modalTitle" class="modal-title"></h4>

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
									class="fa fa-times"></i> </span> <span class="sr-only">@lang("close")</span>
					</button>
					<span id="modalDate"></span>
				</div>
				<div id="modalBody" class="modal-body"></div>
				<div class="modal-footer">
					<a type="button" href="#" class="btn btn-primary btn-sm link">@lang("Open")</a>
					<a class="btn btn-primary btn-sm" href="#" id="eventUrl" target="_blank">@lang("Event Page")</a>
					<a class="btn btn-primary btn-sm" href="#" id="eventReg">@lang("Event registration")</a>
					<button type="button" class="btn btn-inverse btn-sm" data-dismiss="modal">@lang("Close")</button>
				</div>
			</div>
		</div>
	</div>
@endpush