@extends('layouts.template')
@section('title')
    Update Post
@endsection
@section('crumbs')
    <a href="/blog/admin">Blog</a>
    <a href="#" class="current">Edit blog post</a>
@endsection
@section('content')
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
                <h5>Blog admin</h5>
                <div class="buttons">
                    <a class="btn btn-default btn-mini" href="/blog/admin"><i class="icon-chevron-left"></i> back</a>

                    <a href="/blog" class="btn btn-default btn-mini"><i class="icon-home"></i> Blog Homepage</a>
                    <a href="/blog/categories" class="btn btn-info btn-mini"><i class="icon-list-alt"></i>
                        Categories</a>
                    <a href="/blog/create" class="btn btn-inverse btn-mini"><i class="icon-plus"></i> New
                        Post</a>
                </div>
            </div>
            <div class="widget-content">
                {{Form::model($blog,['url'=>'blog/'.$blog->id.'/update'])}}
                <div class="row-fluid">

                    <div class="span10">
                        <label>Title</label>
                        {{Form::text('title',null,['required'=>'required'])}}

                        <label>Publish Date</label>
                        {{Form::input('date','published_at',date('Y-m-d'),['required'=>'required'])}}

                        <label>Status</label>
                        {{Form::select('status',['draft'=>'Draft','published'=>'Published'])}}

                        <label>Body</label>
                        {{Form::textarea('body',null,['required'=>'required','class'=>'editor'])}}
                    </div>
                    <div class="span2">
                        <label>Categories</label>
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
                        <button class="btn btn-default">Submit</button>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@include('partials.tinymce')