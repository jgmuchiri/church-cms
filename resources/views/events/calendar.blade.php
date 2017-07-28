@extends('layouts.template')
@section('title')
    Events Calendar
@endsection
@section('crumbs')
    <a href="#">Events calendar</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5>New sermon</h5>

            <div class="buttons">
                <a href="/events/church-schedule" class="btn btn-warning btn-mini">
                    <i class="icon icon-calendar"></i> Sunday Schedule
                </a>
                <a class="btn btn-info btn-mini newEventBtn" data-toggle="modal" data-target="#new-event" href="#"><i
                            class="icon-plus"></i>
                    create event</a>
                <a class="btn btn-inverse btn-mini" href="/events/list"><i class="icon-list"></i>
                    events list</a>
            </div>
        </div>
        <div class="widget-content">
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

<div class="modal fade" id="eventData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
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
                <button type="button" class="btn btn-inverse" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title" id="myModalLabel">New Event</h4>

            </div>
            {{Form::open(['url'=>'events','id'=>'new-event-form'])}}
            <div class="modal-body">
                <div class="row-fluid">
                    {{Form::text('title',null,['placeholder'=>'Event Title','required'=>'required','class'=>'span12'])}}
                    <br/>

                    <div class="row-fluid">
                        <div class="span6">
                            <label>Start date</label>
                            {{Form::input('date','start',null,['placeholder'=>'Start','required'=>'required','class'=>'span12'])}}
                        </div>
                        <div class="span6" id="e-start-time">
                            <label>Start time</label>
                            {{Form::input('time','startTime',null,['placeholder'=>'Start','class'=>'span12'])}}
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span6">
                            <label>Status</label>
                            {{Form::select('status',['active'=>'Active','private'=>'Private'],null,['class'=>'span12'])}}
                        </div>
                        <div class="span6">
                            {{Form::checkbox('allDay')}} <label>All day?</label>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span6">
                            <label>End date</label>
                            {{Form::input('date','end',null,['placeholder'=>'End','class'=>'span12'])}}
                        </div>
                        <div class="span6" id="e-end-time">
                            <label>End time</label>
                            {{Form::input('time','endTime',null,['placeholder'=>'End','class'=>'span12'])}}
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            {{Form::textarea('desc',null,['placeholder'=>'Description','rows'=>3,'class'=>'span12'])}}

                            <label>
                                {{Form::checkbox('registration',1,false)}}
                                This event requires registration?
                            </label>
                            {{Form::text('form_id',null,['placeholder'=>'Paste Google form link','class'=>'span12', 'style'=>'display:none'])}}<br/>
                            {{Form::text('url',null,['placeholder'=>'Event external link','class'=>'span12'])}}<br/>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endpush
