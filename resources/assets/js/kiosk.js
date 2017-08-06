/**
 * @copyright   2017 A&M Digital Technologies
 * @author      John Muchiri | john@amdtllc.com
 * @link        https://amdtllc.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * @returns {boolean}
 */
function validCurrency() {
    var amount = $('input[name=amount]').val();

    var regex = /^\d+(?:\.\d{0,2})$/;
    if (regex.test(amount)) {//curreny is ok
        if (amount === '0.00') {
            alert('Amount entered must be greater than zero');
            return false;
        }
        return true;
    } else {
        alert('Amount entered is invalid');
        return false;
    }
}

$('document').ready(function () {
    $('input[name=amount]').on('blur',function () {
        var cur = $(this).val();
        var am = numeral(cur).format('0.00');
        $(this).val(am);
    });

    $('.giveBtn').click(function (e) {
        $('#giveForm').modal('show');

        $(".gift-option-help").click(function (e) {
            var option = $('select[name=gift_option_id]').val();
            $.get('/giving/option-info/' + option, function (data) {
                var modal = $('#gift-option-help-modal');
                var res = JSON.parse(data);
                modal.find('.modal-title').text(res.name);
                modal.find('.modal-body').html(res.desc);
                modal.modal('show');
            })
        })
    });
    $('.charge').on('click', function (event) {
        event.preventDefault();

        if (!validCurrency()) return;

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
