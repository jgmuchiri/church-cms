@extends('layouts.admin-template')
@section('title')
	<i class="fa fa-th"></i>  @lang("Ministry categories")
@endsection
@section('content')
	<div class="card card-default">
		<div class="card-header">
			<div class="buttons">
				<a class="btn btn-inverse btn-sm" href="/ministries/admin"><i class="fa fa-chevron-left"></i>
					@lang("back")</a>

				<a href="/ministries/create" class="btn btn-primary btn-sm">
					<i class="fa fa-plus"></i> @lang("New Ministry")
				</a>
			</div>
		</div>
	</div>

	<div class="card card-default">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<h3>@lang("Categories")</h3>
					<table class="table ">
						<tr>
							<th>@lang("Name")</th>
							<th>@lang("Description")</th>
						</tr>
						@foreach($cats as $cat)
							<tr>
								<td><a href="?cat={{$cat->id}}">{{$cat->name}}</a></td>
								<td>{!! $cat->desc !!}</td>
							</tr>
						@endforeach
					</table>
				</div>
				<div class="col-sm-6">
					@if(isset($_GET['cat']))
						{{Form::model($myCat,['url'=>'ministries/categories/'.$myCat->id,'method'=>'patch'])}}
						@include('partials.ministry-cats-form',['heading'=>'Update category','btn'=>'Update','close'=>true])
					@else
						{{Form::open(['url'=>'ministries/categories'])}}
						@include('partials.ministry-cats-form',['heading'=>'New category','btn'=>'Submit'])
					@endif

					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>

@endsection
@include('partials.editor')