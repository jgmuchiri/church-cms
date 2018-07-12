@extends('layouts.public')

@section('content')

	<div class="container">
		@if(empty($event))
			<h3>@lang('No events found')</h3>

		@else
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<a href="/events"><i class="fa fa-chevron-circle-left"></i> @lang("back to calendar")</a>
					<h3>{{$event->title}}</h3>
					<hr/>

				</div>
			</div>
			<div class="row">
				<div class="col-md-9 col-md-offset-1">
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
				</div>
			</div>
		@endif
	</div>
@endsection