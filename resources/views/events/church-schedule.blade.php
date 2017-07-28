@extends('layouts.template')
@section('title')
    Church Schedule
@endsection
@section('crumbs')
    <a href="#" class="current">Church schedule</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5>Regular service schedules</h5>

            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/events/admin"><i class="icon-chevron-left"></i>
                    back to calendar</a>
            </div>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table selec2">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Start</td>
                    <td>End</td>
                    <td>Desc</td>
                    <td>Order</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($schedule as $s)
                    {{Form::model($s,['url'=>'events/church-schedule/'.$s->id,'method'=>'patch'])}}
                    <tr>
                        <td>
                            {{Form::text('event',null,['required'=>'required','class'=>'span12'])}}
                        </td>
                        <td>
                            {{Form::input('time','start',null,['required'=>'required','class'=>'span12'])}}
                        </td>
                        <td>
                            {{Form::input('time','end',null,['required'=>'required','class'=>'span12'])}}
                        </td>
                        <td>
                            {{Form::text('desc',null,['class'=>'span12'])}}
                        </td>
                        <td>
                            {{Form::text('order',null,['class'=>'span12'])}}
                        </td>
                        <td>
                        <span class="btn-group">
                        <button class="btn btn-primary btn-mini"><i class="icon-save"></i></button>
                        <a href="/events/church-schedule/{{$s->id}}/delete" class="btn btn-danger btn-mini"><i
                                    class="icon-trash"></i> </a>
                            </span>
                        </td>
                    </tr>
                    {{Form::close()}}
                @endforeach
                </tbody>
                <tbody>
                {{Form::open(['url'=>'events/church-schedule/','method'=>'post'])}}

                <tr>
                    <td>
                        {{Form::text('event',null,['required'=>'required','class'=>'span12'])}}
                    </td>
                    <td>
                        {{Form::input('time','start',null,['required'=>'required','class'=>'span12'])}}
                    </td>
                    <td>
                        {{Form::input('time','end',null,['required'=>'required','class'=>'span12'])}}
                    </td>
                    <td>
                        {{Form::text('desc',null,['class'=>'span12'])}}
                    </td>
                    <td>
                        {{Form::text('order',null,['class'=>'span12'])}}
                    </td>
                    <td>
                        <button class="btn btn-success btn-mini"><i class="icon-save"></i></button>
                    </td>
                </tr>
                {{Form::close()}}
                </tbody>
            </table>
        </div>
    </div>
@endsection