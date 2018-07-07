@extends('layouts.admin-template')

@section('title')
	<a href="/sermons/admin" class="btn btn-primary btn-sm">
		<i class="fa fa-chevron-left"></i>
	</a>
@endsection
@section('content')
	{{Form::open(['url'=>route('create-sermon'),'files'=>'true','method'=>'POST'])}}
	@include('partials.sermons-form',['btn'=>'Submit','heading'=>__('New sermon')])
	{{Form::close()}}

@endsection

@include('partials.tinymce')
