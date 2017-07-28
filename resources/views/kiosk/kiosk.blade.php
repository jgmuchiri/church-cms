@extends('layouts.template')
@section('title')
    {{env('COMPANY_NAME')}} KIOSK
@endsection

@section('content')
    <div class="text-center kiosk-logo">
        @if(is_file('/img/logo.png'))
            <img src="/img/logo.png"/>
        @else
            <h3>{{env('COMPANY_NAME')}}</h3>
            {{env('TAG_LINE')}}

        @endif

        <h4>KIOSK</h4>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-3 col-sm-6 giveBtn">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-info text-center">
                                <i class="icon-credit-card"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                Give online
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                           <img style="width:100%;height:100%" src="/img/credit-cards.jpg"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-lg-3 col-sm-6" onclick="window.location.href='/store'">--}}
            {{--<div class="card">--}}
                {{--<div class="content">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-xs-5">--}}
                            {{--<div class="icon-big icon-success text-center">--}}
                                {{--<i class="icon-shopping-cart"></i>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-7">--}}
                            {{--<div class="numbers">--}}
                                {{--Store--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="footer">--}}
                        {{--<hr/>--}}
                        {{--<div class="stats">--}}
                            {{--Browse items on sale today--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="col-lg-3 col-sm-6" onclick="window.location.href='/events'">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-warning text-center">
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                Events
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                            Register upcoming events
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .col-lg-3{
            cursor: pointer;
        }
        .sidebar {
            display: none;
        }

        .main-panel {
            margin: 0 auto;
            float: left;
            width: 100%;
            overflow: hidden;
            background: #2376ff url(/img/wheat.jpg);
            -webkit-background-size: cover;
            background-size: cover;
        }
        
    .kiosk-logo{
        padding:5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background: #fff0b3;
    }
        a[href='/support'] {
            display: none !important;:
        }
        .navbar{
            display: none !important;
        }
    </style>
@endpush

@push('modals')
    <div class="modal hide" id="giveForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width:330px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Thank you!</h4>
                    Complete the form below and submit
                </div>
                @include('partials.demo-warning')
                <div class="modal-body">

                    {!! Form::open(['url'=>'/guest-giving','id'=>'payment-form']) !!}
                    <div class="input-group">
                        <span class="input-group-addon text-right" style="width:100px;">Amount:</span>
                        {!! Form::text('amount',null,['placeholder'=>'Amount','required'=>'required']) !!}
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon text-right">Designation:</span>
                        {{Form::select('desc',DB::table('gift_options')->whereActive(1)->pluck('name','name'))}}
                    </div>
                    <br/>
                    <button class="btn btn-success btn-xlg charge"
                            data-key="{{env('APP_ENV')=='local'?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}"
                            data-image="/img/checkout.png"
                            data-currency="{{env('CURRENCY')}}"
                            data-name="Online Contribution"
                            data-description="Online Contribution"
                            data-label="Give online"><i class="icon-credit-card"></i> Process Payment
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