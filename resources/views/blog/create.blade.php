@extends('layouts.template')
@section('title')
    New Post
@endsection
@section('crumbs')
    <a href="/blog/admin">Blog</a>
    <a href="#" class="current">New blog post</a>
@endsection
@section('content')

    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
                <h5>Blog categories</h5>
                <div class="buttons">
                    <a class="btn btn-default btn-mini" href="/blog/admin"><i class="icon-chevron-left"></i>
                        back</a>

                    <a href="/blog" class="btn btn-default btn-mini"><i class="icon-home"></i> Blog Homepage</a>
                    <a href="/blog/categories" class="btn btn-info btn-mini"><i class="icon-list-alt"></i>
                        Categories</a>
                </div>
            </div>
            <div class="widget-content">
                {{Form::open(['url'=>'blog/create'])}}
                <div class="row-fluid">
                    <div class="span10">
                        <label>Title</label>
                        {{Form::text('title',null,['required'=>'required'])}}

                        <label>Publish Date</label>
                        {{Form::input('date','published_at',date('Y-m-d'),['required'=>'required'])}}

                        <label>Status</label>
                        {{Form::select('status',['draft'=>'Draft','published'=>'Published'])}}

                        <label>Body</label>
                        {{Form::textarea('body',null,['class'=>'editor'])}}
                    </div>
                    <div class="span2">
                        <label>Categories</label>
                        <?php $cats = DB::table('blog_cats')->get(); ?>
                        @foreach ($cats as $cat)<br/>
                        {{Form::checkbox('categories[]',$cat->id,false,['style'=>'width:20px;'])}}{{$cat->name}}
                        <br/>
                        @endforeach
                        <br/>
                        <button class="btn btn-default">Submit</button>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('partials.tinymce')