@extends('layouts.admin-template')
@section('title')
    @lang("Church Schedule")
@endsection
@section('crumbs')
    <a href="#" class="current">@lang("Church Schedule")</a>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="fa fa-calendar"></i></span>
            <h5>@lang("Regular service schedules")</h5>

            <div class="buttons">
                <a class="btn btn-inverse btn-sm" href="/events/admin"><i class="fa fa-chevron-left"></i>
                    @lang('back to calendar')</a>
            </div>
        </div>
        <div class="card-body nopadding">
            <table class="table table-bordered data-table selec2">
                <thead>
                <tr>
                    <td>@lang("Name")</td>
                    <td>@lang("Start")</td>
                    <td>@lang("End")</td>
                    <td>@lang("Desc")</td>
                    <td>@lang("Order")</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($schedule as $s)
                    {{Form::model($s,['url'=>'events/church-schedule/'.$s->id,'method'=>'patch'])}}
                    <tr>
                        <td>
                            {{Form::text('event',null,['required'=>'required','class'=>'col-sm-12'])}}
                        </td>
                        <td>
                            {{Form::input('time','start',null,['required'=>'required','class'=>'col-sm-12'])}}
                        </td>
                        <td>
                            {{Form::input('time','end',null,['required'=>'required','class'=>'col-sm-12'])}}
                        </td>
                        <td>
                            {{Form::text('desc',null,['class'=>'col-sm-12'])}}
                        </td>
                        <td>
                            {{Form::text('order',null,['class'=>'col-sm-12'])}}
                        </td>
                        <td>
                        <span class="btn-group">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i></button>
                        <a href="/events/church-schedule/{{$s->id}}/delete" class="btn btn-danger btn-sm"><i
                                    class="fa fa-trash"></i> </a>
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
                        {{Form::text('event',null,['required'=>'required','class'=>'col-sm-12'])}}
                    </td>
                    <td>
                        {{Form::input('time','start',null,['required'=>'required','class'=>'col-sm-12'])}}
                    </td>
                    <td>
                        {{Form::input('time','end',null,['required'=>'required','class'=>'col-sm-12'])}}
                    </td>
                    <td>
                        {{Form::text('desc',null,['class'=>'col-sm-12'])}}
                    </td>
                    <td>
                        {{Form::text('order',null,['class'=>'col-sm-12'])}}
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm"><i class="fa fa-save"></i></button>
                    </td>
                </tr>
                {{Form::close()}}
                </tbody>
            </table>
        </div>
    </div>
@endsection