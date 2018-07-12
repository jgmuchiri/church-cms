@extends('layouts.admin-template')
@section('title')
	@lang('Events Calendar')
@endsection

@section('content')
	<div class="card card-default">
		<div class="card-header bg_lg">
			<div class="buttons">
				<a class="btn btn-inverse btn-sm" href="/events/admin">
					<i class="fa fa-chevron-left"></i>
					@lang('back to calendar')
				</a>

				<a class="btn btn-inverse btn-sm" href="/events/list">
					<i class="fa fa-list"></i>
					@lang('events list')
				</a>
			</div>
		</div>
		<div class="card-body">

			{{Form::model($event,['url'=>'events/'.$event->id.'/edit'])}}
			{{Form::text('title',null,['placeholder'=>'Event Title','required'=>'required','class'=>'form-control'])}}

			<div class="row">
				<div class="col-sm-6">
					{{Form::label('status',__('Status'))}}
					{{Form::select('status',['active'=>'Active','private'=>'Private'],null,['class'=>'form-control'])}}
				</div>
				<div class="col-sm-4">
					{{Form::checkbox('allDay')}} <label>@lang("All day")?</label>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					{{Form::label('start',__('Start'))}}
					{{Form::input('date','start',date('Y-m-d',strtotime($event->start)),['class'=>'form-control','required'=>'required'])}}
				</div>
				<div class="col-sm-6" id="e-start-time">
					{{Form::label('startTime',__('Start'))}}
					{{Form::input('time','startTime',date('H:i',strtotime($event->start)),['class'=>'form-control'])}}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					{{Form::label('end',__('End'))}}
					{{Form::input('date','end',date('Y-m-d',strtotime($event->end)),['class'=>'form-control'])}}
				</div>
				<div class="col-sm-6">
					{{Form::label('endTime',__('End'))}}
					{{Form::input('time','endTime',date('H:i',strtotime($event->end)),['class'=>'form-control'])}}
				</div>
			</div>

			{{Form::label('desc',__('Description'))}}
			{{Form::textarea('desc',null,['rows'=>3,'class'=>'col-sm-12'])}}

			{{Form::label('registration',__('This event requires registration?'))}}
			{{Form::radio('registration',1,false)}} @lang("Yes")
			{{Form::radio('registration',0,true)}} @lang("No")
			<br/>
			<em>(paste google form url below)</em>
			{{Form::label('form_id',__('Google Form Link'))}}
			{{Form::text('form_id',null,['class'=>'form-control'])}}

			{{Form::label('url',__('Event URL'))}}
			{{Form::text('url',null,['class'=>'form-control'])}}<br/>

			<button class="btn btn-inverse">@lang("Save")</button>
			{{Form::close()}}
		</div>
	</div>

@endsection
@push('scripts')
	@include('partials.tinymce')
	<style>
		#body_ifr {
			height: 200px !important;
		}
	</style>
	<script>
		@if($event->allDay ==1)
        $('.end-date').hide();
		@endif
        $('.all-day input[type=checkbox]').click(function () {
            $('.end-date').toggle();
        });
	</script>
@endpush