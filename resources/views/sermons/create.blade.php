@extends('layouts.template')

@section('title')
    New Sermon
@endsection
@section('crumbs')
    <a href="/sermons/admin">Sermons</a>
    <a href="#">New sermon</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-list"></i></span>
            <h5>New sermon</h5>

            <div class="buttons">
                <a href="/sermons/admin" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> Sermons
                </a>
                <a href="/sermons/admin/drafts" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> Drafts
                </a>
                <a href="/sermons/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> New Sermon
                </a>
            </div>
        </div>
        <div class="widget-content">
            {{Form::open(['url'=>'sermons/create','files'=>'true'])}}
            <table class="table">
                <tr>
                    <td>Title:</td>
                    <td>{{Form::text('title',null,['required'=>'required','class'=>'span12'])}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="row-fluid">
                            <div class="form-inline">
                                <div class="span4">
                                    <div class="form-group">
                                        <label>Topic:</label><br/>
                                        {{Form::text('topic')}}
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="form-group">
                                        <label>Sub Topic</label><br/>
                                        {{Form::text('sub_topic',null,['required'=>'required','placeholder'=>'Sub Topic'])}}
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="form-group">
                                        <label>Date</label><br/>
                                        {{Form::input('date','created_at',date('Y-m-d'),['required'=>'required'])}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Desc:</td>
                    <td> {{Form::textarea('desc',null,['placeholder'=>'Short Description','rows'=>3,'class'=>'span12'])}}</td>
                </tr>
                <tr>
                    <td>Message:</td>
                    <td>{{Form::textarea('message',null,['placeholder'=>'Message','class'=>'editor'])}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="form-inline">
                            <label>Upload Audio (mp3)</label>
                            {{Form::file('audio',['class'=>'btn btn-default'])}}

                            <label>Cover Image</label>
                            {{Form::file('cover')}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Video:</td>
                    <td> {{Form::text('video',null,['placeholder'=>'Video URL (Youtube or Vimeo)'])}}</td>
                </tr>
                <tr>
                    <td>Speaker:</td>
                    <td>
                        <div class="form-inline">
                            <label></label>
                            {{Form::text('speaker',null,['placeholder'=>'Speaker'])}}

                            <label>Scripture: </label>
                            {{Form::text('scripture',null,['placeholder'=>'Scripture'])}}

                            <label>Status: </label>
                            {{Form::select('status',['published'=>'Published','draft'=>'Draft'],'draft')}}
                        </div>

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-default">Publish</button>
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
