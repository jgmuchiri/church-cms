@extends('layouts.admin-template')
@section('title') Edit profile @endsection
@section('content')
	<div class="row">
		<div class="col-xl-12">
			<div class="card card-default">
				<div class="card-header">
					<div class="card-title"><h3><i class="fa fa-user"></i> {{ucwords($user->name())}}</h3></div>
					@lang("Registered"):{{$user->created_at}}
					@if(!empty($user->stripe_id))
						@lang("TXN ID"): {{$user->stripe_id}}
					@endif
				</div>
				{!! Form::model($user,['url'=>'profile']) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							{{Form::label(__('First name'))}}
							{{Form::text('first_name',null,['class'=>'form-control'])}}

							{{Form::label(__('Last name'))}}
							{{Form::text('last_name',null,['class'=>'form-control'])}}

							{{Form::label(__('Email'))}}
							{{Form::input('email','email',null,['class'=>'form-control'])}}

							{{Form::label(__('DOB'))}}
							{{Form::input('date','dob',null,['class'=>'form-control'])}}
						</div>
						<div class="col-sm-6">
							{{Form::label(__('Phone'))}}
							{{Form::text('phone',null,['class'=>'form-control'])}}
							{{Form::label(__('Address'))}}
							{{Form::textarea('address',null,['rows'=>3,'class'=>'form-control'])}}
						</div>
					</div>
				</div>
				<div class="card-footer">
					{{Form::submit(__('Update'),['class'=>'btn btn-primary'])}}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card card-default">
				<div class="card-header">
					<div class="card-title"><h3>@lang('Change password')</h3></div>
				</div>
				{!! Form::model($user,['url'=>'profile/password']) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							{{Form::label(__('Current Password'))}}
							{!! Form::input('password','current_password',null,['class'=>'form-control']) !!}
							<br/>
							{{Form::label(__('Password'))}}
							{!! Form::input('password','new_password',null,['class'=>'form-control']) !!}
							{{Form::label(__('Confirm Password'))}}
							{!! Form::input('password','password_confirmation',null,['class'=>'form-control']) !!}
						</div>
					</div>
				</div>
				<div class="card-footer">
					{{Form::submit(__('Update'),['class'=>'btn btn-primary'])}}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop