<?php
$thisMonth = date('m');
$nextMonth = date('m', strtotime(\Carbon\Carbon::now()->addMonths(1)));
?>
@extends('layouts.admin-template')
@section('title')
	@lang("Registered Users")
@endsection

@section('content')
	@if(isset($_GET['s']))
		<a href="/users" class="btn btn-default btn-sm">
			<i class="fa fa-chevron-circle-left"></i>
		</a>
	@endif

	<div class="row">
		<div class="col-sm-6">
			<div class="card card-default">
				<div class="card-body">
					<div class="media">
						<div class="align-self-start mr-2">
                        <span class="fa-stack">
                                    <em class="fa fa-circle fa-stack-2x text-purple"></em>
                                    <em class="fa fa-star fa-stack-1x fa-inverse text-white"></em>
                                 </span>
						</div>
						<div class="media-body text-truncate">
							<p class="mb-1">
								<a class="text-purple m-0" href="/birthdays">@lang("Birthdays")</a>
							</p>
							<p class="m-0">
								<a href="/birthdays?m={{$thisMonth}}" class="">
										<span class="btn btn-oval btn-info btn-inverse btn-xs">
											{{App\User::where('dob','LIKE',"%-$thisMonth-%")->count()}}
										</span>
									@lang("This month")
								</a>

								<a href="/birthdays?m={{$nextMonth}}" class="">
										<span class="btn btn-oval btn-info btn-inverse btn-xs">
											{{App\User::where('dob','LIKE',"%-$nextMonth-%")->count()}}
										</span>
									@lang("Next month")
								</a>
							</p>
						</div>
						<div class="ml-auto">
							<a href="/messaging/admin"><i class="fa fa-envelope"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<button class="btn btn-default newUser"><i class="fa fa-plus"></i>@lang("New User")</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-default">
				<div class="card-header"><span class="icon"><i class="fa fa-th"></i></span>
					<h5>@lang("Users")</h5>
				</div>
				<div class="card-body nopadding">
					<table class="table table-striped my-4 w-100" id="users">
						<thead>
						<tr>
							<th>@lang("Email")</th>
							<th>@lang("Firstname")</th>
							<th>@lang("Lastname")</th>
							<th>@lang("Phone")</th>
							<th>@lang("Registered")</th>
						</tr>
						</thead>
						<tbody>
						@foreach($users as $user)
							<tr>
								<td><a href="/user/{{$user->id}}">{{$user->email}}</a></td>
								<td>{{$user->first_name}}</td>
								<td>{{$user->last_name}}</td>
								<td>{{$user->phone}}</td>
								<td>{{$user->created_at}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
@include('partials.datatables')
@push('scripts')
	<script type="text/javascript">
        $('document').ready(function () {
            $('.newUser').click(function () {
                $('#newUser').modal('show');
            });
			@if(count($errors))
            $('#newUser').modal('show');
			@endif
        });
	</script>
@endpush
@push('modals')
	<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">@lang("Register a user")</h4>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				{!! Form::open(['url'=>'registerUser']) !!}
				<div class="modal-body">
					{{Form::label('email',__('Email'))}}
					{{Form::input('email','email',null,['class'=>'form-control','required'=>'required'])}}
					{{Form::label('first_name',__('First name'))}}
					{{Form::text('first_name',null,['class'=>'form-control'])}}
					{{Form::label('last_name',__('Last name'))}}
					{{Form::text('last_name',null,['class'=>'form-control'])}}
					{{Form::label('phone',__('Phone'))}}
					{{Form::text('phone',null,['class'=>'form-control'])}}
					{{Form::label('address',__('Address'))}}
					{{Form::textarea('address',null,['rows'=>3,'class'=>'form-control'])}}
					{{Form::label('date',__('Date'))}}
					{{Form::input('date','dob',null,['class'=>'form-control'])}}
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('Close')</button>
					<button class="btn btn-primary">@lang('Update')</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endpush