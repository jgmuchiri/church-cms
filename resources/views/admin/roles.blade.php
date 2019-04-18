@extends('layouts.admin-template')
@section('title')
	@lang("User Roles")
@endsection

@section('content')
	<div class="row">
		@include('admin.settings-menu')

		<div class="col-sm-9">

			<h3>@lang('Roles')
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#roleModal">
					<i class="fa fa-plus"></i> @lang('New role')
				</button>
			</h3>


			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Modal title</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
			@foreach($roles as $role)
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								{{strtoupper($role->name)}}
							</div>
							<div class="col-sm-6 text-muted">
								{{$role->description}}
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection

@push('modals')

	<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> @lang("New Role")
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

				<form method="post" action="{{route('create.role')}}">
					@csrf

					<div class="modal-body">
						<div class="form-group">
							<label>@lang("Name")<i class="small">@lang("(no spaces or special characters)")</i></label>
							<input type="text" class="form-control" name="name" required/>
						</div>
						<div class="form-group">
							<label>@lang("Description")</label>
							<input type="text" class="form-control" name="description" required>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-inverse" data-dismiss="modal">Close</button>
						<button class="btn btn-primary">@lang("Submit")</button>
					</div>

				</form>

			</div>
		</div>
	</div>

@endpush