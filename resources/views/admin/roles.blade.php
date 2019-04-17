@extends('layouts.admin-template')
@section('title')
	@lang("User Roles")
@endsection

@section('content')
	<div class="row">
		@include('admin.settings-menu')

		<div class="col-sm-9">
			<div class="row">
				@foreach($roles as $role)
					<div class="col-sm-6">
						{{$role->name}}
					</div>
					<div class="col-sm-6 text-muted">
						{{$role->description}}
					</div>
				@endforeach
			</div>
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

				<form method="post" action="{{url('/roles')}}">
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


	<div class="modal fade" id="modulesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">@lang("New Module")</h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span>
					</button>
				</div>
				{!! Form::open(['url'=>route('modules.store'),'method'=>'post']) !!}
				<div class="modal-body">
					<label>Name<i class="small">(no spaces or special characters)</i></label>
					{!! Form::text('name',NULL,['required'=>'required','class'=>'form-control']) !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-inverse" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">@lang("Submit")</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endpush