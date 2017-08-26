@extends('layouts.template')
@section('title')
    @lang("Giving Account")
@endsection
@section('crumbs')
    <a href="#" class="current">@lang("My Account")</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5></h5>

        </div>
        <div class="widget-content">
            <ul class="stat-boxes2">
                <li>
                    <div class="left">
                        <i class="icon-gift icon-4x"></i>
                    </div>
                    <div class="right">
                        <strong>
                            ${{App\Models\Billing\Transactions::whereUserId(Auth::user()->id)->sum('amount')}}
                        </strong> <a href="#gift-history">@lang("Gifts to date") </a>
                    </div>
                </li>

                <li>
                    <a class="giveBtn" href="#">
                        <div class="left">
                            <i class="icon-credit-card icon-4x"></i>
                        </div>
                        <div class="right">
                            @lang("Click to give")
                        </div>
                    </a>
                </li>

            </ul>


            <div id="gift-history">
                <h5 class="title"><i class="icon-th"></i> @lang("print history")</h5>

                <?php
                $created = date('Y', strtotime(Auth::user()->created_at));
                $thisYear = date('Y');
                $years = array();
                for ($i = $created; $i <= $thisYear; $i++) {
                    $years[$i] = $i;
                }
                ?>
                {{Form::open(['url'=>'/giving/history','method'=>'get','target'=>'blank','class'=>'form-inline'])}}
                <div class="input-group">
                    <span class="input-group-addon"> Select year:</span>
                    {{Form::select('y',$years,date('Y'))}}
                    <span class="input-group-btn">
                        <button class="btn btn-default"><i class="icon-print"></i> @lang("Print")</button>
                    </span>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("Giving history")</h5>
        </div>
        <div class="widget-content nopadding">
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
                        <td>{{env('CURRENCY_SYMBOL').$tx->amount}}</td>
                        <td>{{$tx->item}}</td>
                        <td>{{$tx->desc}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@include('partials.datatables')
@push('modals')
<div class="modal hide" id="giveForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">@lang("Thank you!")</h4>
                @lang("Complete the form below and submit")

            </div>

            {!! Form::open(['url'=>'/giving/give','id'=>'payment-form']) !!}
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td class="text-right">@lang("Amount"):</td>
                        <td> {!! Form::text('amount',null,['placeholder'=>__("Amount"),'class'=>'controls','required'=>'required']) !!}</td>
                    </tr>
                    <tr>
                        <td class="text-right">@lang("Designation"):</td>
                        <td> {{Form::select('gift_options_id',\App\Models\Giving\GiftOptions::whereActive(1)->pluck('name','id'))}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">@lang("Recurrence"):</td>
                        <td> <br/>
                            {!! Form::select('interval',['once'=>'One time','week'=>'Weekly','month'=>'Monthly','year'=>'Yearly']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            @lang("Debit/Credit Card")<br/>
                            <div id="card-element" class="field"></div></td>
                    </tr>
                </table>

                <div class="outcome">
                    <div class="error" role="alert"></div>
                    <div class="success">
                       <span class="token"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success btn-xlg charge">
                <i class="icon-credit-card"></i> @lang("Process Payment")
            </button>

        </div>
        {!! Form::close() !!}
    </div>
</div>

@endpush

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

        var stripe = Stripe('{{env('APP_ENV')=="local"?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}');
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
                },
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