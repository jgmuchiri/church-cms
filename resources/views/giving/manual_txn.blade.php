{!! Form::open(['url'=>'/giving/give','id'=>'payment-form']) !!}
<table>
    <tr>
        <td class="text-right">Amount:</td>
        <td>{!! Form::text('amount',null,['placeholder'=>'Amount','required'=>'required']) !!}</td>
    </tr>
    <tr>
        <td class="text-right">Designation:</td>
        <td>  {{Form::select('gift_options_id',\App\Models\Giving\GiftOptions::whereActive(1)->pluck('name','id'),null,['class'=>'select2'])}}

        </td>
    </tr>
    <tr>
        <td class="text-right">Recurrence:</td>
        <td> <br/>
            {!! Form::select('interval',['once'=>'One time','week'=>'Weekly','month'=>'Monthly','year'=>'Yearly']) !!}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button class="btn btn-success btn-xlg charge"
                    data-key="{{env('APP_ENV')=='local'?env('STRIPE_TEST_PUBLIC'):env('STRIPE_PUBLIC')}}"
                    data-email="{{$user->email}}"
                    data-currency="{{env('CURRENCY')}}"
                    data-name="Online Contribution"
                    data-description="Online Contribution"
                    data-label="Give online"><i class="icon-credit-card"></i> Process Payment
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
            var cur = $(this).val();
            var am = numeral(cur).format('0.00');
            $(this).val(am);
        });

        $('.charge').on('click', function (event) {
            event.preventDefault();

            if (!validCurrency()) return;

            var $button = $(this),
                $form = $button.parents('form');
            var opts = $.extend({}, $button.data(), {
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