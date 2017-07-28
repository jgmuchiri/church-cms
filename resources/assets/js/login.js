$(document).ready(function(){

    var login = $('#loginform');
    var recover = $('#recoverform');
    var register = $('#registerform');

    var speed = 400;

    $('.to-recover').click(function(){

        $("#loginform").slideUp();
        $("#registerform").hide();
        $("#recoverform").fadeIn();

    });
    $('.to-login').click(function(){

        $("#recoverform").hide();
        $("#registerform").hide();
        $("#loginform").fadeIn();
    });
    $('.to-register').click(function () {
        $("#recoverform").hide();
        $("#loginform").hide();
        $("#registerform").fadeIn();
    });
});