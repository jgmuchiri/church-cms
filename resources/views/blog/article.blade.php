@extends('layouts.public')

@section('title')
	{{$article->title}}
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-9">
			{!! $article->body !!}


			<h4>@lang("Comments")</h4>

			@foreach($comments as $cm)
				<div style="border-bottom:dotted 1px #ccc;margin-bottom:15px;">
					<div style="margin-bottom:2px; " class="text-uppercase">
						<span style="font-weight: bold;">{{App\User::find($cm->user_id)->name}}</span>
						on
						<span style="font-size:10px;"> {{date('d, M Y',strtotime($cm->created_at))}}</span>

						@if(has_role('admin'))
						<a class="delete" href="/blog/comment/{{$cm->id}}/delete"><i
									class="fa fa-trash text-danger"></i> </a>
						@endif

					</div>
					<span style="font-size: 16px;">{{$cm->comment}}</span>
				</div>
			@endforeach
			{{$comments->render()}}

			<hr/>
			@if(Auth::check())
				{{Form::open(['url'=>'blog/'.$article->id.'/postComment'])}}
				{{Form::hidden('article_id',$article->id)}}
				{{Form::hidden('parent_id',0)}}
				{{Form::textarea('comment',null,['required'=>'required','class'=>'form-control','placeholder'=>__('Enter your comments. use @to reply to specific user'),'rows'=>3])}}
				<br/>
				<button class="btn btn-inverse">@lang("Post")</button>
				{{Form::close()}}
			@else
				<i>@lang('Login to comment')</i>
			@endif

		</div>

		<div class="col-sm-3">
			<h3 class="">@lang("Categories")</h3>

			<ul class="nav nav-stacked">
				@foreach($cats as $c)
					<li class="nav-item">
						<a href="/blog?cat={{$c->name}}">{{$c->name}}</a>
					</li>
				@endforeach
			</ul>

		</div>
	</div>
@endsection

@push('scripts')
	<script>
        $('.delete').click(function (e) {
            if (confirm('@lang('Are you sure?')'') {
                return true;
            }
            e.preventDefault();
            return false;
        })
	</script>
@endpush