@extends('layouts.admin-template')
@section('title')
    Knowledge Base
@endsection
@section('content')
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-content">

                <div class="row-fluid">
                    <div class="span2">
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
                    <div class="span10">

                        <form method="get" action="/support/search" class="form-inline"
                              style="padding:10px;border:solid 1px;background:#858894">
                            <div class="row-fluid">
                                <div class="span11">
                                    <input type="text" name="s" class="span12"
                                           placeholder="What can we help you with? Enter a search term.">
                                </div>
                                <div class="span1">
                                    <span class="btn btn-inverse"><i class="icon-search"></i> </span>
                                </div>
                            </div>
                        </form>
                        <br/>
                        <div class="row-fluid">

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