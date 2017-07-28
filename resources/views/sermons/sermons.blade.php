@extends('layouts.public')
@section('title')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h3 class="method-title">Sermons</h3>
                @if(count($sermons) ==0)
                    <div class="alert alert-danger">No results found</div>
                @else
                    @include('sermons.sermon-slider')
                @endif
                <hr/>
                <form action="" method="get">
                    <div class="input-group">
                        <input name="s" placeholder="Search" class="form-control">
                        <span class="input-group-btn"><button class="btn btn-default"><i
                                        class="icon-search"></i> Search
                                </button>
                            </span>
                    </div>
                </form>
                <br/>

                @foreach($sermons as $s)
                    <div class="callout callout-info">
                        <div class="row">
                            <div class="col-sm-2">
                                <strong>Date</strong><br/>
                                {{date('d M, Y',strtotime($s->created_at))}}<br/>
                                <strong>Speaker:</strong>
                                <br/>
                                {{$s->speaker}}
                            </div>
                            <div class="col-sm-2">
                                @if(is_file('uploads/sermons/cover/'.$s->cover))
                                    <img style="heigth:85px;width:85px;"
                                         src="/uploads/sermons/cover/{{$s->cover}}"/>
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