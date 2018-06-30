@extends('layouts.admin-template')
@section('title')
    Knowledge Base
@endsection
@section('content')
    <div class="row">
        <div class="card card-default">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-2">
                        <ul class="nav nav-pills nav-stacked">
                            @foreach($kbCats as $kbCat)
                                <li class="nav-item">
                                    <a href="/support/topic/{{$kbCat->name}}">
                                        <i class="fa {{$kbCat->icon}}"></i>
                                        {{$kbCat->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-10">

                        <form method="get" action="/support/search" class="form-inline"
                              style="padding:10px;border:solid 1px;background:#858894">
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="text" name="s" class="col-sm-12"
                                           placeholder="What can we help you with? Enter a search term.">
                                </div>
                                <div class="col-sm-1">
                                    <span class="btn btn-inverse"><i class="icon-search"></i> </span>
                                </div>
                            </div>
                        </form>
                        <br/>
                        <div class="row">

                            @foreach($kbs as $kb)
                                <h4>{{$kb->question}}</h4>
                                {!! $kb->question_desc !!}
                                <hr/>
                            @endforeach

                            {!! $kbs->links() !!}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection