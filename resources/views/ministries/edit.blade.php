@extends('layouts.admin-template')
@section('title')
	@lang("Update Ministry")
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
		<div class="card-body">
			{{Form::model($ministry,['url'=>route('update-ministry'),'method'=>'PATCH'])}}
			{{Form::hidden('id',$ministry->id)}}
			@include('partials.ministry-form',['type'=>'Update'])
			{{Form::close()}}
		</div>
	</div>
@endsection
@push('scripts')

@endpush
@include('partials.tinymce')