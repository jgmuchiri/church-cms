@extends('layouts.admin-template')

@section('title')
	@lang('Blog categories')
@endsection

@section('content')

	<div class="card card-default">
		<div class="card-header">

			<div class="buttons">
				<a class="btn btn-inverse btn-sm" href="/blog/admin"><i class="fa fa-chevron-left"></i>
					@lang('back')
				</a>

				<a href="/blog" class="btn btn-inverse btn-sm"><i class="fa fa-home"></i> @lang("Blog Homepage")</a>
				<a href="/blog/categories" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>
					@lang('Categories')
				</a>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-6">

			<div class="card card-default">
				<div class="card-body">
					<table class="table ">
						<tr>
							<th>@lang("Name")</th>
							<th>@lang("Desc")</th>
						</tr>
						@foreach($cats as $cat)
							<tr>
								<td><a href="?cat={{$cat->id}}">{{$cat->name}}</a></td>
								<td>{{$cat->desc}}</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
		<div class="col-sm-6">

			<div class="card card-default">
				<div class="card-body">
					@if(isset($_GET['cat']))

						<h3>@lang("Update Category")</h3>
                        <?php
                        $myCat = DB::table('blog_cats')->where('id', $_GET['cat'])->first();
                        $button = "Update";
                        ?>
						{{Form::model($myCat,['url'=>'blog/categories/'.$myCat->id,'method'=>'patch'])}}
					@else

						<h3>@lang("New Category")</h3>
						{{Form::open(['url'=>'blog/categories'])}}
                        <?php $button = "Submit"; ?>
					@endif
					<label>@lang("Name")</label>
					{{Form::text('name',null,['required'=>'required','class'=>'form-control'])}}
					<label>@lang("Desc")</label>
					{{Form::textarea('desc',null,['rows'=>3,'class'=>'form-control'])}}
					<br/>
					<br/>
					@if(isset($myCat))
						<a href="/blog/categories" class="btn btn-danger">@lang("Cancel")</a>
					@endif
					<button class="btn btn-inverse">{{$button}}</button>
					{{Form::close()}}
				</div>
			</div>

		</div>
	</div>

@endsection