@extends('layouts.kiosk')

@section('content')
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 col-xs-12 giveBtn kiosk ">

			<div class="fa fa-big fa fa-info text-center">
				<i class="fa fa-credit-card"></i>
			</div>

			<h2> @lang("Give online") <i class="fa fa-hand-o-up"></i></h2>
			<h4 class="text-yellow">@lang("we accept")</h4>

			<i class="fa fa-cc-mastercard fa-2x"></i>
			<i class="fa fa-cc-visa fa-2x"></i>
			<i class="fa fa-cc-amex fa-2x"></i>
			<i class="fa fa-cc-discover fa-2x"></i>
			<i class="fa fa-cc-paypal fa-2x"></i>
		</div>

	</div>
	<hr/>
	<div class="row ">
		<div class="col-sm-4" onclick="window.location.href='/events'">
			<div class="text-center">
				<i class="fa fa-calendar"></i>
			</div>
			<h2> @lang("Events")</h2>
			<h3 class="text-yellow">@lang("register for upcoming events")</h3>
		</div>

		<div class="col-sm-4" onclick="window.location.href='/sermons'">
			<div class="text-center">
				<i class="fa fa-list"></i>
			</div>
			<h2> @lang("Sermons")</h2>
			<h3 class="text-yellow">@lang("Browse recent sermons")</h3>
		</div>

		<div class="col-sm-4" onclick="window.location.href='/sermons'">
			<div class="ftext-center">
				<i class="fa fa-th"></i>
			</div>
			<h2> @lang("Ministries")</h2>
			<h3 class="text-yellow">@lang("Become a part of the family")</h3>
		</div>
	</div>
@endsection

@push('modals')
	<div class="modal show" id="giveForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content modal-md">

				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">@lang("Thank you!")</h4>
					@lang("Complete the form below and submit")

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				@include('partials.demo-warning')

				{!! Form::open(['url'=>'/giving/guest-giving','id'=>'payment-form']) !!}
				{!! Form::hidden('interval','once') !!}

				<div class="modal-body charge-content">

					<div class="input-group">
						<span class="input-group-addon text-right">@lang("Amount"):</span>
						{!! Form::text('amount',null,['placeholder'=>__("Amount"),'required'=>'required','class'=>'form-control']) !!}
					</div>
					<br/>

					<div class="input-group">
						<span class="input-group-addon text-right">@lang("Designation"):</span>
						{{Form::select('gift_options_id',DB::table('gift_options')->whereActive(1)->pluck('name','id'),null,['class'=>'form-control','style'=>'width:360px'])}}
						<span class="input-group-addon cursor gift-option-help">
                        <a href="#" class=""> <i class="fa fa-question"></i></a>
                    </span>
					</div>

				</div>

				<div class="modal-footer" style="border:none">
					<button class="btn btn-success btn-xlg charge"
							data-key="{{env('APP_ENV')=='local'?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}"
							data-currency="{{env('CURRENCY')}}"
							data-name="@lang("Online Contribution")"
							data-description="@lang("Online Contribution")"
							data-label="Give online"><i class="fa fa-credit-card"></i>
						@lang("Process Payment")
					</button>
				</div>

				{!! Form::close() !!}

			</div>
		</div>
	</div>

	<div class="modal fade" id="gift-option-help-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-inverse" data-dismiss="modal">@lang("Close")</button>
				</div>
			</div>
		</div>
	</div>

@endpush