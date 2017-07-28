@extends('layouts.template')
@section('title')
    Events Calendar
@endsection
@section('crumbs')
    <a href="#">Calendar</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5>Edit event</h5>
            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/events/admin"><i class="icon-chevron-left"></i>
                    back to calendar</a>

                <a class="btn btn-inverse btn-mini" href="/events/list"><i class="icon-list"></i>
                    events list</a>
            </div>
        </div>
        <div class="widget-content">

            {{Form::model($event,['url'=>'events/'.$event->id.'/edit'])}}
            {{Form::text('title',null,['placeholder'=>'Event Title','required'=>'required'])}}<br/>

            <label>Start</label>
            {{Form::input('date','start',date('Y-m-d',strtotime($event->start)),['placeholder'=>'Start','required'=>'required'])}}
            {{Form::input('time','startTime',date('H:i',strtotime($event->start)),['placeholder'=>'Start'])}}

            <br/>

            <div class="row-fluid">
                <div class="span6">
                    <label>Status</label>
                    {{Form::select('status',['active'=>'Active','private'=>'Private'])}}

                </div>
                <div class="span6">
                    {{Form::checkbox('allDay')}} <label>All day?</label>
                </div>
            </div>


            <div class="row-fluid">
                <div class="span6">
                    <label>End</label>
                    {{Form::input('date','end',date('Y-m-d',strtotime($event->end)),['placeholder'=>'End'])}}
                    {{Form::input('time','endTime',date('H:i',strtotime($event->end)),['placeholder'=>'End'])}}
                </div>
            </div>

            <br/>
            {{Form::textarea('desc',null,['placeholder'=>'Description','rows'=>3,'class'=>'span12'])}}

            <label>This event requires registration?</label>
            {{Form::radio('registration',1,false)}} Yes
            {{Form::radio('registration',0,true)}} No
            <br/>
            <em>(paste google form url below)</em>
            {{Form::text('form_id',null,['placeholder'=>'Google Form Link','class'=>'span12'])}}<br/>
            {{Form::text('url',null,['placeholder'=>'Event URL','class'=>'span12'])}}<br/>
            <button class="btn btn-default">Save</button>
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