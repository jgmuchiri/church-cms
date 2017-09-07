@extends('layouts.template')
@section('title')
    @lang("Support Q&A")
@endsection
@section('content')
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-question-sign"></i></span>
                <h5>@lang("New support topic")</h5>
                <div class="buttons">
                    <a href="/support/questions" class="btn btn-inverse btn-mini">
                        <i class="icon-chevron-left"></i> @lang("back to questions")
                    </a>
                </div>
            </div>
            <div class="widget-content">

                <form method="get" action="/support/search" class="form-inline" style="padding:10px;border:solid 1px;background:#858894">
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

                @if(isset($qn))
                    <div class="alert alert-info">{{$qn->question}}</div>

                    {{Form::model($qn,['url'=>'support/question/'.$qn->id])}}
                @else
                    {{Form::open(['url'=>'support/create'])}}
                @endif

                <label>@lang("Category")</label>
                {{Form::select('cat',DB::table('kb_cats')->pluck('name','id'),null,['class'=>'span4'])}}
                <br/>
                <label>@lang("Question")</label>
                {{Form::text('question',null,['placeholder'=>'Enter your question here','class'=>'span12'])}}
                <br/>
                <label>@lang("Question Details")</label>
                {{Form::textarea('question_desc',null,['rows'=>3,'Placehoder'=>'Enter a detailed problem here','class'=>'editor span12'])}}
                <br/>
                <label>@lang("Answer")</label>
                {{Form::textarea('answer',null,['class'=>'span12 editor','rows'=>3,'Placehoder'=>'Enter a detailed problem here'])}}

                <lable>@lang("Publish?")</lable>
                {{Form::select('active',[1=>'Yes',0=>'No'])}}
                <br/>
                <button class="btn btn-default btn-flat">@lang("Submit")</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection

@include('partials.editor')