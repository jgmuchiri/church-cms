@extends('layouts.template')
@section('title')
    @lang("Knowledge base")
@endsection
@section('crumbs')
    <a href="/support">@lang("Knowledge base")</a>
    <a href="#" class="current">@lang("Support questions")</a>
@endsection

@section('content')
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
                <h5>@lang("Support questions")</h5>
                <div class="buttons">
                    <a href="/support" class="btn btn-default btn-mini">
                        <i class="icon-chevron-left"></i> @lang("back")</a>
                </div>
            </div>

            <div class="widget-content">

                <div class="row-fluid">
                    <div class="span2">
                        <ul class="nav nav-pills nav-stacked">
                            @foreach(DB::table('kb_cats')->get() as $kbCat)
                                <li class="nav-item">
                                    <a href="/support/topic/{{$kbCat->name}}">
                                        <i class="fa {{$kbCat->icon}}"></i>
                                        {{$kbCat->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="span10">
                        <form method="get" action="/support/search" class="form-inline"
                              style="padding:10px;border:solid 1px;background:#858894">
                            <div class="row-fluid">
                                <div class="span11">
                                    <input type="text" name="s" class="span12"
                                           placeholder="What can we help you with? Enter a search term.">
                                </div>
                                <div class="span1">
                                    <span class="btn btn-inverse"><i class="icon-search"></i> </span>
                                </div>
                            </div>
                        </form>

                        <br/>
                        @if(count($topics)>0)
                            @foreach($topics as $topic)
                                <div class="callout callout-warning">
                                    <h5 class="title"><i class="icon-question"></i>
                                        {!! $topic->question !!}</h5>
                                    <p>
                                        <em>{!! $topic->question_desc !!}</em>
                                    </p>
                                </div>
                                <div class="callout callout-info" style="margin-top: -20px;">
                                    {!! $topic->answer !!}
                                </div>

                                <hr/>
                            @endforeach
                            {{$topics->links()}}
                        @else
                            <div class="alert alert-danger">@lang("No records found")</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
                <h5>@lang("Still can't find what you are looking for? Submit your question here")</h5>
            </div>
            <div class="widget-content">
                {{Form::open(['url'=>'support/sendQuestion'])}}
                {{Form::hidden('cat',Request::segment('3'))}}
                {{Form::text('name',null,['placeholder'=>__("Enter your question here"),'class'=>'span12'])}}
                <br/>
                {{Form::textarea('desc',null,['rows'=>3,'Placeholder'=>__("Enter a detailed problem here"),'class'=>'span12'])}}
                <br/>
                <button class="btn btn-default btn-flat">@lang("Submit")</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection