/**
 * @param num
 */
function formatCurrency(num) {
    //format currency inputs
    var cur = $(this).val();
    var am = numeral(cur).format('0.00');
    $(this).val(am);
}

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
$(document).ready(function () {
    //logout function
     $('.logout').click(function () {
        $.ajax({
            url: '/logout',
            data: {_token: CRSF_TOKEN}, //$('form').serialize(),
            type: 'POST',
            success: function (response) {
                window.location.href = '/';
            },
            error: function (error) {
                window.location.href = '/';
            }
        });
    });


    //warn on delete
    $('.delete').click(function(e){
        var loc =$(this).attr('href');
        swal({
            title:'Are you sure?',
            text:'This action is permanent. You will loose the data',
            type:'warning',
            showCancelButton:true,
            confirmButtonColor:'#DD6B55',
            confirmButtonText:'Yes, Do it!',
            closeOnConfirm:false
        },function(){
            swal('Delete action successful');
            if(loc !==undefined)
                window.location.href=loc;
        });
        e.preventDefault();
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="popover"]').popover();

    // show active tab on reload
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
    // remember the hash in the URL without jumping
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if (history.pushState) {
            history.pushState(null, null, '#' + $(e.target).attr('href').substr(1));
        } else {
            location.hash = '#' + $(e.target).attr('href').substr(1);
        }
    });
});
