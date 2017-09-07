@extends('layouts.template')
@section('title')
   @lang("Ministry categories")
@endsection
@section('crumbs')
    <a href="/ministries/admin">@lang("Ministries")</a>
    <a href="#">@lang("Ministry categories")</a>
    @endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("Ministry categories")</h5>
            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/ministries/admin"><i class="icon-chevron-left"></i>
                    @lang("back")</a>

                <a href="/ministries/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> @lang("New Ministry")
                </a>
            </div>
        </div>
        <div class="widget-content">
            <div class="row-fluid">
                <div class="span6">
                    <h3>@lang("Categories")</h3>
                    <table class="table table-responsive">
                        <tr>
                            <th>@lang("Name")</th>
                            <th>@lang("Description")</th>
                        </tr>
                        @foreach($cats as $cat)
                            <tr>
                                <td><a href="?cat={{$cat->id}}">{{$cat->name}}</a></td>
                                <td>{!! $cat->desc !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="span6">
                    @if(isset($_GET['cat']))

                        <h3>@lang("Update Category")</h3>
                        <?php
                        $myCat = DB::table('ministry_cats')->where('id', $_GET['cat'])->first();
                        $button = "Update";
                        ?>
                        {{Form::model($myCat,['url'=>'ministries/categories/'.$myCat->id,'method'=>'patch'])}}
                    @else

                        <h3>@lang("New Category")</h3>
                        {{Form::open(['url'=>'ministries/categories'])}}
                        <?php $button = "Submit"; ?>
                    @endif
                    <label>@lang("Name")</label>
                    {{Form::text('name',null,['required'=>'required'])}}
                    <label>@lang("Description") <em>(@lang("this will show on top of ministry page")</em></label>
                    {{Form::textarea('desc',null,['class'=>'editor','rows'=>3])}}
                    <br/>
                    <br/>
                    @if(isset($myCat))
                        <a href="/ministries/categories" class="btn btn-danger">@lang("Cancel")</a>
                    @endif
                    <button class="btn btn-default">{{$button}}</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

@endsection
@include('partials.editor')