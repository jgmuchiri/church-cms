@extends('layouts.admin-template')
@section('title')
	Birthdays
@endsection

@section('content')
	<div class="row">
		<div class="col-xl-12">
			<div class="card card-default">
				<div class="card-header">
					<div class="card-title">

						<form method="get" id="search">
							<div class="input-group">
								{{Form::select('m',$months)}}
								<span class="input-group-btn">
                                        <button class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
							</span>

								@role('admin')
								<a href="/messaging/admin" class="input-group-btn btn btn-warning pull-right"><i
											class="icon-envelope-alt"></i> @lang("Send birthday
        message")</a>
								@endrole
							</div>

						</form>
					</div>
				</div>
				<div class="card-body">
					<hr/>
					<h4>
						@if(isset($_GET['m']))
							<a href="/birthdays"><i class="fa fa-chevron-left"></i> </a>
							{{date("F", mktime(0, 0, 0, $_GET['m'], 10))}} @lang('Birthdays')
						@else
							{{date('F')}} @lang('Birthdays')
						@endif
					</h4>

					<table class="table table-striped my-4 w-100 datatable" id="datatable">
						<tr>
							<th>@lang("Firstname")</th>
							<th>@lang("Lastname")</th>
							<th>@lang("Email")</th>
							<th>@lang("Phone")</th>
							<th>@lang("Birthday")</th>
						</tr>
						@foreach($users as $user)
							<tr>
								<td>{{$user->email}}</td>
								<td>{{$user->first_name}}</td>
								<td>{{$user->last_name}}</td>
								<td>{{$user->phone}}</td>
								<td>{{$user->dob}}</td>
							</tr>
						@endforeach

					</table>
				</div>
			</div>
		</div>
		<div class="card-footer">

		</div>

	</div>
@endsection