{!! Form::open(['url'=>'/giving/give','id'=>'payment-form']) !!}
<table class="table">
    <tr>
        <td class="text-right">@lang("Amount"):</td>
        <td>{!! Form::text('amount',null,['placeholder'=>'Amount','required'=>'required','class'=>'form-control']) !!}</td>
    </tr>
    <tr>
        <td class="text-right">@lang("Designation"):</td>
        <td>  {{Form::select('gift_options_id',\App\Models\Giving\GiftOptions::whereActive(1)->pluck('name','id'),null,['class'=>'select2 form-control'])}}

        </td>
    </tr>
    <tr>
        <td class="text-right">@lang("Recurrence"):</td>
        <td> <br/>
            {!! Form::select('interval',['once'=>__("One time"),'week'=>__("Weekly"),'month'=>__("Monthly"),'year'=>__("Yearly")],null,['class'=>'form-control']) !!}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button class="btn btn-success btn-xlg charge"
                    data-key="{{env('APP_ENV')=='local'?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}"
                    data-email="{{$user->email}}"
                    data-currency="{{env('CURRENCY')}}"
                    data-name="@lang("Online Contribution")"
                    data-description="@lang("Online Contribution")"
                    data-label="@lang("Give online")"><i class="fa fa-credit-card"></i> @lang("Process Payment")
            </button>
        </td>
    </tr>
</table>

{!! Form::close() !!}

@push('scripts')
<script src="/plugins/numeraljs/numeral.min.js" type="text/javascript"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script>
    $(document).ready(function () {
        $('input[name=amount]').on('blur', function () {
            let cur = $(this).val();
            let am = numeral(cur).format('0.00');
            $(this).val(am);
        });

        $('.charge').on('click', function (event) {
            event.preventDefault();
            if (!validCurrency()) return;
            let $button = $(this),
                $form = $button.parents('form');
            let opts = $.extend({}, $button.data(), {
                token: function (result) {
                    $form.append($('<input>').attr({type: 'hidden', name: 'stripeToken', value: result.id}));
                    $form.append($('<input>').attr({type: 'hidden', name: 'user_id', value: '{{$user->id}}'}));
                    $form.submit();
                }
            });
            StripeCheckout.open(opts);
        });
    });
</script>
@endpush