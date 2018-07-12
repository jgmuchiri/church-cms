@extends('layouts.admin-template')
@section('title')
	<i class="fa fa-wrench"></i>   @lang("System Settings")
@endsection
@section('content')
	<div class="row">
		@include('admin.settings-menu')

		<div class="col-xl-9">
			<div class="row">
				<div class="col-sm-7">
					<div class="card card-default">

						<div class="card-body">
							<i class="fa fa-warning"></i>
							@lang("All site configurations are managed in") <code>.evn</code> @lang("file located in the root
                            of your application.")<br/>
							<p class="text-danger">
								@lang("Change these settings only if you know what you are doing!")
							</p>

							<div class="alert alert-danger">
								{!! Form::open(['url'=>'settings/backup']) !!}
								<button class="btn btn-warning"><i class="fa fa-database"></i> @lang("Backup First!")</button>
								{!! Form::close() !!}
							</div>
							<div class="panel panel-default">
								<div class="panel-body">
									{!! Form::open() !!}
									{!! Form::textarea('envContent',$envContent,['rows'=>20,'class'=>'col-sm-12']) !!}
									<button class="btn btn-inverse"><i class="fa fa-save"></i> @lang("Update")</button>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-5">
					<div class="card card-default">
						<div class="card-body">
							{!! Form::open(['url'=>'settings/logo','method'=>'post','files'=>'true']) !!}
							<label>Upload logo </label>

							<img class="thumbnail" src="/img/logo.png"
								 style="width:300px;"/>

							{{Form::file('logo')}}
							<hr/>

							<button class="btn btn-success">@lang("Update")</button>

							{!! Form::close() !!}
						</div>
					</div>
				</div>

			</div>
			</div>

	</div>

@endsection
