@extends('layouts.admin-template')
@section('title')
	<i class="fa fa-calendar"></i> @lang("Events Calendar")
@endsection

@section('content')
	<div class="card card-default">

		<div class="card-header">

			<div class="buttons">
				<a href="/events/church-schedule" class="btn btn-warning btn-sm">
					<i class="icon fa fa-calendar"></i> @lang("Sunday Schedule")
				</a>

				<a class="btn btn-info btn-sm newEventBtn" data-toggle="modal" data-target="#new-event" href="#"><i
							class="fa fa-plus"></i>
					@lang("create event")</a>
				<a class="btn btn-inverse btn-sm" href="/events/list"><i class="fa fa-list"></i>
					@lang("events list")</a>

			</div>
		</div>

	</div>
	<div class="card card-default">
		<div class="card-body">
			@if(Request()->segment(2)=="list")
			@else
				<div id='calendar' style="background-color: #fff;"></div>
			@endif
		</div>
	</div>
@endsection

@push('styles')

	<link rel="stylesheet" href="/plugins/fullcalendar/calendar.css"/>
	<link rel="stylesheet" href="/plugins/fullcalendar/fullcalendar.min.css"/>
	<link href="/plugins/jquery-ui/jquery-ui.css" type="text/css" rel="stylesheet"/>

@endpush

@push('scripts')

	<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="/plugins/moment/moment.min.js"></script>
	<script src="/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="/plugins/fullcalendar/calendar.js"></script>

@endpush

@push('modals')
	<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">@lang("Register a user")</h4>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<span id="start-date"></span>
					<span id="end-date"></span>
					<br/>
					<span id="desc"></span>
					<br/>
					<span id="eventUrl"></span>
					<span id="registerUrl"></span>
				</div>
				<div class="modal-footer">
					<span id="eventPage"></span>
					<span id="editEvent"></span>
					<span id="deleteEvent"></span>
					<button type="button" class="btn btn-inverse" data-dismiss="modal">@lang("Close")</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal hide" id="new-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">@lang("New Event")</h4>

				</div>
				{{Form::open(['url'=>'events','id'=>'new-event-form'])}}
				<div class="modal-body">
					<div class="row">
						{{Form::text('title',null,['placeholder'=>'Event Title','required'=>'required','class'=>'col-sm-12'])}}
						<br/>

						<div class="row">
							<div class="col-sm-6">
								<label>@lang("Start date")</label>
								{{Form::input('date','start',null,['placeholder'=>'Start','required'=>'required','class'=>'col-sm-12'])}}
							</div>
							<div class="col-sm-6" id="e-start-time">
								<label>@lang("Start time")</label>
								{{Form::input('time','startTime',null,['placeholder'=>'Start','class'=>'col-sm-12'])}}
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<label>@lang("Status")</label>
								{{Form::select('status',['active'=>'Active','private'=>'Private'],null,['class'=>'col-sm-12'])}}
							</div>
							<div class="col-sm-6">
								{{Form::checkbox('allDay')}} <label>@lang("All day")?</label>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<label>@lang("End date")</label>
								{{Form::input('date','end',null,['placeholder'=>'End','class'=>'col-sm-12'])}}
							</div>
							<div class="col-sm-6" id="e-end-time">
								<label>@lang("End time")</label>
								{{Form::input('time','endTime',null,['placeholder'=>'End','class'=>'col-sm-12'])}}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								{{Form::textarea('desc',null,['placeholder'=>'Description','rows'=>3,'class'=>'col-sm-12'])}}

								<label>
									{{Form::checkbox('registration',1,false)}}
									@lang("This event requires registration")?
								</label>
								{{Form::text('form_id',null,['placeholder'=>'Paste Google form link','class'=>'col-sm-12', 'style'=>'display:none'])}}
								<br/>
								{{Form::text('url',null,['placeholder'=>'Event external link','class'=>'col-sm-12'])}}
								<br/>

							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default">@lang("Save")</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
						Close
					</button>
				</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
@endpush
