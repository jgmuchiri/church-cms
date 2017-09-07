@extends('layouts.public')

@section('content')

    <div class="jumbotron"
         style="-webkit-background-size: 100%;background-size: 100%;">
        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <h1>@lang("Online Giving")</h1>

                </div>
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="icon-check"></i>
                            @lang("Secure online giving")
                        </li>
                        <li class="list-group-item">
                            <i class="icon-check"></i>
                            @lang("Easy processing")
                        </li>
                        <li class="list-group-item"><i class="icon-check"></i> @lang("Transparent accounting")</li>
                        <li class="list-group-item">
                            <i class="icon-check"></i>
                            @lang("Recurring giving")
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2>@lang("Account access")</h2>
                <a href="/login" class="btn btn-info btn-lg"><i class="icon-lock"></i> @lang("Login/Register to give online")</a>
            </div>
            <div class="col-sm-6">
                <h2>@lang("Guest giving")</h2>
                <a class="btn btn-warning btn-lg giveBtn" href="#"><i class="icon-new-window"></i> @lang("Click to give")</a>
            </div>
        </div>
    </div>

@endsection

@push('modals')
    <div class="modal hide" id="giveForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width:330px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        @lang("Thank you!")
                    </h4>
                    @lang("Complete the form below and submit")
                </div>
                @include('partials.demo-warning')
                <div class="modal-body">

                    {!! Form::open(['url'=>'/guest-giving','id'=>'payment-form']) !!}
                    <div class="input-group">
                        <span class="input-group-addon text-right" style="width:100px;">@lang("Amount"):</span>
                        {!! Form::text('amount',null,['placeholder'=>'Amount','required'=>'required']) !!}
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon text-right">
                            @lang("Designation"):</span>
                        {{Form::select('desc',DB::table('gift_options')->whereActive(1)->pluck('name','name'))}}
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon">
                            @lang("Recurrence"):
                        </span>
                        {!! Form::select('interval',['once'=>__("One time"),'week'=>__("Weekly"),'month'=>__("Monthly"),'year'=>__("Yearly")]) !!}
                    </div>
                    <br/>
                    <button class="btn btn-success btn-xlg charge"
                            data-key="{{env('APP_ENV')=='local'?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}"
                            data-image="/images/checkout.png"
                            data-currency="{{env('CURRENCY')}}"
                            data-name="Online Contribution"
                            data-description="Online Contribution"
                            data-label="Give online"><i class="icon-credit-card"></i>
                        @lang("Process Payment")
                    </button>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

@endpush

@push('scripts')
    <script>
        $('.giveBtn').click(function (e) {
            $('#giveForm').modal('show');
        });
    </script>
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script>
        $(document).ready(function () {

            $('.charge').on('click', function (event) {
                event.preventDefault();

                if(!validCurrency()) return;

                var $button = $(this),
                        $form = $button.parents('form');
                var opts = $.extend({}, $button.data(), {
                    token: function (result) {
                        $form.append($('<input>').attr({type: 'hidden', name: 'stripeToken', value: result.id}));
                        $form.append($('<input>').attr({type: 'hidden', name: 'email', value: result.email}));
                        $form.submit();
                    }
                });
                StripeCheckout.open(opts);
            });
        });
    </script>
@endpush