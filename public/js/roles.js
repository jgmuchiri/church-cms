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
/******/ 	return __webpack_require__(__webpack_require__.s = 26);
/******/ })
/************************************************************************/
/******/ ({

/***/ 26:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(8);


/***/ }),

/***/ 8:
/***/ (function(module, exports) {

/**
 * @copyright   2017 A&M Digital Technologies
 * @author      John Muchiri | john@amdtllc.com
 * @link        https://amdtllc.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
var tokenElement = $('meta[name="csrf-token"]');
var _token = tokenElement.attr('content');

function editRole(role_id) {
    $.ajax({
        url: '/role',
        data: { _token: _token, role_id: role_id }, //$('form').serialize(),
        type: 'POST',
        success: function success(data) {
            var modal = $('#roleModal');
            modal.find('form').attr('action', '/update-role/' + role_id);
            modal.find('.modal-header').html('<i class="fa fa-pencil"></i> Role: ' + data.name);
            modal.find('input[name=name]').val(data.name).attr('readonly', 'readonly');
            modal.find('input[name=display_name]').val(data.display_name);
            modal.find('textarea[name=desc]').val(data.desc);
            modal.modal('show');
        },
        error: function error(_error) {
            console.log(_error);
        }
    });
}
function editModule(module_id) {
    $.get('/modules/' + module_id, function (data) {
        var myData = JSON.parse(data);
        var modal = $('#modulesModal');
        modal.find('form').attr('action', '/update-module/' + module_id);
        modal.find('.modal-header').html('<i class="fa fa-pencil"></i> Module: ' + myData.name);
        modal.find('input[name=name]').val(myData.name);
        modal.modal('show');
    });
}

$('document').ready(function () {
    //
    // var pathArray = window.location.pathname.split('/');
    // if (pathArray[1] === "users"
    //     || pathArray[1] === "admin"
    //     || pathArray[1] === "roles") {
    //     $('#main').removeClass('col-md-9').addClass('col-md-12');
    //     $('#sidebar').slideUp();
    //
    //     $('.navbar-toggle').click(function () {
    //         $('#sidebar').toggle();  //show sidebar
    //     })
    // }
    $('.admin-nav-btn').click(function () {
        $('.admin-nav').addClass('dropdown').find('ul').addClass('dropdown-menu').toggleClass('hidden-xs');
    });
    $('.create-role-btn').click(function () {
        $('#roleModal').modal('show');
    });
    $('.register-module-btn').click(function () {
        $('#modulesModal').modal('show');
    });

    $('.role').dblclick(function () {
        var role_id = $(this).attr('id');
        editRole(role_id);
    });

    //selected role
    $('#roles').find('li').click(function () {

        //highlight
        $('#roles').find('li').each(function () {
            $(this).removeClass('active').find('.fa').css('opacity', '0.2');
        });
        $(this).addClass('active').find('.fa').css('opacity', '1');

        $('#permissions').text('');
        //load modules
        var role = $(this).attr('id');
        $('#modules').load('/modules', function () {
            //highlight
            $(this).find('li').click(function () {
                $('#modules').find('li').each(function () {
                    $(this).removeClass('active').find('.fa').hide();
                });
                $(this).addClass('active').find('.fa').show();
            });

            //load permissions
            $('#modules').find('li').click(function () {
                var module = $(this).attr('id');
                $('#permissions').load('/module-permissions/' + role + '/' + module, function () {
                    //inverse
                    $("#invert_selection").click(function () {
                        $(".permissions").find("INPUT[type=checkbox]").each(function () {
                            $(this).attr('checked', !$(this).attr('checked'));
                        });
                        return false;
                    });

                    //assign to role
                    var form = $('.permissions');
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'role',
                        value: role
                    }).appendTo(form);
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'module',
                        value: module
                    }).appendTo(form);
                    form.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: '/role-permissions',
                            data: $(this).serialize(), //$('form').serialize(),
                            type: 'POST',
                            success: function success(response) {
                                var res = JSON.parse(response);
                                notice(res.message, res.status);
                            },
                            error: function error(_error2) {
                                notice('Error updating permissions', 'error');
                            }
                        });
                    });
                });
            });

            $('.module').dblclick(function () {
                var module_id = $(this).attr('id');
                editModule(module_id);
            });

            var modules = new List('modules', {
                valueNames: ['name'],
                page: 20,
                pagination: true
            });
        });
    });

    var roles = new List('roles', {
        valueNames: ['role'],
        page: 20,
        pagination: true
    });
});

/***/ })

/******/ });