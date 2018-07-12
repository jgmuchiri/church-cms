@extends('layouts.admin-template')

@section('title')
	@lang('Update post')
@endsection

@section('content')

	<div class="card card-default">
		<div class="card-header">
			<div class="buttons">
				<a class="btn btn-inverse btn-sm" href="/blog/admin"><i class="fa fa-chevron-left"></i>
					@lang('back')</a>

				<a href="/blog" class="btn btn-inverse btn-sm"><i class="fa fa-home"></i> @lang("Blog Homepage")</a>
				<a href="/blog/categories" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>
					@lang('Categories')</a>
			</div>
		</div>
	</div>

	{{Form::model($blog,['url'=>'blog/'.$blog->id.'/update'])}}

	@include('blog.blog-form')

	{{Form::close()}}

@endsection

@include('partials.tinymce')