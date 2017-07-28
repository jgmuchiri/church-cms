@extends('layouts.public')

@section('content')
    <div class="container">

        <div class="h2 title bg-info">
            @if(isset($_GET['cat']))
                {{$_GET['cat']}}
            @else
                Church Blog
                @endif
        </div>

        <div class="row">
            <div class="col-sm-8">
                @foreach($blog as $b)
                    <div class="row">
                        <div class="col-sm-2 col-xs-6">
                            {!! App\Tools::postThumb($b->body)!!}
                        </div>
                        <div class="col-sm-10 col-xs-6">
                            <h3 style="margin-top:-4px;"><a
                                        href="/blog/{{$b->id}}">{{str_limit($b->title,50,'...')}}</a></h3>

                            <small> {{date('d, M Y',strtotime($b->published_at))}}</small>
                            <p class="hidden-xs">{!! strip_tags(\Illuminate\Support\Str::words($b->body,45,'...')) !!}</p>
                        </div>
                    </div>
                    <hr/>
                @endforeach
                {{$blog->render()}}
            </div>
            <div class="col-sm-4">
                <h3 class="">Categories</h3>

                <ul class="nav nav-stacked">
                    @foreach($cats as $c)
                        <li class="nav-item">
                            <a href="/blog?cat={{$c->name}}">{{$c->name}}</a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
@endsection