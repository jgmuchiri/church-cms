@extends('layouts.template')
@section('title')
   Ministry categories
@endsection
@section('crumbs')
    <a href="/ministries/admin">Ministries</a>
    <a href="#">Ministry categories</a>
    @endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>Ministry categories</h5>
            <div class="buttons">
                <a class="btn btn-default btn-mini" href="/ministries/admin"><i class="icon-chevron-left"></i>
                    back</a>

                <a href="/ministries/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> New Ministry
                </a>
            </div>
        </div>
        <div class="widget-content">
            <div class="row-fluid">
                <div class="span6">
                    <h3>Categories</h3>
                    <table class="table table-responsive">
                        <tr>
                            <th>Name</th>
                            <th>Desc</th>
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

                        <h3>Update Category</h3>
                        <?php
                        $myCat = DB::table('ministry_cats')->where('id', $_GET['cat'])->first();
                        $button = "Update";
                        ?>
                        {{Form::model($myCat,['url'=>'ministries/categories/'.$myCat->id,'method'=>'patch'])}}
                    @else

                        <h3>New Category</h3>
                        {{Form::open(['url'=>'ministries/categories'])}}
                        <?php $button = "Submit"; ?>
                    @endif
                    <label>Name</label>
                    {{Form::text('name',null,['required'=>'required'])}}
                    <label>Desc <em>(this will show on top of ministry page)</em></label>
                    {{Form::textarea('desc',null,['class'=>'editor','rows'=>3])}}
                    <br/>
                    <br/>
                    @if(isset($myCat))
                        <a href="/ministries/categories" class="btn btn-danger">Cancel</a>
                    @endif
                    <button class="btn btn-default">{{$button}}</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

@endsection
@include('partials.editor')