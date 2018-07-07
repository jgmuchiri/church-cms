@extends('layouts.admin-template')
@section('title')
	@lang("New Ministry")
@endsection
@section('crumbs')
	<a href="/ministries/admin">@lang("Ministries")</a>
	<a href="#">@lang("New ministry")</a>
@endsection

@section('content')
	<div class="card card-default">
		<div class="card-header bg_lg">
			<a class="btn btn-inverse btn-sm" href="/ministries/admin">
				<i class="fa fa-chevron-left"></i> @lang("back")</a>

			<a href="/ministries/categories" class="btn btn-primary btn-sm">
				<i class="fa fa-list-alt"></i> @lang("Categories")
			</a>
		</div>
	</div>

	<div class="card card-default">
		<div class="card-body">
			{{Form::open(['url'=>'ministries','method'=>'POST'])}}
			@include('partials.ministry-form',['type'=>'Submit'])
			{{Form::close()}}
		</div>
	</div>
@endsection
@include('partials.editor')