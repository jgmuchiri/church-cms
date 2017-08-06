/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 23);
/******/ })
/************************************************************************/
/******/ ({

/***/ 23:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(5);


/***/ }),

/***/ 5:
/***/ (function(module, exports) {

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
    if (regex.test(amount)) {
        //curreny is ok
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
    $('input[name=amount]').on('blur', function () {
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
            });
        });
    });
    $('.charge').on('click', function (event) {
        event.preventDefault();

        if (!validCurrency()) return;

        var $button = $(this),
            $form = $button.parents('form');
        var opts = $.extend({}, $button.data(), {
            token: function token(result) {
                $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id }));
                $form.append($('<input>').attr({ type: 'hidden', name: 'email', value: result.email }));
                $form.submit();
            }
        });
        StripeCheckout.open(opts);
    });
});

/***/ })

/******/ });