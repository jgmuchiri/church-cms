@extends('layouts.admin-template')
@section('title')
	<a href="/sermons/admin" class="btn btn-primary btn-sm">
		<i class="fa fa-chevron-left"></i>
	</a>
@endsection
@section('content')
	{{Form::model($sermon,['url'=>'sermons/'.$sermon->id,'files'=>'true','method'=>'PATCH'])}}
	{{Form::hidden('sermon_id',$sermon->id)}}
	@include('partials.sermons-form',['btn'=>'Update','heading'=>__('Update sermon'),'sermon'=>$sermon])
	{{Form::close()}}
@endsection
@include('partials.tinymce')