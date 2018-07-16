@extends('layouts.admin-template')
@section('title')
	@lang("Giving Account")
@endsection
@section('crumbs')
	<a href="#" class="current">@lang("My Account")</a>
@endsection

@section('content')
	<div class="row">
		<div class="col-xl-8">
			<div class="row">
				<div class="col-xl-4">
					<div class="card flex-row align-items-center align-items-stretch border-0">
						<div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
							<em class="fa fa-history fa-3x"></em>
						</div>
						<div class="col-8 py-3 bg-white rounded-right">
							<div class="h2 mt-0">
								${{App\Models\Billing\Transactions::whereUserId(Auth::user()->id)->sum('amount')}}</div>
							<div class="text-uppercase">@lang("Gifts to date") </div>
						</div>
					</div>
				</div>
				<div class="col-xl-4">
					<div class="card card-default card-demo" id="cardChart9">
						<div class="card-wrapper collapse show">
							<div class="card-body"><h5> @lang("Print history")</h5>
								<div id="gift-history">
                                    <?php
                                    $created = date('Y', strtotime(Auth::user()->created_at));
                                    $thisYear = date('Y');
                                    $years = array();
                                    for ($i = $created; $i<=$thisYear; $i++) {
                                        $years[$i] = $i;
                                    }
                                    ?>
									{{Form::open(['url'=>'/giving/history','method'=>'get','target'=>'blank','class'=>'form-inline'])}}
									<div class="input-group">
										{{Form::select('y',$years,date('Y'),['class'=>'form-control'])}}
										<span class="input-group-btn">
											<button class="btn btn-primary btn-flat"><i class="fa fa-print"></i> @lang("Print")</button>
										</span>
									</div>
									{{Form::close()}}
								</div>
							</div>
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
							<div class="card-title"><span class="fa fa-history"></span> @lang("Giving history")</div>
						</div>
						<div class="card-wrapper collapse show">
							<div class="card-body">
								<table class="table table-bordered data-table selec2">
									<thead>
									<tr>
										<th>@lang("Date")</th>
										<th>@lang("ID")</th>
										<th>@lang("Amount")</th>
										<th>@lang("Name")</th>
										<th>@lang("Description")</th>
									</tr>
									</thead>
									<tbody>
									@foreach($txns as $tx)
										<tr>
											<td>{{date('d M y',strtotime($tx->created_at))}}</td>
											<td>{{$tx->txn_id}}</td>
											<td>{{config('app.currency.symbol').$tx->amount}}</td>
											<td>{{$tx->item}}</td>
											<td>{{$tx->desc}}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="row">
				<div class="col-xl-12">
					<div class="card card-default">
						<div class="card-header">
							<div class="card-title">@lang("Complete the form below to give")
								<br/>@lang("Thank you!")
							</div>
						</div>
						{!! Form::open(['url'=>'/giving/give','id'=>'payment-form']) !!}
						<div class="card-body">
							<table>
								<tr>
									<td class="text-right">@lang("Amount"):</td>
									<td> {!! Form::text('amount',null,['placeholder'=>__("Amount"),'class'=>'controls form-control','required'=>'required']) !!}</td>
								</tr>
								<tr>
									<td class="text-right">@lang("Designation"):</td>
									<td> {{Form::select('gift_options_id',\App\Models\Giving\GiftOptions::whereActive(1)->pluck('name','id'),null,['class'=>'form-control'])}}</td>
								</tr>
								<tr>
									<td class="text-right">@lang("Recurrence"):</td>
									<td>
										{!! Form::select('interval',['once'=>'One time','week'=>'Weekly','month'=>'Monthly','year'=>'Yearly'],null,['class'=>'form-control']) !!}
									</td>
								</tr>
							</table>
							<div class="outcome">
								<div class="error" role="alert"></div>
								<div class="success"><span class="token"></span></div>
							</div>
						</div>
						<div class="card-body bg-white">
							@lang("Debit/Credit Card")<br/><br/>
							<div id="card-element" class="field"></div>
							<br/>
							<button class="btn btn-success btn-xlg charge">
								<i class="fa fa-credit-card"></i> @lang("Process Payment")
							</button>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@include('partials.datatables')
@push('scripts')
	<script>
        $('.giveBtn').click(function () {
            $('#giveForm').modal('show');
        });
	</script>
	<script src="/plugins/numeraljs/numeral.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<script>
        $(document).ready(function () {
            $('input[name=amount]').on('blur', function () {
                var cur = $(this).val();
                var am = numeral(cur).format('0.00');
                $(this).val(am);
            });
            var stripe = Stripe('{{config('app.env')=="local"?config('app.stripe.test.public'):config('app.stripe.live.public')}}');
            var elements = stripe.elements();
            var style = {
                base: {
                    color: '#53cc8e',
                    lineHeight: '24px',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {style: style});
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
	</script>
@endpush