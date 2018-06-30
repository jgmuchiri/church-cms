@extends('layouts.admin-template')

@section('title')
    @lang("New Sermon")
@endsection
@section('crumbs')
    <a href="/sermons/admin">@lang("Sermons")</a>
    <a href="#">@lang("New sermon")</a>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="icon-list"></i></span>
            <h5>@lang("New sermon")</h5>

            <div class="buttons">
                <a href="/sermons/admin" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> @lang("Sermons")
                </a>
                <a href="/sermons/admin/drafts" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> @lang("Drafts")
                </a>
                <a href="/sermons/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> @lang("New Sermon")
                </a>
            </div>
        </div>
        <div class="card-body">
            {{Form::open(['url'=>'sermons/create','files'=>'true'])}}
            <table class="table">
                <tr>
                    <td>@lang("Title"):</td>
                    <td>{{Form::text('title',null,['required'=>'required','class'=>'col-sm-12'])}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="row">
                            <div class="form-inline">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang("Topic"):</label><br/>
                                        {{Form::text('topic')}}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang("Sub Topic")</label><br/>
                                        {{Form::text('sub_topic',null,['required'=>'required','placeholder'=>__("Sub Topic")])}}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang("Date")</label><br/>
                                        {{Form::input('date','created_at',date('Y-m-d'),['required'=>'required'])}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>@lang("Description"):</td>
                    <td> {{Form::textarea('desc',null,['placeholder'=>__("Short Description"),'rows'=>3,'class'=>'col-sm-12'])}}</td>
                </tr>
                <tr>
                    <td>@lang("Message"):</td>
                    <td>{{Form::textarea('message',null,['placeholder'=>__("Message"),'class'=>'editor'])}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="form-inline">
                            <label>@lang("Upload Audio") (mp3)</label>
                            {{Form::file('audio',['class'=>'btn btn-default'])}}

                            <label>@lang("Cover Image")</label>
                            {{Form::file('cover')}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>@lang("Video"):</td>
                    <td> {{Form::text('video',null,['placeholder'=>__("Video URL").' (Youtube or Vimeo)'])}}</td>
                </tr>
                <tr>
                    <td>@lang("Speaker"):</td>
                    <td>
                        <div class="form-inline">
                            <label></label>
                            {{Form::text('speaker',null,['placeholder'=>__("Speaker")])}}

                            <label>@lang("Scripture"): </label>
                            {{Form::text('scripture',null,['placeholder'=>__("Scripture")])}}

                            <label>@lang("Status"): </label>
                            {{Form::select('status',['published'=>__("Published"),'draft'=>__("Draft")],'draft')}}
                        </div>

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-default">@lang("Publish")</button>
                    </td>
                </tr>
            </table>
            {{Form::close()}}
        </div>
    </div>
@endsection

@include('partials.tinymce')
@push('scripts')
<script>
    $('input[name=title]').blur(function () {
        var title = $(this).val();
        var slug = title.split(' ').join('_');
        $('input[name=slug]').val(slug)
    });

    $('input[name=video]').blur(function () {
        var video = $(this).val();
        $(this).val(yoube(video))
    })
</script>
@endpush
