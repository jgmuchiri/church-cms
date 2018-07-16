@extends('layouts.public')

@section('title')
	{{$event->title}}
@endsection

@section('content')

	<div class="row">
		<div class="col-md-11 col-md-offset-1">
			<a href="/events"><i class="fa fa-chevron-circle-left"></i> @lang("back to calendar")</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-9 col-md-offset-1">
			@if(sezeof($event)>0)
				@lang('No events found')
			@else
				<div class="row">
					<div class="col-sm-6">
						@if($event->start)
							@lang("From"): <i class="fa fa-clock-o"></i>
							{{date('d-M-Y H:ia',strtotime($event->start))}}
						@endif
					</div>
					<div class="col-sm-6">
						@if($event->end)
							@lang("To"): <i class="fa fa-clock-o"></i>
							{{date('d-M-Y H:ia',strtotime($event->end))}}
						@endif
					</div>
				</div>
				<p> {!! $event->desc !!}</p>
				<br/>
				@if(!empty($event->url))
					<a href="{{$event->url}}" target="_blank"><i class="fa fa-external-link"></i> @lang("More")
						...</a>
				@endif

				<p><br/>
					@if(!empty($event->registration))
						<a href="/events/{{$event->id}}/register"><i class="fa fa-pencil-square-o"></i>
							@lang("Register for this event")</a>
					@endif
				</p>
			@endif
		</div>
	</div>
@endsection