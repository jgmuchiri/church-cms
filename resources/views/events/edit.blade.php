@extends('layouts.admin-template')
@section('title')
    Events Calendar
@endsection
@section('crumbs')
    <a href="#">@lang("Calendar")</a>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="fa fa-calendar"></i></span>
            <h5>@lang"(Edit event")</h5>
            <div class="buttons">
                <a class="btn btn-default btn-sm" href="/events/admin"><i class="fa fa-chevron-left"></i>
                    back to calendar</a>

                <a class="btn btn-inverse btn-sm" href="/events/list"><i class="fa fa-list"></i>
                    events list</a>
            </div>
        </div>
        <div class="card-body">

            {{Form::model($event,['url'=>'events/'.$event->id.'/edit'])}}
            {{Form::text('title',null,['placeholder'=>'Event Title','required'=>'required'])}}<br/>

            <label>@lang("Start")</label>
            {{Form::input('date','start',date('Y-m-d',strtotime($event->start)),['placeholder'=>'Start','required'=>'required'])}}
            {{Form::input('time','startTime',date('H:i',strtotime($event->start)),['placeholder'=>'Start'])}}

            <br/>

            <div class="row">
                <div class="col-sm-6">
                    <label>@lang("Status")</label>
                    {{Form::select('status',['active'=>'Active','private'=>'Private'])}}

                </div>
                <div class="col-sm-6">
                    {{Form::checkbox('allDay')}} <label>@lang("All day")?</label>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <label>@lang("End")</label>
                    {{Form::input('date','end',date('Y-m-d',strtotime($event->end)),['placeholder'=>'End'])}}
                    {{Form::input('time','endTime',date('H:i',strtotime($event->end)),['placeholder'=>'End'])}}
                </div>
            </div>

            <br/>
            {{Form::textarea('desc',null,['placeholder'=>'Description','rows'=>3,'class'=>'col-sm-12'])}}

            <label>@lang("This event requires registration")?</label>
            {{Form::radio('registration',1,false)}} Yes
            {{Form::radio('registration',0,true)}} No
            <br/>
            <em>(paste google form url below)</em>
            {{Form::text('form_id',null,['placeholder'=>'Google Form Link','class'=>'col-sm-12'])}}<br/>
            {{Form::text('url',null,['placeholder'=>'Event URL','class'=>'col-sm-12'])}}<br/>
            <button class="btn btn-default">@lang("Save")</button>
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