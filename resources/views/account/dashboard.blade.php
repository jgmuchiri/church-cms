@extends('layouts.template')
@section('title')
    Giving Account
@endsection
@section('crumbs')
    <a href="#" class="current">My Account</a>
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
                        </strong> <a href="#gift-history">Gifts to date </a>
                    </div>
                </li>

                <li>
                    <a class="giveBtn" href="#">
                        <div class="left">
                            <i class="icon-credit-card icon-4x"></i>
                        </div>
                        <div class="right">
                            <strong>Click</strong>
                            to give
                        </div>
                    </a>
                </li>

            </ul>


            <div id="gift-history">
                <h5 class="title"><i class="icon-th"></i> print history</h5>

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
                        <button class="btn btn-default"><i class="icon-print"></i> Print</button>
                    </span>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>Giving history</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table selec2">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>d</td>
                    <td>d</td>
                    <td>d</td>
                    <td>d</td>
                    <td>d</td>
                </tr>
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
                <h4 class="modal-title" id="myModalLabel">Thank you!</h4>
                Complete the form below and submit

            </div>

            {!! Form::open(['url'=>'/giving/manual-giving','id'=>'payment-form']) !!}
            <div class="modal-body">
                <table>
                    <tr>
                        <td class="text-right">Amount:</td>
                        <td> {!! Form::text('amount',null,['placeholder'=>'Amount','required'=>'required']) !!}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Designation:</td>
                        <td> {{Form::select('desc',DB::table('gift_options')->whereActive(1)->pluck('name','name'))}}</td>
                    </tr>
                    <tr>
                        <td class="text-right"> Recurrence:</td>
                        <td>{!! Form::select('interval',['once'=>'One time','week'=>'Weekly','month'=>'Monthly','year'=>'Yearly']) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success btn-xlg charge"
                    data-key="{{(env('APP_ENV')=='local')? env('STRIPE_TEST_PUBLIC') : env('STRIPE_PUBLIC')}}"
                    data-image="/img/checkout.png"
                    data-email="{{Auth::user()->email}}"
                    data-currency="{{env('CURRENCY')}}"
                    data-name="Online Contribution"
                    data-description="Online Contribution"
                    data-label="Give online"><i class="icon-credit-card"></i> Process Payment
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
<script src="/plugins/numeral/numeral.min.js"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script>
    $(document).ready(function () {
        $('.charge').on('click', function (event) {
            event.preventDefault();

            if (!validCurrency()) return;

            var $button = $(this),
                $form = $button.parents('form');
            var opts = $.extend({}, $button.data(), {
                token: function (result) {
                    $form.append($('<input>').attr({
                        type: 'hidden',
                        name: 'stripeToken',
                        value: result.id
                    }));
                    $form.append($('<input>').attr({
                        type: 'hidden',
                        name: 'user_id',
                        value: '{{Auth::user()->id}}'
                    }));
                    $form.submit();
                }
            });
            StripeCheckout.open(opts);
        });
    });
</script>
@endpush