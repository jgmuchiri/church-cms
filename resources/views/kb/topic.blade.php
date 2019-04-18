@extends('layouts.admin-template')
@section('title')
	@lang("Knowledge base")
@endsection
@section('crumbs')
	<a href="/support">@lang("Knowledge base")</a>
	<a href="#" class="current">@lang("Support questions")</a>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-3">
			<div class="card">
				<div class="card-body">
					<div class="buttons">
						<a href="/support" class="btn btn-inverse btn-sm">
							<i class="fa fa-chevron-left"></i> @lang("back")</a>
					</div>

					<ul class="nav nav-pills nav-stacked">
						@foreach(DB::table('kb_cats')->get() as $kbCat)
							<li class="nav-item">
								<a href="/support/topic/{{$kbCat->name}}">
									<i class="fa {{$kbCat->icon}}"></i>
									{{$kbCat->name}}</a>
							</li>
						@endforeach
					</ul>

				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<h3><i class="fa fa-question-circle"></i> @lang("Support questions")</h3>
			<form method="get" action="/support/search"
				  style="padding:10px;border:solid 1px;background:#858894">

				<div class="row">
					<div class="col-sm-11">
						<input type="text"
							   name="s"
							   class="form-control"
							   placeholder="What can we help you with? Enter a search term.">
					</div>
					<div class="col-sm-1">
						<button class="btn btn-inverse"><i class="fa fa-search"></i></button>
					</div>
				</div>

			</form>

			<div class="card">
				<div class="card-body">
					<br/>
					@if(sizeof($topics)>0)
						@foreach($topics as $topic)
							<div class="callout callout-warning">
								<h5 class="title"><i class="fa fa-question"></i>
									{!! $topic->question !!}</h5>
								<p>
									<em>{!! $topic->question_desc !!}</em>
								</p>
							</div>
							<div class="callout callout-info" style="margin-top: -20px;">
								{!! $topic->answer !!}
							</div>

							<hr/>
						@endforeach
						{{$topics->links()}}
					@else
						<div class="alert alert-danger">@lang("No records found")</div>
					@endif
				</div>
			</div>


			<div class="card card-default">
				<div class="card-header bg_lg">
					<h5> <i class="fa fa-question-circle"></i> @lang("Still can't find what you are looking for? Submit your question here")</h5>
				</div>
				<div class="card-body">
					<form method="post" action="/support/sendQuestion">
						@csrf
						<input type="hidden" name="cat" value="{{request()->segment(3)}}"/>
						<input type="text" name="name" placeholder="@lang("Enter your question here")" class="form-control"/>
						<br/>
						<textarea name="desc" class="form-control" placeholder="{{__("Enter a detailed problem here")}}"></textarea><br/>
						<button class="btn btn-inverse btn-flat">@lang("Submit")</button>
					</form>
				</div>
			</div>

		</div>
	</div>

@endsection