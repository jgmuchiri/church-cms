@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-2">

                @include('ministries.ministry-cats')
            </div>
            <div class="col-md-7">

                <h3>{{$ministry->category->name}} @lang("Ministry")</h3>
                <br/>
                <h4 style="border-bottom:solid 1px #ccc;padding-bottom:5px;">{{$ministry->name}}</h4>

                {!! $ministry->desc !!}

            </div>
            <div class="col-md-3 hidden-xs">
                <ul class="nav nav-stacked">
                    @foreach($ministry->category->ministries()->whereActive(1)->get() as $m)
                        <li class="">
                            <a href="/ministries/{{$m->slug}}" class="@if($m->id == $ministry->id) text-success @endif">
                                <i class="fa @if($m->id == $ministry->id) fa-hand-o-right @else fa-th @endif "></i> {{$m->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection