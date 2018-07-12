@extends('layouts.admin-template')
@section('title')
	{{$title}}
@endsection

@section('content')
	<div class="card card-default">
		<div class="card-header">
			<div class="buttons">
				<a target="_blank" href="/ministries" class="btn btn-info btn-sm">
					<i class="fa fa-home"></i> @lang("Ministries Homepage")
				</a>
				<a href="/ministries/categories" class="btn btn-primary btn-sm">
					<i class="fa fa-list-alt"></i> @lang("Categories")
				</a>
				<a href="/ministries/create" class="btn btn-inverse btn-sm">
					<i class="fa fa-plus"></i> @lang("New Ministry")
				</a>
			</div>
		</div>
	</div>

	<div class="card card-default">
		<div class="card-body">
			<div class="row">

				<div class="col-sm-12">

					<form class="form-inline" method="get">
						<div class="controls">
							<div class="input-group">
                                <span class="add-on">
                                @if(isset($_GET['s']))
										<a href="/ministries/admin" class="btn btn-inverse">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
									@endif
                                    </span>
								<input type="text" name="s" placeholder="Search by name" class="form-control"/>
								<button class="btn btn-inverse"><i class="fa fa-search"></i></button>

							</div>
						</div>
					</form>
				</div>
			</div>

			@if(!empty($ministries))
				<table class="table table-striped">
					<thead>
					<tr>
						<th>@lang('Status')</th>
						<th>@lang("Date")</th>
						<th>@lang("Category")</th>
						<th>@lang("Title")</th>
						<th>@lang("Created On")</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach($ministries as $m)
						<tr>
							<td>
								@if($m->active == 0)
									<i class="fa fa-times-circle text-danger"></i>
								@else
									<i class=" fa fa-check text-success"></i>
								@endif
							</td>
							<td>
								{{date('d M y',strtotime($m->created_at))}}
							</td>
							<td>
								{{$m->category->name}}
							</td>
							<td>{{$m->name}}</td>
							<td>{{date('d M, Y',strtotime($m->created_at))}}</td>
							<td>
								<a class="btn btn-xs btn-inverse" href="/ministries/{{$m->id}}?preview"
								   target="_blank">
									@lang("Preview") <i class="fa fa-external-link"></i>
								</a>
								<a href="/ministries/{{$m->id}}/edit" class="btn btn-info btn-xs edit">
									<i class="fa fa-pencil"></i> @lang("edit")</a>
								<a href="/ministries/{{$m->id}}/delete" class="btn btn-danger btn-xs  delete">
									<i class="fa fa-trash"></i> @lang("delete")</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				{{$ministries->links()}}
			@else
				<hr/>
				<div class="alert alert-danger">@lang("No records found")</div>
			@endif
		</div>
	</div>

@endsection
@push('scripts')
	<script>
        $('.delete').click(function (e) {
            if (confirm('@lang("Are you sure?")')) {
                return true;
            }
            e.preventDefault();
            return false;
        })
	</script>
@endpush