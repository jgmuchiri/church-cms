@extends('layouts.admin-template')
@section('title')
    Update Post
@endsection
@section('crumbs')
    <a href="/blog/admin">@lang("Blog")</a>
    <a href="#" class="current">@lang("Edit blog post")</a>
@endsection
@section('content')
    <div class="row">
        <div class="card card-default">
            <div class="card-header bg_lg"><span class="icon"><i class="fa fa-th"></i></span>
                <h5>@lang("Blog admin")</h5>
                <div class="buttons">
                    <a class="btn btn-default btn-sm" href="/blog/admin"><i class="fa fa-chevron-left"></i> @lang("back")</a>

                    <a href="/blog" class="btn btn-default btn-sm"><i class="fa fa-home"></i> @lang("Blog Homepage")</a>
                    <a href="/blog/categories" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>
                        Categories</a>
                    <a href="/blog/create" class="btn btn-inverse btn-sm"><i class="fa fa-plus"></i> @lang("New
                        Post")</a>
                </div>
            </div>
            <div class="card-body">
                {{Form::model($blog,['url'=>'blog/'.$blog->id.'/update'])}}
                <div class="row">

                    <div class="col-sm-10">
                        <label>@lang("Title")</label>
                        {{Form::text('title',null,['required'=>'required'])}}

                        <label>@lang("Publish Date")</label>
                        {{Form::input('date','published_at',date('Y-m-d'),['required'=>'required'])}}

                        <label>@lang("Status")</label>
                        {{Form::select('status',['draft'=>'Draft','published'=>'Published'])}}

                        <label>@lang("Body")</label>
                        {{Form::textarea('body',null,['required'=>'required','class'=>'editor'])}}
                    </div>
                    <div class="col-sm-2">
                        <label>@lang"(Categories")</label>
                        <?php $cats = DB::table('blog_cats')->get(); ?>
                        @foreach($cats as $cat)
                            @if(strpos($blog->category, $cat->id.'') !== FALSE)
                                {{Form::checkbox('categories[]',$cat->id, true,['style'=>'width:20px;'])}} {{$cat->name}}
                            @else
                                {{Form::checkbox('categories[]',$cat->id, false,['style'=>'width:20px;'])}} {{$cat->name}}
                            @endif
                            <br/>
                        @endforeach

                        <br/>
                        <br/>
                        <button class="btn btn-default">@lang("Submit")</button>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@include('partials.tinymce')