@extends('layouts.public')
@section('title')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h3 class="method-title">@lang("Sermons")</h3>
                @if(!empty($sermons) ==0)
                    <div class="alert alert-danger">@lang("No results found")</div>
                @else
                    @include('sermons.sermon-slider')
                @endif
                <hr/>
                <form action="" method="get">
                    <div class="input-group">
                        <input name="s" placeholder="Search" class="form-control">
                        <span class="input-group-btn"><button class="btn btn-inverse"><i
                                        class="fa fa-search"></i> @lang("Search")
                                </button>
                            </span>
                    </div>
                </form>
                <br/>

                @foreach($sermons as $s)
                    <div class="callout callout-info">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>@lang("Date")</strong><br/>
                                {{date('d M, Y',strtotime($s->created_at))}}<br/>
                                <strong>@lang("Speaker"):</strong>
                                <br/>
                                {{$s->speaker}}
                            </div>
                            <div class="col-sm-2">
                                @if(Storage::exists($s->cover))
                                    <img style="heigth:85px;width:85px;"
                                         src="{{Storage::url($s->cover)}}"/>
                                @else
                                    {!! App\Tools::postThumb('none','85px','85px') !!}
                                @endif

                            </div>
                            <div class="col-sm-4">
                                <h4 class="method-title"><a
                                            href="/sermons/{{$s->slug}}">{{$s->title}}</a></h4>
                                {{$s->desc}}
                            </div>
                            <div class="col-md-2">
                                {{$s->scripture}}
                            </div>
                        </div>

                    </div>
                    <hr/>
                @endforeach
                <div class="text-center">{{$sermons->render()}}</div>
            </div>
            <div class="col-md-3">
                @include('sermons.recent_sidebar')
            </div>
        </div>
    </div>
@endsection