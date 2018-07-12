@extends('layouts.public')
@section('content')
    <div class="container">
        <h2><a href="/blog">@lang("Church blog")</a></h2>

        <div class="row">
            <div class="col-md-8">
                <h3>{{$article->title}}</h3>

                {!! $article->body !!}
            </div>
            <div class="col-sm-4">
                <h3 class="">@lang("Categories")</h3>

                <ul class="nav nav-stacked">
                    @foreach($cats as $c)
                        <li class="nav-item">
                            <a href="/blog?cat={{$c->name}}">{{$c->name}}</a>
                        </li>
                    @endforeach
                </ul>

            </div>

            <div class="row">
                <div class="col-md-8">

                    <hr/>
                    <h3>@lang("Comments")</h3>

                    @foreach($comments as $cm)
                        <div style="border-bottom:dotted 1px #ccc;margin-bottom:15px;">
                            <div style="margin-bottom:2px; " class="text-uppercase">
                                <span style="font-weight: bold;">{{App\User::find($cm->user_id)->name}}</span>
                                on
                                <span style="font-size:10px;"> {{date('d, M Y',strtotime($cm->created_at))}}</span>

                                @role('admin')
                                <a class="delete" href="/blog/comment/{{$cm->id}}/delete"><i
                                            class="fa fa-trash text-danger"></i> </a>
                                @endrole

                            </div>
                            <span style="font-size: 16px;">{{$cm->comment}}</span>
                        </div>
                    @endforeach
                    {{$comments->render()}}

                    <hr/>
                    <h3>@lang("Post your comment")</h3>
                    @if(Auth::check())
                        {{Form::open(['url'=>'blog/'.$article->id.'/postComment'])}}
                        {{Form::hidden('article_id',$article->id)}}
                        {{Form::hidden('parent_id',0)}}
                        {{Form::textarea('comment',null,['required'=>'required','placeholder'=>'Enter you comments. use @to reply to specific user','rows'=>3])}}
                        <br/>
                        <button class="btn btn-inverse">@lang("Post")</button>
                        {{Form::close()}}
                    @else
                        <i>@lang("Login to comment")</i>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('.delete').click(function (e) {
        if (confirm('Are you sure?')) {
            return true;
        }
        e.preventDefault();
        return false;
    })
</script>
@endpush