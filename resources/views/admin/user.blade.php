@extends('layouts.admin-template')
@section('title')
	<a href="/users" class=""><i class="fa fa-arrow-circle-left"></i> </a>
	{{ucwords($user->name())}}
@endsection
@section('content')
	<div class=" card-transparent" role="tabpanel">
		<ul class="nav nav-tabs nav-fill" role="tablist">
			<li class="active nav-item"><a data-toggle="tab" class="nav-link bb0 " href="#profile">@lang("Home")</a>
			</li>
			<li class="nav-item"><a data-toggle="tab" class="nav-link bb0 " href="#history">@lang("Giving History")</a>
			</li>
			<li class="nav-item"><a data-toggle="tab" class="nav-link bb0 "
									href="#roles">@lang("Roles & Permissions")</a></li>
		</ul>
		<div class="tab-content">

			<div id="profile" class="tab-pane active" role="tabpanel">
				<div class="row">
					<div class="col-sm-6">
						<div class="card card-default">
							{!! Form::model($user,['url'=>'user/'.$user->id]) !!}

							<div class="card-body">
								{{Form::label('first_name',__('First name'))}}
								{{Form::text('first_name',null,['class'=>'form-control'])}}
								{{Form::label('last_name',__('Last name'))}}
								{{Form::text('last_name',null,['class'=>'form-control'])}}
								{{Form::label('email',__('Email'))}}
								{{Form::input('email','email',null,['class'=>'form-control'])}}
								{{Form::label('phone`	',__('Phone'))}}
								{{Form::text('phone',null,['class'=>'form-control'])}}
								{{Form::label('address',__('Address'))}}
								{{Form::textarea('address',null,['rows'=>3,'class'=>'form-control'])}}
								{{Form::label('dob',__('DOB'))}}
								{{Form::input('date','dob',null,['class'=>'form-control'])}}

							</div>
							<div class="card-footer">
								<button class="btn btn-inverse">@lang('Update')</button>
							</div>
							{!! Form::close() !!}
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card card-default">
							<div class="card-body">
								<strong>@lang("Stripe ID:"):</strong> {{$user->stripe_id}}<br/>
								<strong>@lang("Registered:"):</strong> {{$user->created_at}}
								@include('giving.manual_txn')
							</div>
						</div>
					</div>
				</div>

			</div>

			<div id="history" class="tab-pane">
				@include('giving.giving_history')
			</div>
			<div id="roles" class="tab-pane">
				{!! Form::open(['url'=>'user/'.$user->id.'/roles', 'files' => true]) !!}
                <?php
                function is_checked($user_id, $role)
                {
                    $userRoles = DB::table('role_user')->whereUserId($user_id)->get();
                    foreach ($userRoles as $ur) {
                        if($ur->role_id == $role) return 'true';
                    }
                    return "";
                }
                ?>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-striped">
							@foreach($roles as $role)
								<tr>
									<td>
										{{Form::radio('role',$role->id,(int)$currentRole==(int)$role->id)}}
									</td>
									<td valign="middle">{{ucwords($role->name)}}</td>
									<td> {{$role->description}}</td>
									<td>
										@foreach($role->permissions as $rp)
											<span class="label label-default"> {{$rp->name}}</span>
										@endforeach
									</td>
								</tr>

							@endforeach
							<tr>
								<td></td>
								<td colspan="3">
									<button class="btn btn-info">Update user roles</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection
@push('scripts')

	<script src="/plugins/numeraljs/numeral.min.js" type="text/javascript"></script>
	<script>
        $(document).ready(function () {
            $('input[name=amount]').on('blur', function () {
                let cur = $(this).val();
                let am = numeral(cur).format('0.00');
                $(this).val(am);
            });
        });
	</script>
@endpush