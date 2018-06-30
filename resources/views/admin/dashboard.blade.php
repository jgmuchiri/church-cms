@extends('layouts.admin-template')
@section('content')
	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card flex-row align-items-center align-items-stretch border-0">
				<div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
					<em class="fa fa-money fa-3x"></em>
				</div>
				<div class="col-8 py-3 bg-white rounded-right">
					<div class="h2 mt-0"> ${{App\Models\Billing\Transactions::sum('amount')}}</div>
					<div class="text-uppercase"> @lang("Gifts")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card flex-row align-items-center align-items-stretch border-0">
				<div class="col-4 d-flex align-items-center  bg-purple-dark justify-content-center rounded-left">
					<em class="fa fa-envelope fa-3x"></em>
				</div>
				<div class="col-8 py-3 bg-white rounded-right">
					<div class="h2 mt-0"> ${{App\Models\Billing\Transactions::sum('amount')}}</div>
					<div class="text-uppercase">  @lang("Messages")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card flex-row align-items-center align-items-stretch border-0">
				<div class="col-4 d-flex align-items-center  bg-green-dark justify-content-center rounded-left">
					<em class="fa fa-th fa-3x"></em>
				</div>
				<div class="col-8 py-3 bg-white rounded-right">
					<div class="h2 mt-0">  {{App\Models\Sermons::count()}}</div>
					<div class="text-uppercase">   @lang("Sermons")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card flex-row align-items-center align-items-stretch border-0">
				<div class="col-4 d-flex align-items-center bg-yellow-dark justify-content-center rounded-left">
					<em class="fa fa-support fa-3x"></em>
				</div>
				<div class="col-8 py-3 bg-white rounded-right">
					<div class="h2 mt-0">  {{App\Models\Kb::whereActive(0)->count()}}</div>
					<div class="text-uppercase">@lang("Support")</div>
				</div>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-xl-12">
			<div class="card card-default card-demo" id="cardChart9">
				<div class="card-header">
					<a class="float-right" href="#" data-tool="card-refresh" data-toggle="tooltip" title=""
					   data-original-title="Refresh card">
						<em class="fa fa-refresh"></em>
					</a>
					<a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
					   data-original-title="Collapse card">
						<em class="fa fa-minus"></em>
					</a>
					<div class="card-title">@lang("Site Analytics")</div>
				</div>
				<div class="card-wrapper collapse show">
					<div class="card-body">
						@include('giving.monthly-gift-stats')
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card bg-info-light pt-2 b0">
				<div class="px-2">
					<em class="fa fa-group fa-lg float-right"></em>
					<div class="h2 mt-0">{{\App\User::count()}}</div>
					<div class="text-uppercase">@lang("Total User(s)")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-info-light pt-2 b0">
				<div class="px-2">
					<em class="fa fa-leaf fa-lg float-right"></em>
					<div class="h2 mt-0">{!! \App\Models\Blog\Blog::count() !!}</div>
					<div class="text-uppercase">@lang("Blog articles")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-info-light pt-2 b0">
				<div class="px-2">
					<em class="fa fa-calendar-o fa-lg float-right"></em>
					<div class="h2 mt-0">{{\App\Models\Events::count()}}</div>
					<div class="text-uppercase">@lang("Events")</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-info-light pt-2 b0">
				<div class="px-2">
					<em class="fa fa-th-list fa-lg float-right"></em>
					<div class="h2 mt-0">{{\App\Models\Ministry\Ministry::count()}}</div>
					<div class="text-uppercase">@lang("Ministries")</div>
				</div>
			</div>
		</div>
	</div>
@endsection