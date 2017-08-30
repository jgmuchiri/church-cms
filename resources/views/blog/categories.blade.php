@extends('layouts.template')
@section('title')
    New Post
@endsection
@section('crumbs')
    <a href="/blog/admin">@lang("Blog")</a>
    <a href="#" class="current">@lang("Blog categories")</a>
@endsection
@section('content')

    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
                <h5>@lang("Blog categories")</h5>
                <div class="buttons">
                    <a class="btn btn-default btn-mini" href="/blog/admin"><i class="icon-chevron-left"></i>
                        back</a>

                    <a href="/blog" class="btn btn-default btn-mini"><i class="icon-home"></i> @lang("Blog Homepage")</a>
                    <a href="/blog/categories" class="btn btn-info btn-mini"><i class="icon-list-alt"></i>
                        Categories</a>
                </div>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span6">
                        <table class="table table-responsive">
                            <tr>
                                <th>@lang("Name")</th>
                                <th>@lang("Desc")</th>
                            </tr>
                            @foreach($cats as $cat)
                                <tr>
                                    <td><a href="?cat={{$cat->id}}">{{$cat->name}}</a></td>
                                    <td>{{$cat->desc}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="span6">
                        @if(isset($_GET['cat']))

                            <h3>@lang("Update Category")</h3>
                            <?php
                            $myCat = DB::table('blog_cats')->where('id', $_GET['cat'])->first();
                            $button = "Update";
                            ?>
                            {{Form::model($myCat,['url'=>'blog/categories/'.$myCat->id,'method'=>'patch'])}}
                        @else

                            <h3>@lang("New Category")</h3>
                            {{Form::open(['url'=>'blog/categories'])}}
                            <?php $button = "Submit"; ?>
                        @endif
                        <label>@lang("Name")</label>
                        {{Form::text('name',null,['required'=>'required'])}}
                        <label>@lang("Desc")</label>
                        {{Form::textarea('desc',null,['rows'=>3])}}
                        <br/>
                        <br/>
                        @if(isset($myCat))
                            <a href="/blog/categories" class="btn btn-danger">@lang("Cancel")</a>
                        @endif
                        <button class="btn btn-default">{{$button}}</button>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection