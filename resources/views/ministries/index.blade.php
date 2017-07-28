@extends('layouts.public')

@section('content')
    <style>
        .panel {
            border-radius: 0;
        }

        .panel .panel-heading {
            padding: 5px;
        }
    </style>
    <div class="container">


        <div class="row">
            <div class="col-sm-2">
                @include('ministries.ministry-cats')
            </div>
            <div class="col-sm-10">

                <h3>

                    @if(isset($_GET['cat']))
                        {{ucwords($cat->name)}}
                    @elseif(Request()->segment('2'))
                        {{ucwords($ministry->name)}} Ministry
                    @else
                        Ministries
                    @endif
                </h3>

                <div class="callout callout-warning">
                    @if(isset($_GET['cat']))
                        {!! $cat->desc !!}
                    @endif
                </div>
                <div class="row">

                    @foreach($ministries as $m)
                        <div class="col-sm-4">
                            <div class="panel panel-default" style="height:100px;">
                                <div class="panel-heading" style="height:30px;overflow: hidden;text-overflow: hidden;">
                                <span class="panel-title">
                                    <a href="/ministries/{{$m->slug}}">{{$m->name}}</a>
                                </span>
                                </div>
                                <div style="font-size:12px;padding:5px;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            {!! App\Tools::postThumb($m->desc,"100%",'60px') !!}
                                        </div>
                                        <div class="col-sm-8">
                                            {!! str_limit(strip_tags($m->desc),100,'...') !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
