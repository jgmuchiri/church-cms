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
/******/ 	return __webpack_require__(__webpack_require__.s = 22);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/**
 * Copyright (c) 2007-2013 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.6
 */
;(function ($) {
  var h = $.scrollTo = function (a, b, c) {
    $(window).scrollTo(a, b, c);
  };h.defaults = { axis: 'xy', duration: parseFloat($.fn.jquery) >= 1.3 ? 0 : 1, limit: true };h.window = function (a) {
    return $(window)._scrollable();
  };$.fn._scrollable = function () {
    return this.map(function () {
      var a = this,
          isWin = !a.nodeName || $.inArray(a.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) != -1;if (!isWin) return a;var b = (a.contentWindow || a).document || a.ownerDocument || a;return (/webkit/i.test(navigator.userAgent) || b.compatMode == 'BackCompat' ? b.body : b.documentElement
      );
    });
  };$.fn.scrollTo = function (e, f, g) {
    if ((typeof f === 'undefined' ? 'undefined' : _typeof(f)) == 'object') {
      g = f;f = 0;
    }if (typeof g == 'function') g = { onAfter: g };if (e == 'max') e = 9e9;g = $.extend({}, h.defaults, g);f = f || g.duration;g.queue = g.queue && g.axis.length > 1;if (g.queue) f /= 2;g.offset = both(g.offset);g.over = both(g.over);return this._scrollable().each(function () {
      if (e == null) return;var d = this,
          $elem = $(d),
          targ = e,
          toff,
          attr = {},
          win = $elem.is('html,body');switch (typeof targ === 'undefined' ? 'undefined' : _typeof(targ)) {case 'number':case 'string':
          if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)) {
            targ = both(targ);break;
          }targ = $(targ, this);if (!targ.length) return;case 'object':
          if (targ.is || targ.style) toff = (targ = $(targ)).offset();}$.each(g.axis.split(''), function (i, a) {
        var b = a == 'x' ? 'Left' : 'Top',
            pos = b.toLowerCase(),
            key = 'scroll' + b,
            old = d[key],
            max = h.max(d, a);if (toff) {
          attr[key] = toff[pos] + (win ? 0 : old - $elem.offset()[pos]);if (g.margin) {
            attr[key] -= parseInt(targ.css('margin' + b)) || 0;attr[key] -= parseInt(targ.css('border' + b + 'Width')) || 0;
          }attr[key] += g.offset[pos] || 0;if (g.over[pos]) attr[key] += targ[a == 'x' ? 'width' : 'height']() * g.over[pos];
        } else {
          var c = targ[pos];attr[key] = c.slice && c.slice(-1) == '%' ? parseFloat(c) / 100 * max : c;
        }if (g.limit && /^\d+$/.test(attr[key])) attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max);if (!i && g.queue) {
          if (old != attr[key]) animate(g.onAfterFirst);delete attr[key];
        }
      });animate(g.onAfter);function animate(a) {
        $elem.animate(attr, f, g.easing, a && function () {
          a.call(this, targ, g);
        });
      }
    }).end();
  };h.max = function (a, b) {
    var c = b == 'x' ? 'Width' : 'Height',
        scroll = 'scroll' + c;if (!$(a).is('html,body')) return a[scroll] - $(a)[c.toLowerCase()]();var d = 'client' + c,
        html = a.ownerDocument.documentElement,
        body = a.ownerDocument.body;return Math.max(html[scroll], body[scroll]) - Math.min(html[d], body[d]);
  };function both(a) {
    return (typeof a === 'undefined' ? 'undefined' : _typeof(a)) == 'object' ? a : { top: a, left: a };
  }
})(jQuery);

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

var require;var require;var __WEBPACK_AMD_DEFINE_RESULT__;var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

!function (e, t, n) {
  "use strict";
  !function o(e, t, n) {
    function a(s, l) {
      if (!t[s]) {
        if (!e[s]) {
          var i = "function" == typeof require && require;if (!l && i) return require(s, !0);if (r) return r(s, !0);var u = new Error("Cannot find module '" + s + "'");throw u.code = "MODULE_NOT_FOUND", u;
        }var c = t[s] = { exports: {} };e[s][0].call(c.exports, function (t) {
          var n = e[s][1][t];return a(n ? n : t);
        }, c, c.exports, o, e, t, n);
      }return t[s].exports;
    }for (var r = "function" == typeof require && require, s = 0; s < n.length; s++) {
      a(n[s]);
    }return a;
  }({ 1: [function (o, a, r) {
      function s(e) {
        return e && e.__esModule ? e : { "default": e };
      }Object.defineProperty(r, "__esModule", { value: !0 });var l,
          i,
          u,
          _c,
          d = o("./modules/handle-dom"),
          f = o("./modules/utils"),
          p = o("./modules/handle-swal-dom"),
          m = o("./modules/handle-click"),
          v = o("./modules/handle-key"),
          y = s(v),
          b = o("./modules/default-params"),
          h = s(b),
          g = o("./modules/set-params"),
          w = s(g);r["default"] = u = _c = function c() {
        function o(e) {
          var t = a;return t[e] === n ? h["default"][e] : t[e];
        }var a = arguments[0];if ((0, d.addClass)(t.body, "stop-scrolling"), (0, p.resetInput)(), a === n) return (0, f.logStr)("SweetAlert expects at least 1 attribute!"), !1;var r = (0, f.extend)({}, h["default"]);switch (typeof a === "undefined" ? "undefined" : _typeof(a)) {case "string":
            r.title = a, r.text = arguments[1] || "", r.type = arguments[2] || "";break;case "object":
            if (a.title === n) return (0, f.logStr)('Missing "title" argument!'), !1;r.title = a.title;for (var s in h["default"]) {
              r[s] = o(s);
            }r.confirmButtonText = r.showCancelButton ? "Confirm" : h["default"].confirmButtonText, r.confirmButtonText = o("confirmButtonText"), r.doneFunction = arguments[1] || null;break;default:
            return (0, f.logStr)('Unexpected type of argument! Expected "string" or "object", got ' + (typeof a === "undefined" ? "undefined" : _typeof(a))), !1;}(0, w["default"])(r), (0, p.fixVerticalPosition)(), (0, p.openModal)(arguments[1]);for (var u = (0, p.getModal)(), v = u.querySelectorAll("button"), b = ["onclick", "onmouseover", "onmouseout", "onmousedown", "onmouseup", "onfocus"], g = function g(e) {
          return (0, m.handleButton)(e, r, u);
        }, C = 0; C < v.length; C++) {
          for (var S = 0; S < b.length; S++) {
            var x = b[S];v[C][x] = g;
          }
        }(0, p.getOverlay)().onclick = g, l = e.onkeydown;var k = function k(e) {
          return (0, y["default"])(e, r, u);
        };e.onkeydown = k, e.onfocus = function () {
          setTimeout(function () {
            i !== n && (i.focus(), i = n);
          }, 0);
        }, _c.enableButtons();
      }, u.setDefaults = _c.setDefaults = function (e) {
        if (!e) throw new Error("userParams is required");if ("object" != (typeof e === "undefined" ? "undefined" : _typeof(e))) throw new Error("userParams has to be a object");(0, f.extend)(h["default"], e);
      }, u.close = _c.close = function () {
        var o = (0, p.getModal)();(0, d.fadeOut)((0, p.getOverlay)(), 5), (0, d.fadeOut)(o, 5), (0, d.removeClass)(o, "showSweetAlert"), (0, d.addClass)(o, "hideSweetAlert"), (0, d.removeClass)(o, "visible");var a = o.querySelector(".sa-icon.sa-success");(0, d.removeClass)(a, "animate"), (0, d.removeClass)(a.querySelector(".sa-tip"), "animateSuccessTip"), (0, d.removeClass)(a.querySelector(".sa-long"), "animateSuccessLong");var r = o.querySelector(".sa-icon.sa-error");(0, d.removeClass)(r, "animateErrorIcon"), (0, d.removeClass)(r.querySelector(".sa-x-mark"), "animateXMark");var s = o.querySelector(".sa-icon.sa-warning");return (0, d.removeClass)(s, "pulseWarning"), (0, d.removeClass)(s.querySelector(".sa-body"), "pulseWarningIns"), (0, d.removeClass)(s.querySelector(".sa-dot"), "pulseWarningIns"), setTimeout(function () {
          var e = o.getAttribute("data-custom-class");(0, d.removeClass)(o, e);
        }, 300), (0, d.removeClass)(t.body, "stop-scrolling"), e.onkeydown = l, e.previousActiveElement && e.previousActiveElement.focus(), i = n, clearTimeout(o.timeout), !0;
      }, u.showInputError = _c.showInputError = function (e) {
        var t = (0, p.getModal)(),
            n = t.querySelector(".sa-input-error");(0, d.addClass)(n, "show");var o = t.querySelector(".sa-error-container");(0, d.addClass)(o, "show"), o.querySelector("p").innerHTML = e, setTimeout(function () {
          u.enableButtons();
        }, 1), t.querySelector("input").focus();
      }, u.resetInputError = _c.resetInputError = function (e) {
        if (e && 13 === e.keyCode) return !1;var t = (0, p.getModal)(),
            n = t.querySelector(".sa-input-error");(0, d.removeClass)(n, "show");var o = t.querySelector(".sa-error-container");(0, d.removeClass)(o, "show");
      }, u.disableButtons = _c.disableButtons = function (e) {
        var t = (0, p.getModal)(),
            n = t.querySelector("button.confirm"),
            o = t.querySelector("button.cancel");n.disabled = !0, o.disabled = !0;
      }, u.enableButtons = _c.enableButtons = function (e) {
        var t = (0, p.getModal)(),
            n = t.querySelector("button.confirm"),
            o = t.querySelector("button.cancel");n.disabled = !1, o.disabled = !1;
      }, "undefined" != typeof e ? e.sweetAlert = e.swal = u : (0, f.logStr)("SweetAlert is a frontend module!"), a.exports = r["default"];
    }, { "./modules/default-params": 2, "./modules/handle-click": 3, "./modules/handle-dom": 4, "./modules/handle-key": 5, "./modules/handle-swal-dom": 6, "./modules/set-params": 8, "./modules/utils": 9 }], 2: [function (e, t, n) {
      Object.defineProperty(n, "__esModule", { value: !0 });var o = { title: "", text: "", type: null, allowOutsideClick: !1, showConfirmButton: !0, showCancelButton: !1, closeOnConfirm: !0, closeOnCancel: !0, confirmButtonText: "OK", confirmButtonColor: "#8CD4F5", cancelButtonText: "Cancel", imageUrl: null, imageSize: null, timer: null, customClass: "", html: !1, animation: !0, allowEscapeKey: !0, inputType: "text", inputPlaceholder: "", inputValue: "", showLoaderOnConfirm: !1 };n["default"] = o, t.exports = n["default"];
    }, {}], 3: [function (t, n, o) {
      Object.defineProperty(o, "__esModule", { value: !0 });var a = t("./utils"),
          r = (t("./handle-swal-dom"), t("./handle-dom")),
          s = function s(t, n, o) {
        function s(e) {
          m && n.confirmButtonColor && (p.style.backgroundColor = e);
        }var u,
            c,
            d,
            f = t || e.event,
            p = f.target || f.srcElement,
            m = -1 !== p.className.indexOf("confirm"),
            v = -1 !== p.className.indexOf("sweet-overlay"),
            y = (0, r.hasClass)(o, "visible"),
            b = n.doneFunction && "true" === o.getAttribute("data-has-done-function");switch (m && n.confirmButtonColor && (u = n.confirmButtonColor, c = (0, a.colorLuminance)(u, -.04), d = (0, a.colorLuminance)(u, -.14)), f.type) {case "mouseover":
            s(c);break;case "mouseout":
            s(u);break;case "mousedown":
            s(d);break;case "mouseup":
            s(c);break;case "focus":
            var h = o.querySelector("button.confirm"),
                g = o.querySelector("button.cancel");m ? g.style.boxShadow = "none" : h.style.boxShadow = "none";break;case "click":
            var w = o === p,
                C = (0, r.isDescendant)(o, p);if (!w && !C && y && !n.allowOutsideClick) break;m && b && y ? l(o, n) : b && y || v ? i(o, n) : (0, r.isDescendant)(o, p) && "BUTTON" === p.tagName && sweetAlert.close();}
      },
          l = function l(e, t) {
        var n = !0;(0, r.hasClass)(e, "show-input") && (n = e.querySelector("input").value, n || (n = "")), t.doneFunction(n), t.closeOnConfirm && sweetAlert.close(), t.showLoaderOnConfirm && sweetAlert.disableButtons();
      },
          i = function i(e, t) {
        var n = String(t.doneFunction).replace(/\s/g, ""),
            o = "function(" === n.substring(0, 9) && ")" !== n.substring(9, 10);o && t.doneFunction(!1), t.closeOnCancel && sweetAlert.close();
      };o["default"] = { handleButton: s, handleConfirm: l, handleCancel: i }, n.exports = o["default"];
    }, { "./handle-dom": 4, "./handle-swal-dom": 6, "./utils": 9 }], 4: [function (n, o, a) {
      Object.defineProperty(a, "__esModule", { value: !0 });var r = function r(e, t) {
        return new RegExp(" " + t + " ").test(" " + e.className + " ");
      },
          s = function s(e, t) {
        r(e, t) || (e.className += " " + t);
      },
          l = function l(e, t) {
        var n = " " + e.className.replace(/[\t\r\n]/g, " ") + " ";if (r(e, t)) {
          for (; n.indexOf(" " + t + " ") >= 0;) {
            n = n.replace(" " + t + " ", " ");
          }e.className = n.replace(/^\s+|\s+$/g, "");
        }
      },
          i = function i(e) {
        var n = t.createElement("div");return n.appendChild(t.createTextNode(e)), n.innerHTML;
      },
          u = function u(e) {
        e.style.opacity = "", e.style.display = "block";
      },
          c = function c(e) {
        if (e && !e.length) return u(e);for (var t = 0; t < e.length; ++t) {
          u(e[t]);
        }
      },
          d = function d(e) {
        e.style.opacity = "", e.style.display = "none";
      },
          f = function f(e) {
        if (e && !e.length) return d(e);for (var t = 0; t < e.length; ++t) {
          d(e[t]);
        }
      },
          p = function p(e, t) {
        for (var n = t.parentNode; null !== n;) {
          if (n === e) return !0;n = n.parentNode;
        }return !1;
      },
          m = function m(e) {
        e.style.left = "-9999px", e.style.display = "block";var t,
            n = e.clientHeight;return t = "undefined" != typeof getComputedStyle ? parseInt(getComputedStyle(e).getPropertyValue("padding-top"), 10) : parseInt(e.currentStyle.padding), e.style.left = "", e.style.display = "none", "-" + parseInt((n + t) / 2) + "px";
      },
          v = function v(e, t) {
        if (+e.style.opacity < 1) {
          t = t || 16, e.style.opacity = 0, e.style.display = "block";var n = +new Date(),
              o = function a() {
            e.style.opacity = +e.style.opacity + (new Date() - n) / 100, n = +new Date(), +e.style.opacity < 1 && setTimeout(a, t);
          };o();
        }e.style.display = "block";
      },
          y = function y(e, t) {
        t = t || 16, e.style.opacity = 1;var n = +new Date(),
            o = function a() {
          e.style.opacity = +e.style.opacity - (new Date() - n) / 100, n = +new Date(), +e.style.opacity > 0 ? setTimeout(a, t) : e.style.display = "none";
        };o();
      },
          b = function b(n) {
        if ("function" == typeof MouseEvent) {
          var o = new MouseEvent("click", { view: e, bubbles: !1, cancelable: !0 });n.dispatchEvent(o);
        } else if (t.createEvent) {
          var a = t.createEvent("MouseEvents");a.initEvent("click", !1, !1), n.dispatchEvent(a);
        } else t.createEventObject ? n.fireEvent("onclick") : "function" == typeof n.onclick && n.onclick();
      },
          h = function h(t) {
        "function" == typeof t.stopPropagation ? (t.stopPropagation(), t.preventDefault()) : e.event && e.event.hasOwnProperty("cancelBubble") && (e.event.cancelBubble = !0);
      };a.hasClass = r, a.addClass = s, a.removeClass = l, a.escapeHtml = i, a._show = u, a.show = c, a._hide = d, a.hide = f, a.isDescendant = p, a.getTopMargin = m, a.fadeIn = v, a.fadeOut = y, a.fireClick = b, a.stopEventPropagation = h;
    }, {}], 5: [function (t, o, a) {
      Object.defineProperty(a, "__esModule", { value: !0 });var r = t("./handle-dom"),
          s = t("./handle-swal-dom"),
          l = function l(t, o, a) {
        var l = t || e.event,
            i = l.keyCode || l.which,
            u = a.querySelector("button.confirm"),
            c = a.querySelector("button.cancel"),
            d = a.querySelectorAll("button[tabindex]");if (-1 !== [9, 13, 32, 27].indexOf(i)) {
          for (var f = l.target || l.srcElement, p = -1, m = 0; m < d.length; m++) {
            if (f === d[m]) {
              p = m;break;
            }
          }9 === i ? (f = -1 === p ? u : p === d.length - 1 ? d[0] : d[p + 1], (0, r.stopEventPropagation)(l), f.focus(), o.confirmButtonColor && (0, s.setFocusStyle)(f, o.confirmButtonColor)) : 13 === i ? ("INPUT" === f.tagName && (f = u, u.focus()), f = -1 === p ? u : n) : 27 === i && o.allowEscapeKey === !0 ? (f = c, (0, r.fireClick)(f, l)) : f = n;
        }
      };a["default"] = l, o.exports = a["default"];
    }, { "./handle-dom": 4, "./handle-swal-dom": 6 }], 6: [function (n, o, a) {
      function r(e) {
        return e && e.__esModule ? e : { "default": e };
      }Object.defineProperty(a, "__esModule", { value: !0 });var s = n("./utils"),
          l = n("./handle-dom"),
          i = n("./default-params"),
          u = r(i),
          c = n("./injected-html"),
          d = r(c),
          f = ".sweet-alert",
          p = ".sweet-overlay",
          m = function m() {
        var e = t.createElement("div");for (e.innerHTML = d["default"]; e.firstChild;) {
          t.body.appendChild(e.firstChild);
        }
      },
          v = function x() {
        var e = t.querySelector(f);return e || (m(), e = x()), e;
      },
          y = function y() {
        var e = v();return e ? e.querySelector("input") : void 0;
      },
          b = function b() {
        return t.querySelector(p);
      },
          h = function h(e, t) {
        var n = (0, s.hexToRgb)(t);e.style.boxShadow = "0 0 2px rgba(" + n + ", 0.8), inset 0 0 0 1px rgba(0, 0, 0, 0.05)";
      },
          g = function g(n) {
        var o = v();(0, l.fadeIn)(b(), 10), (0, l.show)(o), (0, l.addClass)(o, "showSweetAlert"), (0, l.removeClass)(o, "hideSweetAlert"), e.previousActiveElement = t.activeElement;var a = o.querySelector("button.confirm");a.focus(), setTimeout(function () {
          (0, l.addClass)(o, "visible");
        }, 500);var r = o.getAttribute("data-timer");if ("null" !== r && "" !== r) {
          var s = n;o.timeout = setTimeout(function () {
            var e = (s || null) && "true" === o.getAttribute("data-has-done-function");e ? s(null) : sweetAlert.close();
          }, r);
        }
      },
          w = function w() {
        var e = v(),
            t = y();(0, l.removeClass)(e, "show-input"), t.value = u["default"].inputValue, t.setAttribute("type", u["default"].inputType), t.setAttribute("placeholder", u["default"].inputPlaceholder), C();
      },
          C = function C(e) {
        if (e && 13 === e.keyCode) return !1;var t = v(),
            n = t.querySelector(".sa-input-error");(0, l.removeClass)(n, "show");var o = t.querySelector(".sa-error-container");(0, l.removeClass)(o, "show");
      },
          S = function S() {
        var e = v();e.style.marginTop = (0, l.getTopMargin)(v());
      };a.sweetAlertInitialize = m, a.getModal = v, a.getOverlay = b, a.getInput = y, a.setFocusStyle = h, a.openModal = g, a.resetInput = w, a.resetInputError = C, a.fixVerticalPosition = S;
    }, { "./default-params": 2, "./handle-dom": 4, "./injected-html": 7, "./utils": 9 }], 7: [function (e, t, n) {
      Object.defineProperty(n, "__esModule", { value: !0 });var o = '<div class="sweet-overlay" tabIndex="-1"></div><div class="sweet-alert"><div class="sa-icon sa-error">\n      <span class="sa-x-mark">\n        <span class="sa-line sa-left"></span>\n        <span class="sa-line sa-right"></span>\n      </span>\n    </div><div class="sa-icon sa-warning">\n      <span class="sa-body"></span>\n      <span class="sa-dot"></span>\n    </div><div class="sa-icon sa-info"></div><div class="sa-icon sa-success">\n      <span class="sa-line sa-tip"></span>\n      <span class="sa-line sa-long"></span>\n\n      <div class="sa-placeholder"></div>\n      <div class="sa-fix"></div>\n    </div><div class="sa-icon sa-custom"></div><h2>Title</h2>\n    <p>Text</p>\n    <fieldset>\n      <input type="text" tabIndex="3" />\n      <div class="sa-input-error"></div>\n    </fieldset><div class="sa-error-container">\n      <div class="icon">!</div>\n      <p>Not valid!</p>\n    </div><div class="sa-button-container">\n      <button class="cancel" tabIndex="2">Cancel</button>\n      <div class="sa-confirm-button-container">\n        <button class="confirm" tabIndex="1">OK</button><div class="la-ball-fall">\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>\n    </div></div>';n["default"] = o, t.exports = n["default"];
    }, {}], 8: [function (e, t, o) {
      Object.defineProperty(o, "__esModule", { value: !0 });var a = e("./utils"),
          r = e("./handle-swal-dom"),
          s = e("./handle-dom"),
          l = ["error", "warning", "info", "success", "input", "prompt"],
          i = function i(e) {
        var t = (0, r.getModal)(),
            o = t.querySelector("h2"),
            i = t.querySelector("p"),
            u = t.querySelector("button.cancel"),
            c = t.querySelector("button.confirm");if (o.innerHTML = e.html ? e.title : (0, s.escapeHtml)(e.title).split("\n").join("<br>"), i.innerHTML = e.html ? e.text : (0, s.escapeHtml)(e.text || "").split("\n").join("<br>"), e.text && (0, s.show)(i), e.customClass) (0, s.addClass)(t, e.customClass), t.setAttribute("data-custom-class", e.customClass);else {
          var d = t.getAttribute("data-custom-class");(0, s.removeClass)(t, d), t.setAttribute("data-custom-class", "");
        }if ((0, s.hide)(t.querySelectorAll(".sa-icon")), e.type && !(0, a.isIE8)()) {
          var f = function () {
            for (var o = !1, a = 0; a < l.length; a++) {
              if (e.type === l[a]) {
                o = !0;break;
              }
            }if (!o) return logStr("Unknown alert type: " + e.type), { v: !1 };var i = ["success", "error", "warning", "info"],
                u = n;-1 !== i.indexOf(e.type) && (u = t.querySelector(".sa-icon.sa-" + e.type), (0, s.show)(u));var c = (0, r.getInput)();switch (e.type) {case "success":
                (0, s.addClass)(u, "animate"), (0, s.addClass)(u.querySelector(".sa-tip"), "animateSuccessTip"), (0, s.addClass)(u.querySelector(".sa-long"), "animateSuccessLong");break;case "error":
                (0, s.addClass)(u, "animateErrorIcon"), (0, s.addClass)(u.querySelector(".sa-x-mark"), "animateXMark");break;case "warning":
                (0, s.addClass)(u, "pulseWarning"), (0, s.addClass)(u.querySelector(".sa-body"), "pulseWarningIns"), (0, s.addClass)(u.querySelector(".sa-dot"), "pulseWarningIns");break;case "input":case "prompt":
                c.setAttribute("type", e.inputType), c.value = e.inputValue, c.setAttribute("placeholder", e.inputPlaceholder), (0, s.addClass)(t, "show-input"), setTimeout(function () {
                  c.focus(), c.addEventListener("keyup", swal.resetInputError);
                }, 400);}
          }();if ("object" == (typeof f === "undefined" ? "undefined" : _typeof(f))) return f.v;
        }if (e.imageUrl) {
          var p = t.querySelector(".sa-icon.sa-custom");p.style.backgroundImage = "url(" + e.imageUrl + ")", (0, s.show)(p);var m = 80,
              v = 80;if (e.imageSize) {
            var y = e.imageSize.toString().split("x"),
                b = y[0],
                h = y[1];b && h ? (m = b, v = h) : logStr("Parameter imageSize expects value with format WIDTHxHEIGHT, got " + e.imageSize);
          }p.setAttribute("style", p.getAttribute("style") + "width:" + m + "px; height:" + v + "px");
        }t.setAttribute("data-has-cancel-button", e.showCancelButton), e.showCancelButton ? u.style.display = "inline-block" : (0, s.hide)(u), t.setAttribute("data-has-confirm-button", e.showConfirmButton), e.showConfirmButton ? c.style.display = "inline-block" : (0, s.hide)(c), e.cancelButtonText && (u.innerHTML = (0, s.escapeHtml)(e.cancelButtonText)), e.confirmButtonText && (c.innerHTML = (0, s.escapeHtml)(e.confirmButtonText)), e.confirmButtonColor && (c.style.backgroundColor = e.confirmButtonColor, c.style.borderLeftColor = e.confirmLoadingButtonColor, c.style.borderRightColor = e.confirmLoadingButtonColor, (0, r.setFocusStyle)(c, e.confirmButtonColor)), t.setAttribute("data-allow-outside-click", e.allowOutsideClick);var g = !!e.doneFunction;t.setAttribute("data-has-done-function", g), e.animation ? "string" == typeof e.animation ? t.setAttribute("data-animation", e.animation) : t.setAttribute("data-animation", "pop") : t.setAttribute("data-animation", "none"), t.setAttribute("data-timer", e.timer);
      };o["default"] = i, t.exports = o["default"];
    }, { "./handle-dom": 4, "./handle-swal-dom": 6, "./utils": 9 }], 9: [function (t, n, o) {
      Object.defineProperty(o, "__esModule", { value: !0 });var a = function a(e, t) {
        for (var n in t) {
          t.hasOwnProperty(n) && (e[n] = t[n]);
        }return e;
      },
          r = function r(e) {
        var t = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return t ? parseInt(t[1], 16) + ", " + parseInt(t[2], 16) + ", " + parseInt(t[3], 16) : null;
      },
          s = function s() {
        return e.attachEvent && !e.addEventListener;
      },
          l = function l(t) {
        "undefined" != typeof e && e.console && e.console.log("SweetAlert: " + t);
      },
          i = function i(e, t) {
        e = String(e).replace(/[^0-9a-f]/gi, ""), e.length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]), t = t || 0;var n,
            o,
            a = "#";for (o = 0; 3 > o; o++) {
          n = parseInt(e.substr(2 * o, 2), 16), n = Math.round(Math.min(Math.max(0, n + n * t), 255)).toString(16), a += ("00" + n).substr(n.length);
        }return a;
      };o.extend = a, o.hexToRgb = r, o.isIE8 = s, o.logStr = l, o.colorLuminance = i;
    }, {}] }, {}, [1]),  true ? !(__WEBPACK_AMD_DEFINE_RESULT__ = function () {
    return sweetAlert;
  }.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : "undefined" != typeof module && module.exports && (module.exports = sweetAlert);
}(window, document);

/***/ }),
/* 2 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function() {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		var result = [];
		for(var i = 0; i < this.length; i++) {
			var item = this[i];
			if(item[2]) {
				result.push("@media " + item[2] + "{" + item[1] + "}");
			} else {
				result.push(item[1]);
			}
		}
		return result.join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};


/***/ }),
/* 3 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
var stylesInDom = {},
	memoize = function(fn) {
		var memo;
		return function () {
			if (typeof memo === "undefined") memo = fn.apply(this, arguments);
			return memo;
		};
	},
	isOldIE = memoize(function() {
		return /msie [6-9]\b/.test(self.navigator.userAgent.toLowerCase());
	}),
	getHeadElement = memoize(function () {
		return document.head || document.getElementsByTagName("head")[0];
	}),
	singletonElement = null,
	singletonCounter = 0,
	styleElementsInsertedAtTop = [];

module.exports = function(list, options) {
	if(typeof DEBUG !== "undefined" && DEBUG) {
		if(typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};
	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (typeof options.singleton === "undefined") options.singleton = isOldIE();

	// By default, add <style> tags to the bottom of <head>.
	if (typeof options.insertAt === "undefined") options.insertAt = "bottom";

	var styles = listToStyles(list);
	addStylesToDom(styles, options);

	return function update(newList) {
		var mayRemove = [];
		for(var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];
			domStyle.refs--;
			mayRemove.push(domStyle);
		}
		if(newList) {
			var newStyles = listToStyles(newList);
			addStylesToDom(newStyles, options);
		}
		for(var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];
			if(domStyle.refs === 0) {
				for(var j = 0; j < domStyle.parts.length; j++)
					domStyle.parts[j]();
				delete stylesInDom[domStyle.id];
			}
		}
	};
}

function addStylesToDom(styles, options) {
	for(var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];
		if(domStyle) {
			domStyle.refs++;
			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}
			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];
			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}
			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles(list) {
	var styles = [];
	var newStyles = {};
	for(var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};
		if(!newStyles[id])
			styles.push(newStyles[id] = {id: id, parts: [part]});
		else
			newStyles[id].parts.push(part);
	}
	return styles;
}

function insertStyleElement(options, styleElement) {
	var head = getHeadElement();
	var lastStyleElementInsertedAtTop = styleElementsInsertedAtTop[styleElementsInsertedAtTop.length - 1];
	if (options.insertAt === "top") {
		if(!lastStyleElementInsertedAtTop) {
			head.insertBefore(styleElement, head.firstChild);
		} else if(lastStyleElementInsertedAtTop.nextSibling) {
			head.insertBefore(styleElement, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			head.appendChild(styleElement);
		}
		styleElementsInsertedAtTop.push(styleElement);
	} else if (options.insertAt === "bottom") {
		head.appendChild(styleElement);
	} else {
		throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
	}
}

function removeStyleElement(styleElement) {
	styleElement.parentNode.removeChild(styleElement);
	var idx = styleElementsInsertedAtTop.indexOf(styleElement);
	if(idx >= 0) {
		styleElementsInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement(options) {
	var styleElement = document.createElement("style");
	styleElement.type = "text/css";
	insertStyleElement(options, styleElement);
	return styleElement;
}

function createLinkElement(options) {
	var linkElement = document.createElement("link");
	linkElement.rel = "stylesheet";
	insertStyleElement(options, linkElement);
	return linkElement;
}

function addStyle(obj, options) {
	var styleElement, update, remove;

	if (options.singleton) {
		var styleIndex = singletonCounter++;
		styleElement = singletonElement || (singletonElement = createStyleElement(options));
		update = applyToSingletonTag.bind(null, styleElement, styleIndex, false);
		remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true);
	} else if(obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function") {
		styleElement = createLinkElement(options);
		update = updateLink.bind(null, styleElement);
		remove = function() {
			removeStyleElement(styleElement);
			if(styleElement.href)
				URL.revokeObjectURL(styleElement.href);
		};
	} else {
		styleElement = createStyleElement(options);
		update = applyToTag.bind(null, styleElement);
		remove = function() {
			removeStyleElement(styleElement);
		};
	}

	update(obj);

	return function updateStyle(newObj) {
		if(newObj) {
			if(newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap)
				return;
			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;
		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag(styleElement, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (styleElement.styleSheet) {
		styleElement.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = styleElement.childNodes;
		if (childNodes[index]) styleElement.removeChild(childNodes[index]);
		if (childNodes.length) {
			styleElement.insertBefore(cssNode, childNodes[index]);
		} else {
			styleElement.appendChild(cssNode);
		}
	}
}

function applyToTag(styleElement, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		styleElement.setAttribute("media", media)
	}

	if(styleElement.styleSheet) {
		styleElement.styleSheet.cssText = css;
	} else {
		while(styleElement.firstChild) {
			styleElement.removeChild(styleElement.firstChild);
		}
		styleElement.appendChild(document.createTextNode(css));
	}
}

function updateLink(linkElement, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	if(sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = linkElement.href;

	linkElement.href = URL.createObjectURL(blob);

	if(oldSrc)
		URL.revokeObjectURL(oldSrc);
}


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Created by jgmuchiri on 7/21/2017.
 */
__webpack_require__(13);
__webpack_require__(15);
__webpack_require__(1);
__webpack_require__(12);
__webpack_require__(14);
__webpack_require__(0);
__webpack_require__(16);
__webpack_require__(18);
__webpack_require__(17);

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(21);
if(typeof content === 'string') content = [[module.i, content, '']];
// add the styles to the DOM
var update = __webpack_require__(3)(content, {});
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--10-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--10-2!../../../node_modules/postcss-loader/index.js??ref--10-3!../../../node_modules/less-loader/index.js??ref--10-4!./kiosk.css", function() {
			var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--10-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--10-2!../../../node_modules/postcss-loader/index.js??ref--10-3!../../../node_modules/less-loader/index.js??ref--10-4!./kiosk.css");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(19);
if(typeof content === 'string') content = [[module.i, content, '']];
// add the styles to the DOM
var update = __webpack_require__(3)(content, {});
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--8-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--8-2!../../../node_modules/postcss-loader/index.js??ref--8-3!../../../node_modules/less-loader/index.js??ref--8-4!./public.css", function() {
			var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--8-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--8-2!../../../node_modules/postcss-loader/index.js??ref--8-3!../../../node_modules/less-loader/index.js??ref--8-4!./public.css");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(20);
if(typeof content === 'string') content = [[module.i, content, '']];
// add the styles to the DOM
var update = __webpack_require__(3)(content, {});
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--9-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--9-2!../../../node_modules/postcss-loader/index.js??ref--9-3!../../../node_modules/less-loader/index.js??ref--9-4!./admin.css", function() {
			var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/extract-text-webpack-plugin/loader.js??ref--9-0!../../../node_modules/style-loader/index.js!../../../node_modules/css-loader/index.js??ref--9-2!../../../node_modules/postcss-loader/index.js??ref--9-3!../../../node_modules/less-loader/index.js??ref--9-4!./admin.css");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 12 */
/***/ (function(module, exports) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/* =========================================================
 * bootstrap-datepicker.js 
 * http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

!function ($) {

	// Picker object

	var Datepicker = function Datepicker(element, options) {
		this.element = $(element);
		this.format = DPGlobal.parseFormat(options.format || this.element.data('date-format') || 'mm/dd/yyyy');
		this.picker = $(DPGlobal.template).appendTo('body').on({
			click: $.proxy(this.click, this),
			mousedown: $.proxy(this.mousedown, this)
		});
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.add-on') : false;

		if (this.isInput) {
			this.element.on({
				focus: $.proxy(this.show, this),
				blur: $.proxy(this.hide, this),
				keyup: $.proxy(this.update, this)
			});
		} else {
			if (this.component) {
				this.component.on('click', $.proxy(this.show, this));
			} else {
				this.element.on('click', $.proxy(this.show, this));
			}
		}
		this.minViewMode = options.minViewMode || this.element.data('date-minviewmode') || 0;
		if (typeof this.minViewMode === 'string') {
			switch (this.minViewMode) {
				case 'months':
					this.minViewMode = 1;
					break;
				case 'years':
					this.minViewMode = 2;
					break;
				default:
					this.minViewMode = 0;
					break;
			}
		}
		this.viewMode = options.viewMode || this.element.data('date-viewmode') || 0;
		if (typeof this.viewMode === 'string') {
			switch (this.viewMode) {
				case 'months':
					this.viewMode = 1;
					break;
				case 'years':
					this.viewMode = 2;
					break;
				default:
					this.viewMode = 0;
					break;
			}
		}
		this.startViewMode = this.viewMode;
		this.weekStart = options.weekStart || this.element.data('date-weekstart') || 0;
		this.weekEnd = this.weekStart === 0 ? 6 : this.weekStart - 1;
		this.fillDow();
		this.fillMonths();
		this.update();
		this.showMode();
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		show: function show(e) {
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.place();
			$(window).on('resize', $.proxy(this.place, this));
			if (e) {
				e.stopPropagation();
				e.preventDefault();
			}
			if (!this.isInput) {
				$(document).on('mousedown', $.proxy(this.hide, this));
			}
			this.element.trigger({
				type: 'show',
				date: this.date
			});
		},

		hide: function hide() {
			this.picker.hide();
			$(window).off('resize', this.place);
			this.viewMode = this.startViewMode;
			this.showMode();
			if (!this.isInput) {
				$(document).off('mousedown', this.hide);
			}
			this.set();
			this.element.trigger({
				type: 'hide',
				date: this.date
			});
		},

		set: function set() {
			var formated = DPGlobal.formatDate(this.date, this.format);
			if (!this.isInput) {
				if (this.component) {
					this.element.find('input').prop('value', formated);
				}
				this.element.data('date', formated);
			} else {
				this.element.prop('value', formated);
			}
		},

		setValue: function setValue(newDate) {
			if (typeof newDate === 'string') {
				this.date = DPGlobal.parseDate(newDate, this.format);
			} else {
				this.date = new Date(newDate);
			}
			this.set();
			this.viewDate = new Date(this.date.getFullYear(), this.date.getMonth(), 1, 0, 0, 0, 0);
			this.fill();
		},

		place: function place() {
			var offset = this.component ? this.component.offset() : this.element.offset();
			this.picker.css({
				top: offset.top + this.height,
				left: offset.left
			});
		},

		update: function update(newDate) {
			this.date = DPGlobal.parseDate(typeof newDate === 'string' ? newDate : this.isInput ? this.element.prop('value') : this.element.data('date'), this.format);
			this.viewDate = new Date(this.date.getFullYear(), this.date.getMonth(), 1, 0, 0, 0, 0);
			this.fill();
		},

		fillDow: function fillDow() {
			var dowCnt = this.weekStart;
			var html = '<tr>';
			while (dowCnt < this.weekStart + 7) {
				html += '<th class="dow">' + DPGlobal.dates.daysMin[dowCnt++ % 7] + '</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function fillMonths() {
			var html = '';
			var i = 0;
			while (i < 12) {
				html += '<span class="month">' + DPGlobal.dates.monthsShort[i++] + '</span>';
			}
			this.picker.find('.datepicker-months td').append(html);
		},

		fill: function fill() {
			var d = new Date(this.viewDate),
			    year = d.getFullYear(),
			    month = d.getMonth(),
			    currentDate = this.date.valueOf();
			this.picker.find('.datepicker-days th:eq(1)').text(DPGlobal.dates.months[month] + ' ' + year);
			var prevMonth = new Date(year, month - 1, 28, 0, 0, 0, 0),
			    day = DPGlobal.getDaysInMonth(prevMonth.getFullYear(), prevMonth.getMonth());
			prevMonth.setDate(day);
			prevMonth.setDate(day - (prevMonth.getDay() - this.weekStart + 7) % 7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setDate(nextMonth.getDate() + 42);
			nextMonth = nextMonth.valueOf();
			html = [];
			var clsName;
			while (prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getDay() === this.weekStart) {
					html.push('<tr>');
				}
				clsName = '';
				if (prevMonth.getMonth() < month) {
					clsName += ' old';
				} else if (prevMonth.getMonth() > month) {
					clsName += ' new';
				}
				if (prevMonth.valueOf() === currentDate) {
					clsName += ' active';
				}
				html.push('<td class="day' + clsName + '">' + prevMonth.getDate() + '</td>');
				if (prevMonth.getDay() === this.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setDate(prevMonth.getDate() + 1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));
			var currentYear = this.date.getFullYear();

			var months = this.picker.find('.datepicker-months').find('th:eq(1)').text(year).end().find('span').removeClass('active');
			if (currentYear === year) {
				months.eq(this.date.getMonth()).addClass('active');
			}

			html = '';
			year = parseInt(year / 10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years').find('th:eq(1)').text(year + '-' + (year + 9)).end().find('td');
			year -= 1;
			for (var i = -1; i < 11; i++) {
				html += '<span class="year' + (i === -1 || i === 10 ? ' old' : '') + (currentYear === year ? ' active' : '') + '">' + year + '</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		click: function click(e) {
			e.stopPropagation();
			e.preventDefault();
			var target = $(e.target).closest('span, td, th');
			if (target.length === 1) {
				switch (target[0].nodeName.toLowerCase()) {
					case 'th':
						switch (target[0].className) {
							case 'switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								this.viewDate['set' + DPGlobal.modes[this.viewMode].navFnc].call(this.viewDate, this.viewDate['get' + DPGlobal.modes[this.viewMode].navFnc].call(this.viewDate) + DPGlobal.modes[this.viewMode].navStep * (target[0].className === 'prev' ? -1 : 1));
								this.fill();
								this.set();
								break;
						}
						break;
					case 'span':
						if (target.is('.month')) {
							var month = target.parent().find('span').index(target);
							this.viewDate.setMonth(month);
						} else {
							var year = parseInt(target.text(), 10) || 0;
							this.viewDate.setFullYear(year);
						}
						if (this.viewMode !== 0) {
							this.date = new Date(this.viewDate);
							this.element.trigger({
								type: 'changeDate',
								date: this.date,
								viewMode: DPGlobal.modes[this.viewMode].clsName
							});
						}
						this.showMode(-1);
						this.fill();
						this.set();
						break;
					case 'td':
						if (target.is('.day')) {
							var day = parseInt(target.text(), 10) || 1;
							var month = this.viewDate.getMonth();
							if (target.is('.old')) {
								month -= 1;
							} else if (target.is('.new')) {
								month += 1;
							}
							var year = this.viewDate.getFullYear();
							this.date = new Date(year, month, day, 0, 0, 0, 0);
							this.viewDate = new Date(year, month, Math.min(28, day), 0, 0, 0, 0);
							this.fill();
							this.set();
							this.element.trigger({
								type: 'changeDate',
								date: this.date,
								viewMode: DPGlobal.modes[this.viewMode].clsName
							});
						}
						break;
				}
			}
		},

		mousedown: function mousedown(e) {
			e.stopPropagation();
			e.preventDefault();
		},

		showMode: function showMode(dir) {
			if (dir) {
				this.viewMode = Math.max(this.minViewMode, Math.min(2, this.viewMode + dir));
			}
			this.picker.find('>div').hide().filter('.datepicker-' + DPGlobal.modes[this.viewMode].clsName).show();
		}
	};

	$.fn.datepicker = function (option, val) {
		return this.each(function () {
			var $this = $(this),
			    data = $this.data('datepicker'),
			    options = (typeof option === 'undefined' ? 'undefined' : _typeof(option)) === 'object' && option;
			if (!data) {
				$this.data('datepicker', data = new Datepicker(this, $.extend({}, $.fn.datepicker.defaults, options)));
			}
			if (typeof option === 'string') data[option](val);
		});
	};

	$.fn.datepicker.defaults = {};
	$.fn.datepicker.Constructor = Datepicker;

	var DPGlobal = {
		modes: [{
			clsName: 'days',
			navFnc: 'Month',
			navStep: 1
		}, {
			clsName: 'months',
			navFnc: 'FullYear',
			navStep: 1
		}, {
			clsName: 'years',
			navFnc: 'FullYear',
			navStep: 10
		}],
		dates: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		isLeapYear: function isLeapYear(year) {
			return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
		},
		getDaysInMonth: function getDaysInMonth(year, month) {
			return [31, DPGlobal.isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		parseFormat: function parseFormat(format) {
			var separator = format.match(/[.\/\-\s].*?/),
			    parts = format.split(/\W+/);
			if (!separator || !parts || parts.length === 0) {
				throw new Error("Invalid date format.");
			}
			return { separator: separator, parts: parts };
		},
		parseDate: function parseDate(date, format) {
			var parts = date.split(format.separator),
			    date = new Date(),
			    val;
			date.setHours(0);
			date.setMinutes(0);
			date.setSeconds(0);
			date.setMilliseconds(0);
			if (parts.length === format.parts.length) {
				for (var i = 0, cnt = format.parts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10) || 1;
					switch (format.parts[i]) {
						case 'dd':
						case 'd':
							date.setDate(val);
							break;
						case 'mm':
						case 'm':
							date.setMonth(val - 1);
							break;
						case 'yy':
							date.setFullYear(2000 + val);
							break;
						case 'yyyy':
							date.setFullYear(val);
							break;
					}
				}
			}
			return date;
		},
		formatDate: function formatDate(date, format) {
			var val = {
				d: date.getDate(),
				m: date.getMonth() + 1,
				yy: date.getFullYear().toString().substring(2),
				yyyy: date.getFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			var date = [];
			for (var i = 0, cnt = format.parts.length; i < cnt; i++) {
				date.push(val[format.parts[i]]);
			}
			return date.join(format.separator);
		},
		headTemplate: '<thead>' + '<tr>' + '<th class="prev">&lsaquo;</th>' + '<th colspan="5" class="switch"></th>' + '<th class="next">&rsaquo;</th>' + '</tr>' + '</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>'
	};
	DPGlobal.template = '<div class="datepicker dropdown-menu">' + '<div class="datepicker-days">' + '<table class=" table-condensed">' + DPGlobal.headTemplate + '<tbody></tbody>' + '</table>' + '</div>' + '<div class="datepicker-months">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + '</table>' + '</div>' + '<div class="datepicker-years">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + '</table>' + '</div>' + '</div>';
}(window.jQuery);

/***/ }),
/* 13 */
/***/ (function(module, exports) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
* Bootstrap.js by @fat & @mdo
* Copyright 2012 Twitter, Inc.
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/
!function (e) {
  "use strict";
  e(function () {
    e.support.transition = function () {
      var e = function () {
        var e = document.createElement("bootstrap"),
            t = { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd otransitionend", transition: "transitionend" },
            n;for (n in t) {
          if (e.style[n] !== undefined) return t[n];
        }
      }();return e && { end: e };
    }();
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = '[data-dismiss="alert"]',
      n = function n(_n) {
    e(_n).on("click", t, this.close);
  };n.prototype.close = function (t) {
    function s() {
      i.trigger("closed").remove();
    }var n = e(this),
        r = n.attr("data-target"),
        i;r || (r = n.attr("href"), r = r && r.replace(/.*(?=#[^\s]*$)/, "")), i = e(r), t && t.preventDefault(), i.length || (i = n.hasClass("alert") ? n : n.parent()), i.trigger(t = e.Event("close"));if (t.isDefaultPrevented()) return;i.removeClass("in"), e.support.transition && i.hasClass("fade") ? i.on(e.support.transition.end, s) : s();
  }, e.fn.alert = function (t) {
    return this.each(function () {
      var r = e(this),
          i = r.data("alert");i || r.data("alert", i = new n(this)), typeof t == "string" && i[t].call(r);
    });
  }, e.fn.alert.Constructor = n, e(document).on("click.alert.data-api", t, n.prototype.close);
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t, n) {
    this.$element = e(_t), this.options = e.extend({}, e.fn.button.defaults, n);
  };t.prototype.setState = function (e) {
    var t = "disabled",
        n = this.$element,
        r = n.data(),
        i = n.is("input") ? "val" : "html";e += "Text", r.resetText || n.data("resetText", n[i]()), n[i](r[e] || this.options[e]), setTimeout(function () {
      e == "loadingText" ? n.addClass(t).attr(t, t) : n.removeClass(t).removeAttr(t);
    }, 0);
  }, t.prototype.toggle = function () {
    var e = this.$element.closest('[data-toggle="buttons-radio"]');e && e.find(".active").removeClass("active"), this.$element.toggleClass("active");
  }, e.fn.button = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("button"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("button", i = new t(this, s)), n == "toggle" ? i.toggle() : n && i.setState(n);
    });
  }, e.fn.button.defaults = { loadingText: "loading..." }, e.fn.button.Constructor = t, e(document).on("click.button.data-api", "[data-toggle^=button]", function (t) {
    var n = e(t.target);n.hasClass("btn") || (n = n.closest(".btn")), n.button("toggle");
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t2, n) {
    this.$element = e(_t2), this.options = n, this.options.slide && this.slide(this.options.slide), this.options.pause == "hover" && this.$element.on("mouseenter", e.proxy(this.pause, this)).on("mouseleave", e.proxy(this.cycle, this));
  };t.prototype = { cycle: function cycle(t) {
      return t || (this.paused = !1), this.options.interval && !this.paused && (this.interval = setInterval(e.proxy(this.next, this), this.options.interval)), this;
    }, to: function to(t) {
      var n = this.$element.find(".item.active"),
          r = n.parent().children(),
          i = r.index(n),
          s = this;if (t > r.length - 1 || t < 0) return;return this.sliding ? this.$element.one("slid", function () {
        s.to(t);
      }) : i == t ? this.pause().cycle() : this.slide(t > i ? "next" : "prev", e(r[t]));
    }, pause: function pause(t) {
      return t || (this.paused = !0), this.$element.find(".next, .prev").length && e.support.transition.end && (this.$element.trigger(e.support.transition.end), this.cycle()), clearInterval(this.interval), this.interval = null, this;
    }, next: function next() {
      if (this.sliding) return;return this.slide("next");
    }, prev: function prev() {
      if (this.sliding) return;return this.slide("prev");
    }, slide: function slide(t, n) {
      var r = this.$element.find(".item.active"),
          i = n || r[t](),
          s = this.interval,
          o = t == "next" ? "left" : "right",
          u = t == "next" ? "first" : "last",
          a = this,
          f;this.sliding = !0, s && this.pause(), i = i.length ? i : this.$element.find(".item")[u](), f = e.Event("slide", { relatedTarget: i[0] });if (i.hasClass("active")) return;if (e.support.transition && this.$element.hasClass("slide")) {
        this.$element.trigger(f);if (f.isDefaultPrevented()) return;i.addClass(t), i[0].offsetWidth, r.addClass(o), i.addClass(o), this.$element.one(e.support.transition.end, function () {
          i.removeClass([t, o].join(" ")).addClass("active"), r.removeClass(["active", o].join(" ")), a.sliding = !1, setTimeout(function () {
            a.$element.trigger("slid");
          }, 0);
        });
      } else {
        this.$element.trigger(f);if (f.isDefaultPrevented()) return;r.removeClass("active"), i.addClass("active"), this.sliding = !1, this.$element.trigger("slid");
      }return s && this.cycle(), this;
    } }, e.fn.carousel = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("carousel"),
          s = e.extend({}, e.fn.carousel.defaults, (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n),
          o = typeof n == "string" ? n : s.slide;i || r.data("carousel", i = new t(this, s)), typeof n == "number" ? i.to(n) : o ? i[o]() : s.interval && i.cycle();
    });
  }, e.fn.carousel.defaults = { interval: 5e3, pause: "hover" }, e.fn.carousel.Constructor = t, e(document).on("click.carousel.data-api", "[data-slide]", function (t) {
    var n = e(this),
        r,
        i = e(n.attr("data-target") || (r = n.attr("href")) && r.replace(/.*(?=#[^\s]+$)/, "")),
        s = e.extend({}, i.data(), n.data());i.carousel(s), t.preventDefault();
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t3, n) {
    this.$element = e(_t3), this.options = e.extend({}, e.fn.collapse.defaults, n), this.options.parent && (this.$parent = e(this.options.parent)), this.options.toggle && this.toggle();
  };t.prototype = { constructor: t, dimension: function dimension() {
      var e = this.$element.hasClass("width");return e ? "width" : "height";
    }, show: function show() {
      var t, n, r, i;if (this.transitioning) return;t = this.dimension(), n = e.camelCase(["scroll", t].join("-")), r = this.$parent && this.$parent.find("> .accordion-group > .in");if (r && r.length) {
        i = r.data("collapse");if (i && i.transitioning) return;r.collapse("hide"), i || r.data("collapse", null);
      }this.$element[t](0), this.transition("addClass", e.Event("show"), "shown"), e.support.transition && this.$element[t](this.$element[0][n]);
    }, hide: function hide() {
      var t;if (this.transitioning) return;t = this.dimension(), this.reset(this.$element[t]()), this.transition("removeClass", e.Event("hide"), "hidden"), this.$element[t](0);
    }, reset: function reset(e) {
      var t = this.dimension();return this.$element.removeClass("collapse")[t](e || "auto")[0].offsetWidth, this.$element[e !== null ? "addClass" : "removeClass"]("collapse"), this;
    }, transition: function transition(t, n, r) {
      var i = this,
          s = function s() {
        n.type == "show" && i.reset(), i.transitioning = 0, i.$element.trigger(r);
      };this.$element.trigger(n);if (n.isDefaultPrevented()) return;this.transitioning = 1, this.$element[t]("in"), e.support.transition && this.$element.hasClass("collapse") ? this.$element.one(e.support.transition.end, s) : s();
    }, toggle: function toggle() {
      this[this.$element.hasClass("in") ? "hide" : "show"]();
    } }, e.fn.collapse = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("collapse"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("collapse", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.collapse.defaults = { toggle: !0 }, e.fn.collapse.Constructor = t, e(document).on("click.collapse.data-api", "[data-toggle=collapse]", function (t) {
    var n = e(this),
        r,
        i = n.attr("data-target") || t.preventDefault() || (r = n.attr("href")) && r.replace(/.*(?=#[^\s]+$)/, ""),
        s = e(i).data("collapse") ? "toggle" : n.data();n[e(i).hasClass("in") ? "addClass" : "removeClass"]("collapsed"), e(i).collapse(s);
  });
}(window.jQuery), !function (e) {
  "use strict";
  function r() {
    e(t).each(function () {
      i(e(this)).removeClass("open");
    });
  }function i(t) {
    var n = t.attr("data-target"),
        r;return n || (n = t.attr("href"), n = n && /#/.test(n) && n.replace(/.*(?=#[^\s]*$)/, "")), r = e(n), r.length || (r = t.parent()), r;
  }var t = "[data-toggle=dropdown]",
      n = function n(t) {
    var n = e(t).on("click.dropdown.data-api", this.toggle);e("html").on("click.dropdown.data-api", function () {
      n.parent().removeClass("open");
    });
  };n.prototype = { constructor: n, toggle: function toggle(t) {
      var n = e(this),
          s,
          o;if (n.is(".disabled, :disabled")) return;return s = i(n), o = s.hasClass("open"), r(), o || (s.toggleClass("open"), n.focus()), !1;
    }, keydown: function keydown(t) {
      var n, r, s, o, u, a;if (!/(38|40|27)/.test(t.keyCode)) return;n = e(this), t.preventDefault(), t.stopPropagation();if (n.is(".disabled, :disabled")) return;o = i(n), u = o.hasClass("open");if (!u || u && t.keyCode == 27) return n.click();r = e("[role=menu] li:not(.divider) a", o);if (!r.length) return;a = r.index(r.filter(":focus")), t.keyCode == 38 && a > 0 && a--, t.keyCode == 40 && a < r.length - 1 && a++, ~a || (a = 0), r.eq(a).focus();
    } }, e.fn.dropdown = function (t) {
    return this.each(function () {
      var r = e(this),
          i = r.data("dropdown");i || r.data("dropdown", i = new n(this)), typeof t == "string" && i[t].call(r);
    });
  }, e.fn.dropdown.Constructor = n, e(document).on("click.dropdown.data-api touchstart.dropdown.data-api", r).on("click.dropdown touchstart.dropdown.data-api", ".dropdown form", function (e) {
    e.stopPropagation();
  }).on("click.dropdown.data-api touchstart.dropdown.data-api", t, n.prototype.toggle).on("keydown.dropdown.data-api touchstart.dropdown.data-api", t + ", [role=menu]", n.prototype.keydown);
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t4, n) {
    this.options = n, this.$element = e(_t4).delegate('[data-dismiss="modal"]', "click.dismiss.modal", e.proxy(this.hide, this)), this.options.remote && this.$element.find(".modal-body").load(this.options.remote);
  };t.prototype = { constructor: t, toggle: function toggle() {
      return this[this.isShown ? "hide" : "show"]();
    }, show: function show() {
      var t = this,
          n = e.Event("show");this.$element.trigger(n);if (this.isShown || n.isDefaultPrevented()) return;this.isShown = !0, this.escape(), this.backdrop(function () {
        var n = e.support.transition && t.$element.hasClass("fade");t.$element.parent().length || t.$element.appendTo(document.body), t.$element.show(), n && t.$element[0].offsetWidth, t.$element.addClass("in").attr("aria-hidden", !1), t.enforceFocus(), n ? t.$element.one(e.support.transition.end, function () {
          t.$element.focus().trigger("shown");
        }) : t.$element.focus().trigger("shown");
      });
    }, hide: function hide(t) {
      t && t.preventDefault();var n = this;t = e.Event("hide"), this.$element.trigger(t);if (!this.isShown || t.isDefaultPrevented()) return;this.isShown = !1, this.escape(), e(document).off("focusin.modal"), this.$element.removeClass("in").attr("aria-hidden", !0), e.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal();
    }, enforceFocus: function enforceFocus() {
      var t = this;e(document).on("focusin.modal", function (e) {
        t.$element[0] !== e.target && !t.$element.has(e.target).length && t.$element.focus();
      });
    }, escape: function escape() {
      var e = this;this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.modal", function (t) {
        t.which == 27 && e.hide();
      }) : this.isShown || this.$element.off("keyup.dismiss.modal");
    }, hideWithTransition: function hideWithTransition() {
      var t = this,
          n = setTimeout(function () {
        t.$element.off(e.support.transition.end), t.hideModal();
      }, 500);this.$element.one(e.support.transition.end, function () {
        clearTimeout(n), t.hideModal();
      });
    }, hideModal: function hideModal(e) {
      this.$element.hide().trigger("hidden"), this.backdrop();
    }, removeBackdrop: function removeBackdrop() {
      this.$backdrop.remove(), this.$backdrop = null;
    }, backdrop: function backdrop(t) {
      var n = this,
          r = this.$element.hasClass("fade") ? "fade" : "";if (this.isShown && this.options.backdrop) {
        var i = e.support.transition && r;this.$backdrop = e('<div class="modal-backdrop ' + r + '" />').appendTo(document.body), this.$backdrop.click(this.options.backdrop == "static" ? e.proxy(this.$element[0].focus, this.$element[0]) : e.proxy(this.hide, this)), i && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), i ? this.$backdrop.one(e.support.transition.end, t) : t();
      } else !this.isShown && this.$backdrop ? (this.$backdrop.removeClass("in"), e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(e.support.transition.end, e.proxy(this.removeBackdrop, this)) : this.removeBackdrop()) : t && t();
    } }, e.fn.modal = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("modal"),
          s = e.extend({}, e.fn.modal.defaults, r.data(), (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n);i || r.data("modal", i = new t(this, s)), typeof n == "string" ? i[n]() : s.show && i.show();
    });
  }, e.fn.modal.defaults = { backdrop: !0, keyboard: !0, show: !0 }, e.fn.modal.Constructor = t, e(document).on("click.modal.data-api", '[data-toggle="modal"]', function (t) {
    var n = e(this),
        r = n.attr("href"),
        i = e(n.attr("data-target") || r && r.replace(/.*(?=#[^\s]+$)/, "")),
        s = i.data("modal") ? "toggle" : e.extend({ remote: !/#/.test(r) && r }, i.data(), n.data());t.preventDefault(), i.modal(s).one("hide", function () {
      n.focus();
    });
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(e, _t5) {
    this.init("tooltip", e, _t5);
  };t.prototype = { constructor: t, init: function init(t, n, r) {
      var i, s;this.type = t, this.$element = e(n), this.options = this.getOptions(r), this.enabled = !0, this.options.trigger == "click" ? this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this)) : this.options.trigger != "manual" && (i = this.options.trigger == "hover" ? "mouseenter" : "focus", s = this.options.trigger == "hover" ? "mouseleave" : "blur", this.$element.on(i + "." + this.type, this.options.selector, e.proxy(this.enter, this)), this.$element.on(s + "." + this.type, this.options.selector, e.proxy(this.leave, this))), this.options.selector ? this._options = e.extend({}, this.options, { trigger: "manual", selector: "" }) : this.fixTitle();
    }, getOptions: function getOptions(t) {
      return t = e.extend({}, e.fn[this.type].defaults, t, this.$element.data()), t.delay && typeof t.delay == "number" && (t.delay = { show: t.delay, hide: t.delay }), t;
    }, enter: function enter(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);if (!n.options.delay || !n.options.delay.show) return n.show();clearTimeout(this.timeout), n.hoverState = "in", this.timeout = setTimeout(function () {
        n.hoverState == "in" && n.show();
      }, n.options.delay.show);
    }, leave: function leave(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);this.timeout && clearTimeout(this.timeout);if (!n.options.delay || !n.options.delay.hide) return n.hide();n.hoverState = "out", this.timeout = setTimeout(function () {
        n.hoverState == "out" && n.hide();
      }, n.options.delay.hide);
    }, show: function show() {
      var e, t, n, r, i, s, o;if (this.hasContent() && this.enabled) {
        e = this.tip(), this.setContent(), this.options.animation && e.addClass("fade"), s = typeof this.options.placement == "function" ? this.options.placement.call(this, e[0], this.$element[0]) : this.options.placement, t = /in/.test(s), e.detach().css({ top: 0, left: 0, display: "block" }).insertAfter(this.$element), n = this.getPosition(t), r = e[0].offsetWidth, i = e[0].offsetHeight;switch (t ? s.split(" ")[1] : s) {case "bottom":
            o = { top: n.top + n.height, left: n.left + n.width / 2 - r / 2 };break;case "top":
            o = { top: n.top - i, left: n.left + n.width / 2 - r / 2 };break;case "left":
            o = { top: n.top + n.height / 2 - i / 2, left: n.left - r };break;case "right":
            o = { top: n.top + n.height / 2 - i / 2, left: n.left + n.width };}e.offset(o).addClass(s).addClass("in");
      }
    }, setContent: function setContent() {
      var e = this.tip(),
          t = this.getTitle();e.find(".tooltip-inner")[this.options.html ? "html" : "text"](t), e.removeClass("fade in top bottom left right");
    }, hide: function hide() {
      function r() {
        var t = setTimeout(function () {
          n.off(e.support.transition.end).detach();
        }, 500);n.one(e.support.transition.end, function () {
          clearTimeout(t), n.detach();
        });
      }var t = this,
          n = this.tip();return n.removeClass("in"), e.support.transition && this.$tip.hasClass("fade") ? r() : n.detach(), this;
    }, fixTitle: function fixTitle() {
      var e = this.$element;(e.attr("title") || typeof e.attr("data-original-title") != "string") && e.attr("data-original-title", e.attr("title") || "").removeAttr("title");
    }, hasContent: function hasContent() {
      return this.getTitle();
    }, getPosition: function getPosition(t) {
      return e.extend({}, t ? { top: 0, left: 0 } : this.$element.offset(), { width: this.$element[0].offsetWidth, height: this.$element[0].offsetHeight });
    }, getTitle: function getTitle() {
      var e,
          t = this.$element,
          n = this.options;return e = t.attr("data-original-title") || (typeof n.title == "function" ? n.title.call(t[0]) : n.title), e;
    }, tip: function tip() {
      return this.$tip = this.$tip || e(this.options.template);
    }, validate: function validate() {
      this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null);
    }, enable: function enable() {
      this.enabled = !0;
    }, disable: function disable() {
      this.enabled = !1;
    }, toggleEnabled: function toggleEnabled() {
      this.enabled = !this.enabled;
    }, toggle: function toggle(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);n[n.tip().hasClass("in") ? "hide" : "show"]();
    }, destroy: function destroy() {
      this.hide().$element.off("." + this.type).removeData(this.type);
    } }, e.fn.tooltip = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("tooltip"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("tooltip", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.tooltip.Constructor = t, e.fn.tooltip.defaults = { animation: !0, placement: "top", selector: !1, template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', trigger: "hover", title: "", delay: 0, html: !1 };
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(e, _t6) {
    this.init("popover", e, _t6);
  };t.prototype = e.extend({}, e.fn.tooltip.Constructor.prototype, { constructor: t, setContent: function setContent() {
      var e = this.tip(),
          t = this.getTitle(),
          n = this.getContent();e.find(".popover-title")[this.options.html ? "html" : "text"](t), e.find(".popover-content > *")[this.options.html ? "html" : "text"](n), e.removeClass("fade top bottom left right in");
    }, hasContent: function hasContent() {
      return this.getTitle() || this.getContent();
    }, getContent: function getContent() {
      var e,
          t = this.$element,
          n = this.options;return e = t.attr("data-content") || (typeof n.content == "function" ? n.content.call(t[0]) : n.content), e;
    }, tip: function tip() {
      return this.$tip || (this.$tip = e(this.options.template)), this.$tip;
    }, destroy: function destroy() {
      this.hide().$element.off("." + this.type).removeData(this.type);
    } }), e.fn.popover = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("popover"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("popover", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.popover.Constructor = t, e.fn.popover.defaults = e.extend({}, e.fn.tooltip.defaults, { placement: "right", trigger: "click", content: "", template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>' });
}(window.jQuery), !function (e) {
  "use strict";
  function t(t, n) {
    var r = e.proxy(this.process, this),
        i = e(t).is("body") ? e(window) : e(t),
        s;this.options = e.extend({}, e.fn.scrollspy.defaults, n), this.$scrollElement = i.on("scroll.scroll-spy.data-api", r), this.selector = (this.options.target || (s = e(t).attr("href")) && s.replace(/.*(?=#[^\s]+$)/, "") || "") + " .nav li > a", this.$body = e("body"), this.refresh(), this.process();
  }t.prototype = { constructor: t, refresh: function refresh() {
      var t = this,
          n;this.offsets = e([]), this.targets = e([]), n = this.$body.find(this.selector).map(function () {
        var t = e(this),
            n = t.data("target") || t.attr("href"),
            r = /^#\w/.test(n) && e(n);return r && r.length && [[r.position().top, n]] || null;
      }).sort(function (e, t) {
        return e[0] - t[0];
      }).each(function () {
        t.offsets.push(this[0]), t.targets.push(this[1]);
      });
    }, process: function process() {
      var e = this.$scrollElement.scrollTop() + this.options.offset,
          t = this.$scrollElement[0].scrollHeight || this.$body[0].scrollHeight,
          n = t - this.$scrollElement.height(),
          r = this.offsets,
          i = this.targets,
          s = this.activeTarget,
          o;if (e >= n) return s != (o = i.last()[0]) && this.activate(o);for (o = r.length; o--;) {
        s != i[o] && e >= r[o] && (!r[o + 1] || e <= r[o + 1]) && this.activate(i[o]);
      }
    }, activate: function activate(t) {
      var n, r;this.activeTarget = t, e(this.selector).parent(".active").removeClass("active"), r = this.selector + '[data-target="' + t + '"],' + this.selector + '[href="' + t + '"]', n = e(r).parent("li").addClass("active"), n.parent(".dropdown-menu").length && (n = n.closest("li.dropdown").addClass("active")), n.trigger("activate");
    } }, e.fn.scrollspy = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("scrollspy"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("scrollspy", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.scrollspy.Constructor = t, e.fn.scrollspy.defaults = { offset: 10 }, e(window).on("load", function () {
    e('[data-spy="scroll"]').each(function () {
      var t = e(this);t.scrollspy(t.data());
    });
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t7) {
    this.element = e(_t7);
  };t.prototype = { constructor: t, show: function show() {
      var t = this.element,
          n = t.closest("ul:not(.dropdown-menu)"),
          r = t.attr("data-target"),
          i,
          s,
          o;r || (r = t.attr("href"), r = r && r.replace(/.*(?=#[^\s]*$)/, ""));if (t.parent("li").hasClass("active")) return;i = n.find(".active:last a")[0], o = e.Event("show", { relatedTarget: i }), t.trigger(o);if (o.isDefaultPrevented()) return;s = e(r), this.activate(t.parent("li"), n), this.activate(s, s.parent(), function () {
        t.trigger({ type: "shown", relatedTarget: i });
      });
    }, activate: function activate(t, n, r) {
      function o() {
        i.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"), t.addClass("active"), s ? (t[0].offsetWidth, t.addClass("in")) : t.removeClass("fade"), t.parent(".dropdown-menu") && t.closest("li.dropdown").addClass("active"), r && r();
      }var i = n.find("> .active"),
          s = r && e.support.transition && i.hasClass("fade");s ? i.one(e.support.transition.end, o) : o(), i.removeClass("in");
    } }, e.fn.tab = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("tab");i || r.data("tab", i = new t(this)), typeof n == "string" && i[n]();
    });
  }, e.fn.tab.Constructor = t, e(document).on("click.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function (t) {
    t.preventDefault(), e(this).tab("show");
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t8, n) {
    this.$element = e(_t8), this.options = e.extend({}, e.fn.typeahead.defaults, n), this.matcher = this.options.matcher || this.matcher, this.sorter = this.options.sorter || this.sorter, this.highlighter = this.options.highlighter || this.highlighter, this.updater = this.options.updater || this.updater, this.$menu = e(this.options.menu).appendTo("body"), this.source = this.options.source, this.shown = !1, this.listen();
  };t.prototype = { constructor: t, select: function select() {
      var e = this.$menu.find(".active").attr("data-value");return this.$element.val(this.updater(e)).change(), this.hide();
    }, updater: function updater(e) {
      return e;
    }, show: function show() {
      var t = e.extend({}, this.$element.offset(), { height: this.$element[0].offsetHeight });return this.$menu.css({ top: t.top + t.height, left: t.left }), this.$menu.show(), this.shown = !0, this;
    }, hide: function hide() {
      return this.$menu.hide(), this.shown = !1, this;
    }, lookup: function lookup(t) {
      var n;return this.query = this.$element.val(), !this.query || this.query.length < this.options.minLength ? this.shown ? this.hide() : this : (n = e.isFunction(this.source) ? this.source(this.query, e.proxy(this.process, this)) : this.source, n ? this.process(n) : this);
    }, process: function process(t) {
      var n = this;return t = e.grep(t, function (e) {
        return n.matcher(e);
      }), t = this.sorter(t), t.length ? this.render(t.slice(0, this.options.items)).show() : this.shown ? this.hide() : this;
    }, matcher: function matcher(e) {
      return ~e.toLowerCase().indexOf(this.query.toLowerCase());
    }, sorter: function sorter(e) {
      var t = [],
          n = [],
          r = [],
          i;while (i = e.shift()) {
        i.toLowerCase().indexOf(this.query.toLowerCase()) ? ~i.indexOf(this.query) ? n.push(i) : r.push(i) : t.push(i);
      }return t.concat(n, r);
    }, highlighter: function highlighter(e) {
      var t = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");return e.replace(new RegExp("(" + t + ")", "ig"), function (e, t) {
        return "<strong>" + t + "</strong>";
      });
    }, render: function render(t) {
      var n = this;return t = e(t).map(function (t, r) {
        return t = e(n.options.item).attr("data-value", r), t.find("a").html(n.highlighter(r)), t[0];
      }), t.first().addClass("active"), this.$menu.html(t), this;
    }, next: function next(t) {
      var n = this.$menu.find(".active").removeClass("active"),
          r = n.next();r.length || (r = e(this.$menu.find("li")[0])), r.addClass("active");
    }, prev: function prev(e) {
      var t = this.$menu.find(".active").removeClass("active"),
          n = t.prev();n.length || (n = this.$menu.find("li").last()), n.addClass("active");
    }, listen: function listen() {
      this.$element.on("blur", e.proxy(this.blur, this)).on("keypress", e.proxy(this.keypress, this)).on("keyup", e.proxy(this.keyup, this)), this.eventSupported("keydown") && this.$element.on("keydown", e.proxy(this.keydown, this)), this.$menu.on("click", e.proxy(this.click, this)).on("mouseenter", "li", e.proxy(this.mouseenter, this));
    }, eventSupported: function eventSupported(e) {
      var t = e in this.$element;return t || (this.$element.setAttribute(e, "return;"), t = typeof this.$element[e] == "function"), t;
    }, move: function move(e) {
      if (!this.shown) return;switch (e.keyCode) {case 9:case 13:case 27:
          e.preventDefault();break;case 38:
          e.preventDefault(), this.prev();break;case 40:
          e.preventDefault(), this.next();}e.stopPropagation();
    }, keydown: function keydown(t) {
      this.suppressKeyPressRepeat = !~e.inArray(t.keyCode, [40, 38, 9, 13, 27]), this.move(t);
    }, keypress: function keypress(e) {
      if (this.suppressKeyPressRepeat) return;this.move(e);
    }, keyup: function keyup(e) {
      switch (e.keyCode) {case 40:case 38:case 16:case 17:case 18:
          break;case 9:case 13:
          if (!this.shown) return;this.select();break;case 27:
          if (!this.shown) return;this.hide();break;default:
          this.lookup();}e.stopPropagation(), e.preventDefault();
    }, blur: function blur(e) {
      var t = this;setTimeout(function () {
        t.hide();
      }, 150);
    }, click: function click(e) {
      e.stopPropagation(), e.preventDefault(), this.select();
    }, mouseenter: function mouseenter(t) {
      this.$menu.find(".active").removeClass("active"), e(t.currentTarget).addClass("active");
    } }, e.fn.typeahead = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("typeahead"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("typeahead", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.typeahead.defaults = { source: [], items: 8, menu: '<ul class="typeahead dropdown-menu"></ul>', item: '<li><a href="#"></a></li>', minLength: 1 }, e.fn.typeahead.Constructor = t, e(document).on("focus.typeahead.data-api", '[data-provide="typeahead"]', function (t) {
    var n = e(this);if (n.data("typeahead")) return;t.preventDefault(), n.typeahead(n.data());
  });
}(window.jQuery), !function (e) {
  "use strict";
  var t = function t(_t9, n) {
    this.options = e.extend({}, e.fn.affix.defaults, n), this.$window = e(window).on("scroll.affix.data-api", e.proxy(this.checkPosition, this)).on("click.affix.data-api", e.proxy(function () {
      setTimeout(e.proxy(this.checkPosition, this), 1);
    }, this)), this.$element = e(_t9), this.checkPosition();
  };t.prototype.checkPosition = function () {
    if (!this.$element.is(":visible")) return;var t = e(document).height(),
        n = this.$window.scrollTop(),
        r = this.$element.offset(),
        i = this.options.offset,
        s = i.bottom,
        o = i.top,
        u = "affix affix-top affix-bottom",
        a;(typeof i === "undefined" ? "undefined" : _typeof(i)) != "object" && (s = o = i), typeof o == "function" && (o = i.top()), typeof s == "function" && (s = i.bottom()), a = this.unpin != null && n + this.unpin <= r.top ? !1 : s != null && r.top + this.$element.height() >= t - s ? "bottom" : o != null && n <= o ? "top" : !1;if (this.affixed === a) return;this.affixed = a, this.unpin = a == "bottom" ? r.top - n : null, this.$element.removeClass(u).addClass("affix" + (a ? "-" + a : ""));
  }, e.fn.affix = function (n) {
    return this.each(function () {
      var r = e(this),
          i = r.data("affix"),
          s = (typeof n === "undefined" ? "undefined" : _typeof(n)) == "object" && n;i || r.data("affix", i = new t(this, s)), typeof n == "string" && i[n]();
    });
  }, e.fn.affix.Constructor = t, e.fn.affix.defaults = { offset: 0 }, e(window).on("load", function () {
    e('[data-spy="affix"]').each(function () {
      var t = e(this),
          n = t.data();n.offset = n.offset || {}, n.offsetBottom && (n.offset.bottom = n.offsetBottom), n.offsetTop && (n.offset.top = n.offsetTop), t.affix(n);
    });
  });
}(window.jQuery);

/***/ }),
/* 14 */
/***/ (function(module, exports) {

/*!
	Autosize v1.18.9 - 2014-05-27
	Automatically adjust textarea height based on user input.
	(c) 2014 Jack Moore - http://www.jacklmoore.com/autosize
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function (e) {
	var t,
	    o = { className: "autosizejs", id: "autosizejs", append: "\n", callback: !1, resizeDelay: 10, placeholder: !0 },
	    i = '<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',
	    n = ["fontFamily", "fontSize", "fontWeight", "fontStyle", "letterSpacing", "textTransform", "wordSpacing", "textIndent"],
	    s = e(i).data("autosize", !0)[0];s.style.lineHeight = "99px", "99px" === e(s).css("lineHeight") && n.push("lineHeight"), s.style.lineHeight = "", e.fn.autosize = function (i) {
		return this.length ? (i = e.extend({}, o, i || {}), s.parentNode !== document.body && e(document.body).append(s), this.each(function () {
			function o() {
				var t,
				    o = window.getComputedStyle ? window.getComputedStyle(u, null) : !1;o ? (t = u.getBoundingClientRect().width, (0 === t || "number" != typeof t) && (t = parseInt(o.width, 10)), e.each(["paddingLeft", "paddingRight", "borderLeftWidth", "borderRightWidth"], function (e, i) {
					t -= parseInt(o[i], 10);
				})) : t = p.width(), s.style.width = Math.max(t, 0) + "px";
			}function a() {
				var a = {};if (t = u, s.className = i.className, s.id = i.id, d = parseInt(p.css("maxHeight"), 10), e.each(n, function (e, t) {
					a[t] = p.css(t);
				}), e(s).css(a).attr("wrap", p.attr("wrap")), o(), window.chrome) {
					var r = u.style.width;u.style.width = "0px", u.offsetWidth, u.style.width = r;
				}
			}function r() {
				var e, n;t !== u ? a() : o(), s.value = !u.value && i.placeholder ? (p.attr("placeholder") || "") + i.append : u.value + i.append, s.style.overflowY = u.style.overflowY, n = parseInt(u.style.height, 10), s.scrollTop = 0, s.scrollTop = 9e4, e = s.scrollTop, d && e > d ? (u.style.overflowY = "scroll", e = d) : (u.style.overflowY = "hidden", c > e && (e = c)), e += w, n !== e && (u.style.height = e + "px", f && i.callback.call(u, u));
			}function l() {
				clearTimeout(h), h = setTimeout(function () {
					var e = p.width();e !== g && (g = e, r());
				}, parseInt(i.resizeDelay, 10));
			}var d,
			    c,
			    h,
			    u = this,
			    p = e(u),
			    w = 0,
			    f = e.isFunction(i.callback),
			    z = { height: u.style.height, overflow: u.style.overflow, overflowY: u.style.overflowY, wordWrap: u.style.wordWrap, resize: u.style.resize },
			    g = p.width(),
			    y = p.css("resize");p.data("autosize") || (p.data("autosize", !0), ("border-box" === p.css("box-sizing") || "border-box" === p.css("-moz-box-sizing") || "border-box" === p.css("-webkit-box-sizing")) && (w = p.outerHeight() - p.height()), c = Math.max(parseInt(p.css("minHeight"), 10) - w || 0, p.height()), p.css({ overflow: "hidden", overflowY: "hidden", wordWrap: "break-word" }), "vertical" === y ? p.css("resize", "none") : "both" === y && p.css("resize", "horizontal"), "onpropertychange" in u ? "oninput" in u ? p.on("input.autosize keyup.autosize", r) : p.on("propertychange.autosize", function () {
				"value" === event.propertyName && r();
			}) : p.on("input.autosize", r), i.resizeDelay !== !1 && e(window).on("resize.autosize", l), p.on("autosize.resize", r), p.on("autosize.resizeIncludeStyle", function () {
				t = null, r();
			}), p.on("autosize.destroy", function () {
				t = null, clearTimeout(h), e(window).off("resize", l), p.off("autosize").off(".autosize").css(z).removeData("autosize");
			}), r());
		})) : this;
	};
})(window.jQuery || window.$);

/***/ }),
/* 15 */
/***/ (function(module, exports) {

/*

 Uniform v1.7.5
 Copyright Â© 2009 Josh Pyles / Pixelmatrix Design LLC
 http://pixelmatrixdesign.com

 Requires jQuery 1.4 or newer

 Much thanks to Thomas Reynolds and Buck Wilson for their help and advice on this

 Disabling text selection is made possible by Mathias Bynens <http://mathiasbynens.be/>
 and his noSelect plugin. <http://github.com/mathiasbynens/noSelect-jQuery-Plugin>

 Also, thanks to David Kaneda and Eugene Bond for their contributions to the plugin

 License:
 MIT License - http://www.opensource.org/licenses/mit-license.php

 Enjoy!

 */

(function ($) {
    $.uniform = {
        options: {
            selectClass: 'selector',
            radiosClass: 'radios',
            fileClass: 'uploader',
            filenameClass: 'filename',
            fileBtnClass: 'action',
            fileDefaultText: 'No file selected',
            fileBtnText: 'Choose File',
            chckedsClass: 'chckeds',
            focusClass: 'focus',
            disabledClass: 'disabled',
            buttonClass: 'button',
            activeClass: 'active',
            hoverClass: 'hover',
            useID: true,
            idPrefix: 'uniform',
            resetSelector: false,
            autoHide: true
        },
        elements: []
    };

    // if($.browser.msie && $.browser.version < 7){
    //   $.support.selectOpacity = false;
    // }else{
    //
    // }
    $.support.selectOpacity = true;

    $.fn.uniform = function (options) {

        options = $.extend($.uniform.options, options);

        var el = this;
        //code for specifying a reset button
        if (options.resetSelector != false) {
            $(options.resetSelector).mouseup(function () {
                function resetThis() {
                    $.uniform.update(el);
                }

                setTimeout(resetThis, 10);
            });
        }

        function doInput(elem) {
            $el = $(elem);
            $el.addClass($el.attr("type"));
            storeElement(elem);
        }

        function doTextarea(elem) {
            $(elem).addClass("uniform");
            storeElement(elem);
        }

        function doButton(elem) {
            var $el = $(elem);

            var divTag = $("<div>"),
                spanTag = $("<span>");

            divTag.addClass(options.buttonClass);

            if (options.useID && $el.attr("id") != "") divTag.attr("id", options.idPrefix + "-" + $el.attr("id"));

            var btnText;

            if ($el.is("a") || $el.is("button")) {
                btnText = $el.text();
            } else if ($el.is(":submit") || $el.is(":reset") || $el.is("input[type=button]")) {
                btnText = $el.attr("value");
            }

            btnText = btnText == "" ? $el.is(":reset") ? "Reset" : "Submit" : btnText;

            spanTag.html(btnText);

            $el.css("opacity", 0);
            $el.wrap(divTag);
            $el.wrap(spanTag);

            //redefine variables
            divTag = $el.closest("div");
            spanTag = $el.closest("span");

            if ($el.is(":disabled")) divTag.addClass(options.disabledClass);

            divTag.bind({
                "mouseenter.uniform": function mouseenterUniform() {
                    divTag.addClass(options.hoverClass);
                },
                "mouseleave.uniform": function mouseleaveUniform() {
                    divTag.removeClass(options.hoverClass);
                    divTag.removeClass(options.activeClass);
                },
                "mousedown.uniform touchbegin.uniform": function mousedownUniformTouchbeginUniform() {
                    divTag.addClass(options.activeClass);
                },
                "mouseup.uniform touchend.uniform": function mouseupUniformTouchendUniform() {
                    divTag.removeClass(options.activeClass);
                },
                "click.uniform touchend.uniform": function clickUniformTouchendUniform(e) {
                    if ($(e.target).is("span") || $(e.target).is("div")) {
                        if (elem[0].dispatchEvent) {
                            var ev = document.createEvent('MouseEvents');
                            ev.initEvent('click', true, true);
                            elem[0].dispatchEvent(ev);
                        } else {
                            elem[0].click();
                        }
                    }
                }
            });

            elem.bind({
                "focus.uniform": function focusUniform() {
                    divTag.addClass(options.focusClass);
                },
                "blur.uniform": function blurUniform() {
                    divTag.removeClass(options.focusClass);
                }
            });

            $.uniform.noSelect(divTag);
            storeElement(elem);
        }

        function doSelect(elem) {
            var $el = $(elem);

            var divTag = $('<div />'),
                spanTag = $('<span />');

            if (!$el.css("display") == "none" && options.autoHide) {
                divTag.hide();
            }

            divTag.addClass(options.selectClass);

            if (options.useID && elem.attr("id") != "") {
                divTag.attr("id", options.idPrefix + "-" + elem.attr("id"));
            }

            var selected = elem.find(":selected:first");
            if (selected.length == 0) {
                selected = elem.find("option:first");
            }
            spanTag.html(selected.html());

            elem.css('opacity', 0);
            elem.wrap(divTag);
            elem.before(spanTag);

            //redefine variables
            divTag = elem.parent("div");
            spanTag = elem.siblings("span");

            elem.bind({
                "change.uniform": function changeUniform() {
                    spanTag.text(elem.find(":selected").html());
                    divTag.removeClass(options.activeClass);
                },
                "focus.uniform": function focusUniform() {
                    divTag.addClass(options.focusClass);
                },
                "blur.uniform": function blurUniform() {
                    divTag.removeClass(options.focusClass);
                    divTag.removeClass(options.activeClass);
                },
                "mousedown.uniform touchbegin.uniform": function mousedownUniformTouchbeginUniform() {
                    divTag.addClass(options.activeClass);
                },
                "mouseup.uniform touchend.uniform": function mouseupUniformTouchendUniform() {
                    divTag.removeClass(options.activeClass);
                },
                "click.uniform touchend.uniform": function clickUniformTouchendUniform() {
                    divTag.removeClass(options.activeClass);
                },
                "mouseenter.uniform": function mouseenterUniform() {
                    divTag.addClass(options.hoverClass);
                },
                "mouseleave.uniform": function mouseleaveUniform() {
                    divTag.removeClass(options.hoverClass);
                    divTag.removeClass(options.activeClass);
                },
                "keyup.uniform": function keyupUniform() {
                    spanTag.text(elem.find(":selected").html());
                }
            });

            //handle disabled state
            if ($(elem).attr("disabled")) {
                //box is chckeds by default, check our box
                divTag.addClass(options.disabledClass);
            }
            $.uniform.noSelect(spanTag);

            storeElement(elem);
        }

        function doFile(elem) {
            //sanitize input
            var $el = $(elem);

            var divTag = $('<div />'),
                filenameTag = $('<span>' + options.fileDefaultText + '</span>'),
                btnTag = $('<span>' + options.fileBtnText + '</span>');

            if (!$el.css("display") == "none" && options.autoHide) {
                divTag.hide();
            }

            divTag.addClass(options.fileClass);
            filenameTag.addClass(options.filenameClass);
            btnTag.addClass(options.fileBtnClass);

            if (options.useID && $el.attr("id") != "") {
                divTag.attr("id", options.idPrefix + "-" + $el.attr("id"));
            }

            //wrap with the proper elements
            $el.wrap(divTag);
            $el.after(btnTag);
            $el.after(filenameTag);

            //redefine variables
            divTag = $el.closest("div");
            filenameTag = $el.siblings("." + options.filenameClass);
            btnTag = $el.siblings("." + options.fileBtnClass);

            //set the size
            if (!$el.attr("size")) {
                var divWidth = divTag.width();
                //$el.css("width", divWidth);
                $el.attr("size", divWidth / 10);
            }

            //actions
            var setFilename = function setFilename() {
                var filename = $el.val();
                if (filename === '') {
                    filename = options.fileDefaultText;
                } else {
                    filename = filename.split(/[\/\\]+/);
                    filename = filename[filename.length - 1];
                }
                filenameTag.text(filename);
            };

            // Account for input saved across refreshes
            setFilename();

            $el.css("opacity", 0).bind({
                "focus.uniform": function focusUniform() {
                    divTag.addClass(options.focusClass);
                },
                "blur.uniform": function blurUniform() {
                    divTag.removeClass(options.focusClass);
                },
                "mousedown.uniform": function mousedownUniform() {
                    if (!$(elem).is(":disabled")) {
                        divTag.addClass(options.activeClass);
                    }
                },
                "mouseup.uniform": function mouseupUniform() {
                    divTag.removeClass(options.activeClass);
                },
                "mouseenter.uniform": function mouseenterUniform() {
                    divTag.addClass(options.hoverClass);
                },
                "mouseleave.uniform": function mouseleaveUniform() {
                    divTag.removeClass(options.hoverClass);
                    divTag.removeClass(options.activeClass);
                }
            });

            // // IE7 doesn't fire onChange until blur or second fire.
            // if ($.browser.msie) {
            //     // IE considers browser chrome blocking I/O, so it
            //     // suspends tiemouts until after the file has been selected.
            //     $el.bind('click.uniform.ie7', function () {
            //         setTimeout(setFilename, 0);
            //     });
            // } else {
            //     // All other browsers behave properly
            //     $el.bind('change.uniform', setFilename);
            // }
            $el.bind('change.uniform', setFilename);

            //handle defaults
            if ($el.attr("disabled")) {
                //box is chckeds by default, check our box
                divTag.addClass(options.disabledClass);
            }

            $.uniform.noSelect(filenameTag);
            $.uniform.noSelect(btnTag);

            storeElement(elem);
        }

        $.uniform.restore = function (elem) {
            if (elem == undefined) {
                elem = $($.uniform.elements);
            }

            $(elem).each(function () {
                if ($(this).is("select")) {
                    //remove sibling span
                    $(this).siblings("span").remove();
                    //unwrap parent div
                    $(this).unwrap();
                } else if ($(this).is(":radios")) {
                    //unwrap from span and div
                    $(this).unwrap().unwrap();
                } else if ($(this).is(":file")) {
                    //remove sibling spans
                    $(this).siblings("span").remove();
                    //unwrap parent div
                    $(this).unwrap();
                } else if ($(this).is("button, :submit, :reset, a, input[type='button']")) {
                    //unwrap from span and div
                    $(this).unwrap().unwrap();
                }

                //unbind events
                $(this).unbind(".uniform");

                //reset inline style
                $(this).css("opacity", "1");

                //remove item from list of uniformed elements
                var index = $.inArray($(elem), $.uniform.elements);
                $.uniform.elements.splice(index, 1);
            });
        };

        function storeElement(elem) {
            //store this element in our global array
            elem = $(elem).get();
            if (elem.length > 1) {
                $.each(elem, function (i, val) {
                    $.uniform.elements.push(val);
                });
            } else {
                $.uniform.elements.push(elem);
            }
        }

        //noSelect v1.0
        $.uniform.noSelect = function (elem) {
            function f() {
                return false;
            };
            $(elem).each(function () {
                this.onselectstart = this.ondragstart = f; // Webkit & IE
                $(this).mousedown(f) // Webkit & Opera
                .css({ MozUserSelect: 'none' }); // Firefox
            });
        };

        $.uniform.update = function (elem) {
            if (elem == undefined) {
                elem = $($.uniform.elements);
            }
            //sanitize input
            elem = $(elem);

            elem.each(function () {
                //do to each item in the selector
                //function to reset all classes
                var $e = $(this);

                if ($e.is("select")) {
                    //element is a select
                    var spanTag = $e.siblings("span");
                    var divTag = $e.parent("div");

                    divTag.removeClass(options.hoverClass + " " + options.focusClass + " " + options.activeClass);

                    //reset current selected text
                    spanTag.html($e.find(":selected").html());

                    if ($e.is(":disabled")) {
                        divTag.addClass(options.disabledClass);
                    } else {
                        divTag.removeClass(options.disabledClass);
                    }
                } else if ($e.is(":file")) {
                    var divTag = $e.parent("div");
                    var filenameTag = $e.siblings(options.filenameClass);
                    btnTag = $e.siblings(options.fileBtnClass);

                    divTag.removeClass(options.hoverClass + " " + options.focusClass + " " + options.activeClass);

                    filenameTag.text($e.val());

                    if ($e.is(":disabled")) {
                        divTag.addClass(options.disabledClass);
                    } else {
                        divTag.removeClass(options.disabledClass);
                    }
                } else if ($e.is(":submit") || $e.is(":reset") || $e.is("button") || $e.is("a") || elem.is("input[type=button]")) {
                    var divTag = $e.closest("div");
                    divTag.removeClass(options.hoverClass + " " + options.focusClass + " " + options.activeClass);

                    if ($e.is(":disabled")) {
                        divTag.addClass(options.disabledClass);
                    } else {
                        divTag.removeClass(options.disabledClass);
                    }
                }
            });
        };

        return this.each(function () {
            if ($.support.selectOpacity) {
                var elem = $(this);

                if (elem.is("select")) {
                    //element is a select
                    if (elem.attr("multiple") != true) {
                        //element is not a multi-select
                        if (elem.attr("size") == undefined || elem.attr("size") <= 1) {
                            doSelect(elem);
                        }
                    }
                } else if (elem.is(":file")) {
                    //element is a file upload
                    doFile(elem);
                } else if (elem.is(":text, :password, input[type='email']")) {
                    doInput(elem);
                } else if (elem.is("textarea")) {
                    doTextarea(elem);
                } else if (elem.is("a") || elem.is(":submit") || elem.is(":reset") || elem.is("button") || elem.is("input[type=button]")) {
                    doButton(elem);
                }
            }
        });
    };
})(jQuery);

/***/ }),
/* 16 */
/***/ (function(module, exports) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/**
 * jQuery Validation Plugin 1.9.0
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * http://docs.jquery.com/Plugins/Validation
 *
 * Copyright (c) 2006 - 2011 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function ($) {

	$.extend($.fn, {
		// http://docs.jquery.com/Plugins/Validation/validate
		validate: function validate(options) {

			// if nothing is selected, return nothing; can't chain anyway
			if (!this.length) {
				options && options.debug && window.console && console.warn("nothing selected, can't validate, returning nothing");
				return;
			}

			// check if a validator for this form was already created
			var validator = $.data(this[0], 'validator');
			if (validator) {
				return validator;
			}

			// Add novalidate tag if HTML5.
			this.attr('novalidate', 'novalidate');

			validator = new $.validator(options, this[0]);
			$.data(this[0], 'validator', validator);

			if (validator.settings.onsubmit) {

				var inputsAndButtons = this.find("input, button");

				// allow suppresing validation by adding a cancel class to the submit button
				inputsAndButtons.filter(".cancel").click(function () {
					validator.cancelSubmit = true;
				});

				// when a submitHandler is used, capture the submitting button
				if (validator.settings.submitHandler) {
					inputsAndButtons.filter(":submit").click(function () {
						validator.submitButton = this;
					});
				}

				// validate the form on submit
				this.submit(function (event) {
					if (validator.settings.debug)
						// prevent form submit to be able to see console output
						event.preventDefault();

					function handle() {
						if (validator.settings.submitHandler) {
							if (validator.submitButton) {
								// insert a hidden input as a replacement for the missing submit button
								var hidden = $("<input type='hidden'/>").attr("name", validator.submitButton.name).val(validator.submitButton.value).appendTo(validator.currentForm);
							}
							validator.settings.submitHandler.call(validator, validator.currentForm);
							if (validator.submitButton) {
								// and clean up afterwards; thanks to no-block-scope, hidden can be referenced
								hidden.remove();
							}
							return false;
						}
						return true;
					}

					// prevent submit for invalid forms or custom submit handlers
					if (validator.cancelSubmit) {
						validator.cancelSubmit = false;
						return handle();
					}
					if (validator.form()) {
						if (validator.pendingRequest) {
							validator.formSubmitted = true;
							return false;
						}
						return handle();
					} else {
						validator.focusInvalid();
						return false;
					}
				});
			}

			return validator;
		},
		// http://docs.jquery.com/Plugins/Validation/valid
		valid: function valid() {
			if ($(this[0]).is('form')) {
				return this.validate().form();
			} else {
				var valid = true;
				var validator = $(this[0].form).validate();
				this.each(function () {
					valid &= validator.element(this);
				});
				return valid;
			}
		},
		// attributes: space seperated list of attributes to retrieve and remove
		removeAttrs: function removeAttrs(attributes) {
			var result = {},
			    $element = this;
			$.each(attributes.split(/\s/), function (index, value) {
				result[value] = $element.attr(value);
				$element.removeAttr(value);
			});
			return result;
		},
		// http://docs.jquery.com/Plugins/Validation/rules
		rules: function rules(command, argument) {
			var element = this[0];

			if (command) {
				var settings = $.data(element.form, 'validator').settings;
				var staticRules = settings.rules;
				var existingRules = $.validator.staticRules(element);
				switch (command) {
					case "add":
						$.extend(existingRules, $.validator.normalizeRule(argument));
						staticRules[element.name] = existingRules;
						if (argument.messages) settings.messages[element.name] = $.extend(settings.messages[element.name], argument.messages);
						break;
					case "remove":
						if (!argument) {
							delete staticRules[element.name];
							return existingRules;
						}
						var filtered = {};
						$.each(argument.split(/\s/), function (index, method) {
							filtered[method] = existingRules[method];
							delete existingRules[method];
						});
						return filtered;
				}
			}

			var data = $.validator.normalizeRules($.extend({}, $.validator.metadataRules(element), $.validator.classRules(element), $.validator.attributeRules(element), $.validator.staticRules(element)), element);

			// make sure required is at front
			if (data.required) {
				var param = data.required;
				delete data.required;
				data = $.extend({ required: param }, data);
			}

			return data;
		}
	});

	// Custom selectors
	$.extend($.expr[":"], {
		// http://docs.jquery.com/Plugins/Validation/blank
		blank: function blank(a) {
			return !$.trim("" + a.value);
		},
		// http://docs.jquery.com/Plugins/Validation/filled
		filled: function filled(a) {
			return !!$.trim("" + a.value);
		},
		// http://docs.jquery.com/Plugins/Validation/unchecked
		unchecked: function unchecked(a) {
			return !a.checked;
		}
	});

	// constructor for validator
	$.validator = function (options, form) {
		this.settings = $.extend(true, {}, $.validator.defaults, options);
		this.currentForm = form;
		this.init();
	};

	$.validator.format = function (source, params) {
		if (arguments.length == 1) return function () {
			var args = $.makeArray(arguments);
			args.unshift(source);
			return $.validator.format.apply(this, args);
		};
		if (arguments.length > 2 && params.constructor != Array) {
			params = $.makeArray(arguments).slice(1);
		}
		if (params.constructor != Array) {
			params = [params];
		}
		$.each(params, function (i, n) {
			source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
		});
		return source;
	};

	$.extend($.validator, {

		defaults: {
			messages: {},
			groups: {},
			rules: {},
			errorClass: "error",
			validClass: "valid",
			errorElement: "label",
			focusInvalid: true,
			errorContainer: $([]),
			errorLabelContainer: $([]),
			onsubmit: true,
			ignore: ":hidden",
			ignoreTitle: false,
			onfocusin: function onfocusin(element, event) {
				this.lastActive = element;

				// hide error label and remove error class on focus if enabled
				if (this.settings.focusCleanup && !this.blockFocusCleanup) {
					this.settings.unhighlight && this.settings.unhighlight.call(this, element, this.settings.errorClass, this.settings.validClass);
					this.addWrapper(this.errorsFor(element)).hide();
				}
			},
			onfocusout: function onfocusout(element, event) {
				if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))) {
					this.element(element);
				}
			},
			onkeyup: function onkeyup(element, event) {
				if (element.name in this.submitted || element == this.lastElement) {
					this.element(element);
				}
			},
			onclick: function onclick(element, event) {
				// click on selects, radiobuttons and checkboxes
				if (element.name in this.submitted) this.element(element);
				// or option elements, check parent select in that case
				else if (element.parentNode.name in this.submitted) this.element(element.parentNode);
			},
			highlight: function highlight(element, errorClass, validClass) {
				if (element.type === 'radio') {
					this.findByName(element.name).addClass(errorClass).removeClass(validClass);
				} else {
					$(element).addClass(errorClass).removeClass(validClass);
				}
			},
			unhighlight: function unhighlight(element, errorClass, validClass) {
				if (element.type === 'radio') {
					this.findByName(element.name).removeClass(errorClass).addClass(validClass);
				} else {
					$(element).removeClass(errorClass).addClass(validClass);
				}
			}
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/setDefaults
		setDefaults: function setDefaults(settings) {
			$.extend($.validator.defaults, settings);
		},

		messages: {
			required: "This field is required.",
			remote: "Please fix this field.",
			email: "Please enter a valid email address.",
			url: "Please enter a valid URL.",
			date: "Please enter a valid date.",
			dateISO: "Please enter a valid date (ISO).",
			number: "Please enter a valid number.",
			digits: "Please enter only digits.",
			creditcard: "Please enter a valid credit card number.",
			equalTo: "Please enter the same value again.",
			accept: "Please enter a value with a valid extension.",
			maxlength: $.validator.format("Please enter no more than {0} characters."),
			minlength: $.validator.format("Please enter at least {0} characters."),
			rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
			range: $.validator.format("Please enter a value between {0} and {1}."),
			max: $.validator.format("Please enter a value less than or equal to {0}."),
			min: $.validator.format("Please enter a value greater than or equal to {0}.")
		},

		autoCreateRanges: false,

		prototype: {

			init: function init() {
				this.labelContainer = $(this.settings.errorLabelContainer);
				this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm);
				this.containers = $(this.settings.errorContainer).add(this.settings.errorLabelContainer);
				this.submitted = {};
				this.valueCache = {};
				this.pendingRequest = 0;
				this.pending = {};
				this.invalid = {};
				this.reset();

				var groups = this.groups = {};
				$.each(this.settings.groups, function (key, value) {
					$.each(value.split(/\s/), function (index, name) {
						groups[name] = key;
					});
				});
				var rules = this.settings.rules;
				$.each(rules, function (key, value) {
					rules[key] = $.validator.normalizeRule(value);
				});

				function delegate(event) {
					var validator = $.data(this[0].form, "validator"),
					    eventType = "on" + event.type.replace(/^validate/, "");
					validator.settings[eventType] && validator.settings[eventType].call(validator, this[0], event);
				}
				$(this.currentForm).validateDelegate("[type='text'], [type='password'], [type='file'], select, textarea, " + "[type='number'], [type='search'] ,[type='tel'], [type='url'], " + "[type='email'], [type='datetime'], [type='date'], [type='month'], " + "[type='week'], [type='time'], [type='datetime-local'], " + "[type='range'], [type='color'] ", "focusin focusout keyup", delegate).validateDelegate("[type='radio'], [type='checkbox'], select, option", "click", delegate);

				if (this.settings.invalidHandler) $(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
			},

			// http://docs.jquery.com/Plugins/Validation/Validator/form
			form: function form() {
				this.checkForm();
				$.extend(this.submitted, this.errorMap);
				this.invalid = $.extend({}, this.errorMap);
				if (!this.valid()) $(this.currentForm).triggerHandler("invalid-form", [this]);
				this.showErrors();
				return this.valid();
			},

			checkForm: function checkForm() {
				this.prepareForm();
				for (var i = 0, elements = this.currentElements = this.elements(); elements[i]; i++) {
					this.check(elements[i]);
				}
				return this.valid();
			},

			// http://docs.jquery.com/Plugins/Validation/Validator/element
			element: function element(_element) {
				_element = this.validationTargetFor(this.clean(_element));
				this.lastElement = _element;
				this.prepareElement(_element);
				this.currentElements = $(_element);
				var result = this.check(_element);
				if (result) {
					delete this.invalid[_element.name];
				} else {
					this.invalid[_element.name] = true;
				}
				if (!this.numberOfInvalids()) {
					// Hide error containers on last error
					this.toHide = this.toHide.add(this.containers);
				}
				this.showErrors();
				return result;
			},

			// http://docs.jquery.com/Plugins/Validation/Validator/showErrors
			showErrors: function showErrors(errors) {
				if (errors) {
					// add items to error list and map
					$.extend(this.errorMap, errors);
					this.errorList = [];
					for (var name in errors) {
						this.errorList.push({
							message: errors[name],
							element: this.findByName(name)[0]
						});
					}
					// remove items from success list
					this.successList = $.grep(this.successList, function (element) {
						return !(element.name in errors);
					});
				}
				this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors();
			},

			// http://docs.jquery.com/Plugins/Validation/Validator/resetForm
			resetForm: function resetForm() {
				if ($.fn.resetForm) $(this.currentForm).resetForm();
				this.submitted = {};
				this.lastElement = null;
				this.prepareForm();
				this.hideErrors();
				this.elements().removeClass(this.settings.errorClass);
			},

			numberOfInvalids: function numberOfInvalids() {
				return this.objectLength(this.invalid);
			},

			objectLength: function objectLength(obj) {
				var count = 0;
				for (var i in obj) {
					count++;
				}return count;
			},

			hideErrors: function hideErrors() {
				this.addWrapper(this.toHide).hide();
			},

			valid: function valid() {
				return this.size() == 0;
			},

			size: function size() {
				return this.errorList.length;
			},

			focusInvalid: function focusInvalid() {
				if (this.settings.focusInvalid) {
					try {
						$(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus()
						// manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
						.trigger("focusin");
					} catch (e) {
						// ignore IE throwing errors when focusing hidden elements
					}
				}
			},

			findLastActive: function findLastActive() {
				var lastActive = this.lastActive;
				return lastActive && $.grep(this.errorList, function (n) {
					return n.element.name == lastActive.name;
				}).length == 1 && lastActive;
			},

			elements: function elements() {
				var validator = this,
				    rulesCache = {};

				// select all valid inputs inside the form (no submit or reset buttons)
				return $(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function () {
					!this.name && validator.settings.debug && window.console && console.error("%o has no name assigned", this);

					// select only the first element for each name, and only those with rules specified
					if (this.name in rulesCache || !validator.objectLength($(this).rules())) return false;

					rulesCache[this.name] = true;
					return true;
				});
			},

			clean: function clean(selector) {
				return $(selector)[0];
			},

			errors: function errors() {
				return $(this.settings.errorElement + "." + this.settings.errorClass, this.errorContext);
			},

			reset: function reset() {
				this.successList = [];
				this.errorList = [];
				this.errorMap = {};
				this.toShow = $([]);
				this.toHide = $([]);
				this.currentElements = $([]);
			},

			prepareForm: function prepareForm() {
				this.reset();
				this.toHide = this.errors().add(this.containers);
			},

			prepareElement: function prepareElement(element) {
				this.reset();
				this.toHide = this.errorsFor(element);
			},

			check: function check(element) {
				element = this.validationTargetFor(this.clean(element));

				var rules = $(element).rules();
				var dependencyMismatch = false;
				for (var method in rules) {
					var rule = { method: method, parameters: rules[method] };
					try {
						var result = $.validator.methods[method].call(this, element.value.replace(/\r/g, ""), element, rule.parameters);

						// if a method indicates that the field is optional and therefore valid,
						// don't mark it as valid when there are no other rules
						if (result == "dependency-mismatch") {
							dependencyMismatch = true;
							continue;
						}
						dependencyMismatch = false;

						if (result == "pending") {
							this.toHide = this.toHide.not(this.errorsFor(element));
							return;
						}

						if (!result) {
							this.formatAndAdd(element, rule);
							return false;
						}
					} catch (e) {
						this.settings.debug && window.console && console.log("exception occured when checking element " + element.id + ", check the '" + rule.method + "' method", e);
						throw e;
					}
				}
				if (dependencyMismatch) return;
				if (this.objectLength(rules)) this.successList.push(element);
				return true;
			},

			// return the custom message for the given element and validation method
			// specified in the element's "messages" metadata
			customMetaMessage: function customMetaMessage(element, method) {
				if (!$.metadata) return;

				var meta = this.settings.meta ? $(element).metadata()[this.settings.meta] : $(element).metadata();

				return meta && meta.messages && meta.messages[method];
			},

			// return the custom message for the given element name and validation method
			customMessage: function customMessage(name, method) {
				var m = this.settings.messages[name];
				return m && (m.constructor == String ? m : m[method]);
			},

			// return the first defined argument, allowing empty strings
			findDefined: function findDefined() {
				for (var i = 0; i < arguments.length; i++) {
					if (arguments[i] !== undefined) return arguments[i];
				}
				return undefined;
			},

			defaultMessage: function defaultMessage(element, method) {
				return this.findDefined(this.customMessage(element.name, method), this.customMetaMessage(element, method),
				// title is never undefined, so handle empty string as undefined
				!this.settings.ignoreTitle && element.title || undefined, $.validator.messages[method], "<strong>Warning: No message defined for " + element.name + "</strong>");
			},

			formatAndAdd: function formatAndAdd(element, rule) {
				var message = this.defaultMessage(element, rule.method),
				    theregex = /\$?\{(\d+)\}/g;
				if (typeof message == "function") {
					message = message.call(this, rule.parameters, element);
				} else if (theregex.test(message)) {
					message = jQuery.format(message.replace(theregex, '{$1}'), rule.parameters);
				}
				this.errorList.push({
					message: message,
					element: element
				});

				this.errorMap[element.name] = message;
				this.submitted[element.name] = message;
			},

			addWrapper: function addWrapper(toToggle) {
				if (this.settings.wrapper) toToggle = toToggle.add(toToggle.parent(this.settings.wrapper));
				return toToggle;
			},

			defaultShowErrors: function defaultShowErrors() {
				for (var i = 0; this.errorList[i]; i++) {
					var error = this.errorList[i];
					this.settings.highlight && this.settings.highlight.call(this, error.element, this.settings.errorClass, this.settings.validClass);
					this.showLabel(error.element, error.message);
				}
				if (this.errorList.length) {
					this.toShow = this.toShow.add(this.containers);
				}
				if (this.settings.success) {
					for (var i = 0; this.successList[i]; i++) {
						this.showLabel(this.successList[i]);
					}
				}
				if (this.settings.unhighlight) {
					for (var i = 0, elements = this.validElements(); elements[i]; i++) {
						this.settings.unhighlight.call(this, elements[i], this.settings.errorClass, this.settings.validClass);
					}
				}
				this.toHide = this.toHide.not(this.toShow);
				this.hideErrors();
				this.addWrapper(this.toShow).show();
			},

			validElements: function validElements() {
				return this.currentElements.not(this.invalidElements());
			},

			invalidElements: function invalidElements() {
				return $(this.errorList).map(function () {
					return this.element;
				});
			},

			showLabel: function showLabel(element, message) {
				var label = this.errorsFor(element);
				if (label.length) {
					// refresh error/success class
					label.removeClass(this.settings.validClass).addClass(this.settings.errorClass);

					// check if we have a generated label, replace the message then
					label.attr("generated") && label.html(message);
				} else {
					// create label
					label = $("<" + this.settings.errorElement + "/>").attr({ "for": this.idOrName(element), generated: true }).addClass(this.settings.errorClass).html(message || "");
					if (this.settings.wrapper) {
						// make sure the element is visible, even in IE
						// actually showing the wrapped element is handled elsewhere
						label = label.hide().show().wrap("<" + this.settings.wrapper + "/>").parent();
					}
					if (!this.labelContainer.append(label).length) this.settings.errorPlacement ? this.settings.errorPlacement(label, $(element)) : label.insertAfter(element);
				}
				if (!message && this.settings.success) {
					label.text("");
					typeof this.settings.success == "string" ? label.addClass(this.settings.success) : this.settings.success(label);
				}
				this.toShow = this.toShow.add(label);
			},

			errorsFor: function errorsFor(element) {
				var name = this.idOrName(element);
				return this.errors().filter(function () {
					return $(this).attr('for') == name;
				});
			},

			idOrName: function idOrName(element) {
				return this.groups[element.name] || (this.checkable(element) ? element.name : element.id || element.name);
			},

			validationTargetFor: function validationTargetFor(element) {
				// if radio/checkbox, validate first element in group instead
				if (this.checkable(element)) {
					element = this.findByName(element.name).not(this.settings.ignore)[0];
				}
				return element;
			},

			checkable: function checkable(element) {
				return (/radio|checkbox/i.test(element.type)
				);
			},

			findByName: function findByName(name) {
				// select by name and filter by form for performance over form.find("[name=...]")
				var form = this.currentForm;
				return $(document.getElementsByName(name)).map(function (index, element) {
					return element.form == form && element.name == name && element || null;
				});
			},

			getLength: function getLength(value, element) {
				switch (element.nodeName.toLowerCase()) {
					case 'select':
						return $("option:selected", element).length;
					case 'input':
						if (this.checkable(element)) return this.findByName(element.name).filter(':checked').length;
				}
				return value.length;
			},

			depend: function depend(param, element) {
				return this.dependTypes[typeof param === 'undefined' ? 'undefined' : _typeof(param)] ? this.dependTypes[typeof param === 'undefined' ? 'undefined' : _typeof(param)](param, element) : true;
			},

			dependTypes: {
				"boolean": function boolean(param, element) {
					return param;
				},
				"string": function string(param, element) {
					return !!$(param, element.form).length;
				},
				"function": function _function(param, element) {
					return param(element);
				}
			},

			optional: function optional(element) {
				return !$.validator.methods.required.call(this, $.trim(element.value), element) && "dependency-mismatch";
			},

			startRequest: function startRequest(element) {
				if (!this.pending[element.name]) {
					this.pendingRequest++;
					this.pending[element.name] = true;
				}
			},

			stopRequest: function stopRequest(element, valid) {
				this.pendingRequest--;
				// sometimes synchronization fails, make sure pendingRequest is never < 0
				if (this.pendingRequest < 0) this.pendingRequest = 0;
				delete this.pending[element.name];
				if (valid && this.pendingRequest == 0 && this.formSubmitted && this.form()) {
					$(this.currentForm).submit();
					this.formSubmitted = false;
				} else if (!valid && this.pendingRequest == 0 && this.formSubmitted) {
					$(this.currentForm).triggerHandler("invalid-form", [this]);
					this.formSubmitted = false;
				}
			},

			previousValue: function previousValue(element) {
				return $.data(element, "previousValue") || $.data(element, "previousValue", {
					old: null,
					valid: true,
					message: this.defaultMessage(element, "remote")
				});
			}

		},

		classRuleSettings: {
			required: { required: true },
			email: { email: true },
			url: { url: true },
			date: { date: true },
			dateISO: { dateISO: true },
			dateDE: { dateDE: true },
			number: { number: true },
			numberDE: { numberDE: true },
			digits: { digits: true },
			creditcard: { creditcard: true }
		},

		addClassRules: function addClassRules(className, rules) {
			className.constructor == String ? this.classRuleSettings[className] = rules : $.extend(this.classRuleSettings, className);
		},

		classRules: function classRules(element) {
			var rules = {};
			var classes = $(element).attr('class');
			classes && $.each(classes.split(' '), function () {
				if (this in $.validator.classRuleSettings) {
					$.extend(rules, $.validator.classRuleSettings[this]);
				}
			});
			return rules;
		},

		attributeRules: function attributeRules(element) {
			var rules = {};
			var $element = $(element);

			for (var method in $.validator.methods) {
				var value;
				// If .prop exists (jQuery >= 1.6), use it to get true/false for required
				if (method === 'required' && typeof $.fn.prop === 'function') {
					value = $element.prop(method);
				} else {
					value = $element.attr(method);
				}
				if (value) {
					rules[method] = value;
				} else if ($element[0].getAttribute("type") === method) {
					rules[method] = true;
				}
			}

			// maxlength may be returned as -1, 2147483647 (IE) and 524288 (safari) for text inputs
			if (rules.maxlength && /-1|2147483647|524288/.test(rules.maxlength)) {
				delete rules.maxlength;
			}

			return rules;
		},

		metadataRules: function metadataRules(element) {
			if (!$.metadata) return {};

			var meta = $.data(element.form, 'validator').settings.meta;
			return meta ? $(element).metadata()[meta] : $(element).metadata();
		},

		staticRules: function staticRules(element) {
			var rules = {};
			var validator = $.data(element.form, 'validator');
			if (validator.settings.rules) {
				rules = $.validator.normalizeRule(validator.settings.rules[element.name]) || {};
			}
			return rules;
		},

		normalizeRules: function normalizeRules(rules, element) {
			// handle dependency check
			$.each(rules, function (prop, val) {
				// ignore rule when param is explicitly false, eg. required:false
				if (val === false) {
					delete rules[prop];
					return;
				}
				if (val.param || val.depends) {
					var keepRule = true;
					switch (_typeof(val.depends)) {
						case "string":
							keepRule = !!$(val.depends, element.form).length;
							break;
						case "function":
							keepRule = val.depends.call(element, element);
							break;
					}
					if (keepRule) {
						rules[prop] = val.param !== undefined ? val.param : true;
					} else {
						delete rules[prop];
					}
				}
			});

			// evaluate parameters
			$.each(rules, function (rule, parameter) {
				rules[rule] = $.isFunction(parameter) ? parameter(element) : parameter;
			});

			// clean number parameters
			$.each(['minlength', 'maxlength', 'min', 'max'], function () {
				if (rules[this]) {
					rules[this] = Number(rules[this]);
				}
			});
			$.each(['rangelength', 'range'], function () {
				if (rules[this]) {
					rules[this] = [Number(rules[this][0]), Number(rules[this][1])];
				}
			});

			if ($.validator.autoCreateRanges) {
				// auto-create ranges
				if (rules.min && rules.max) {
					rules.range = [rules.min, rules.max];
					delete rules.min;
					delete rules.max;
				}
				if (rules.minlength && rules.maxlength) {
					rules.rangelength = [rules.minlength, rules.maxlength];
					delete rules.minlength;
					delete rules.maxlength;
				}
			}

			// To support custom messages in metadata ignore rule methods titled "messages"
			if (rules.messages) {
				delete rules.messages;
			}

			return rules;
		},

		// Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
		normalizeRule: function normalizeRule(data) {
			if (typeof data == "string") {
				var transformed = {};
				$.each(data.split(/\s/), function () {
					transformed[this] = true;
				});
				data = transformed;
			}
			return data;
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/addMethod
		addMethod: function addMethod(name, method, message) {
			$.validator.methods[name] = method;
			$.validator.messages[name] = message != undefined ? message : $.validator.messages[name];
			if (method.length < 3) {
				$.validator.addClassRules(name, $.validator.normalizeRule(name));
			}
		},

		methods: {

			// http://docs.jquery.com/Plugins/Validation/Methods/required
			required: function required(value, element, param) {
				// check if dependency is met
				if (!this.depend(param, element)) return "dependency-mismatch";
				switch (element.nodeName.toLowerCase()) {
					case 'select':
						// could be an array for select-multiple or a string, both are fine this way
						var val = $(element).val();
						return val && val.length > 0;
					case 'input':
						if (this.checkable(element)) return this.getLength(value, element) > 0;
					default:
						return $.trim(value).length > 0;
				}
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/remote
			remote: function remote(value, element, param) {
				if (this.optional(element)) return "dependency-mismatch";

				var previous = this.previousValue(element);
				if (!this.settings.messages[element.name]) this.settings.messages[element.name] = {};
				previous.originalMessage = this.settings.messages[element.name].remote;
				this.settings.messages[element.name].remote = previous.message;

				param = typeof param == "string" && { url: param } || param;

				if (this.pending[element.name]) {
					return "pending";
				}
				if (previous.old === value) {
					return previous.valid;
				}

				previous.old = value;
				var validator = this;
				this.startRequest(element);
				var data = {};
				data[element.name] = value;
				$.ajax($.extend(true, {
					url: param,
					mode: "abort",
					port: "validate" + element.name,
					dataType: "json",
					data: data,
					success: function success(response) {
						validator.settings.messages[element.name].remote = previous.originalMessage;
						var valid = response === true;
						if (valid) {
							var submitted = validator.formSubmitted;
							validator.prepareElement(element);
							validator.formSubmitted = submitted;
							validator.successList.push(element);
							validator.showErrors();
						} else {
							var errors = {};
							var message = response || validator.defaultMessage(element, "remote");
							errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
							validator.showErrors(errors);
						}
						previous.valid = valid;
						validator.stopRequest(element, valid);
					}
				}, param));
				return "pending";
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/minlength
			minlength: function minlength(value, element, param) {
				return this.optional(element) || this.getLength($.trim(value), element) >= param;
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/maxlength
			maxlength: function maxlength(value, element, param) {
				return this.optional(element) || this.getLength($.trim(value), element) <= param;
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/rangelength
			rangelength: function rangelength(value, element, param) {
				var length = this.getLength($.trim(value), element);
				return this.optional(element) || length >= param[0] && length <= param[1];
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/min
			min: function min(value, element, param) {
				return this.optional(element) || value >= param;
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/max
			max: function max(value, element, param) {
				return this.optional(element) || value <= param;
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/range
			range: function range(value, element, param) {
				return this.optional(element) || value >= param[0] && value <= param[1];
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/email
			email: function email(value, element) {
				// contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/url
			url: function url(value, element) {
				// contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
				return this.optional(element) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/date
			date: function date(value, element) {
				return this.optional(element) || !/Invalid|NaN/.test(new Date(value));
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/dateISO
			dateISO: function dateISO(value, element) {
				return this.optional(element) || /^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(value);
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/number
			number: function number(value, element) {
				return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/digits
			digits: function digits(value, element) {
				return this.optional(element) || /^\d+$/.test(value);
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/creditcard
			// based on http://en.wikipedia.org/wiki/Luhn
			creditcard: function creditcard(value, element) {
				if (this.optional(element)) return "dependency-mismatch";
				// accept only spaces, digits and dashes
				if (/[^0-9 -]+/.test(value)) return false;
				var nCheck = 0,
				    nDigit = 0,
				    bEven = false;

				value = value.replace(/\D/g, "");

				for (var n = value.length - 1; n >= 0; n--) {
					var cDigit = value.charAt(n);
					var nDigit = parseInt(cDigit, 10);
					if (bEven) {
						if ((nDigit *= 2) > 9) nDigit -= 9;
					}
					nCheck += nDigit;
					bEven = !bEven;
				}

				return nCheck % 10 == 0;
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/accept
			accept: function accept(value, element, param) {
				param = typeof param == "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
				return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
			},

			// http://docs.jquery.com/Plugins/Validation/Methods/equalTo
			equalTo: function equalTo(value, element, param) {
				// bind to the blur event of the target in order to revalidate whenever the target field is updated
				// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
				var target = $(param).unbind(".validate-equalTo").bind("blur.validate-equalTo", function () {
					$(element).valid();
				});
				return value == target.val();
			}

		}

	});

	// deprecated, use $.validator.format instead
	$.format = $.validator.format;
})(jQuery);

// ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort()
;(function ($) {
	var pendingRequests = {};
	// Use a prefilter if available (1.5+)
	if ($.ajaxPrefilter) {
		$.ajaxPrefilter(function (settings, _, xhr) {
			var port = settings.port;
			if (settings.mode == "abort") {
				if (pendingRequests[port]) {
					pendingRequests[port].abort();
				}
				pendingRequests[port] = xhr;
			}
		});
	} else {
		// Proxy ajax
		var ajax = $.ajax;
		$.ajax = function (settings) {
			var mode = ("mode" in settings ? settings : $.ajaxSettings).mode,
			    port = ("port" in settings ? settings : $.ajaxSettings).port;
			if (mode == "abort") {
				if (pendingRequests[port]) {
					pendingRequests[port].abort();
				}
				return pendingRequests[port] = ajax.apply(this, arguments);
			}
			return ajax.apply(this, arguments);
		};
	}
})(jQuery);

// provides cross-browser focusin and focusout events
// IE has native support, in other browsers, use event caputuring (neither bubbles)

// provides delegate(type: String, delegate: Selector, handler: Callback) plugin for easier event delegation
// handler is only called when $(event.target).is(delegate), in the scope of the jquery-object for event.target
;(function ($) {
	// only implement if not provided by jQuery core (since 1.4)
	// TODO verify if jQuery 1.4's implementation is compatible with older jQuery special-event APIs
	if (!jQuery.event.special.focusin && !jQuery.event.special.focusout && document.addEventListener) {
		$.each({
			focus: 'focusin',
			blur: 'focusout'
		}, function (original, fix) {
			$.event.special[fix] = {
				setup: function setup() {
					this.addEventListener(original, handler, true);
				},
				teardown: function teardown() {
					this.removeEventListener(original, handler, true);
				},
				handler: function handler(e) {
					arguments[0] = $.event.fix(e);
					arguments[0].type = fix;
					return $.event.handle.apply(this, arguments);
				}
			};
			function handler(e) {
				e = $.event.fix(e);
				e.type = fix;
				return $.event.handle.call(this, e);
			}
		});
	};
	$.extend($.fn, {
		validateDelegate: function validateDelegate(delegate, type, handler) {
			return this.bind(type, function (event) {
				var target = $(event.target);
				if (target.is(delegate)) {
					return handler.apply(target, arguments);
				}
			});
		}
	});
})(jQuery);

/***/ }),
/* 17 */
/***/ (function(module, exports) {


$(document).ready(function () {

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	// Form Validation
	$("#basic_validate").validate({
		rules: {
			required: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			date: {
				required: true,
				date: true
			},
			url: {
				required: true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight: function highlight(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function unhighlight(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#number_validate").validate({
		rules: {
			min: {
				required: true,
				min: 10
			},
			max: {
				required: true,
				max: 24
			},
			number: {
				required: true,
				number: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight: function highlight(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function unhighlight(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#password_validate").validate({
		rules: {
			pwd: {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			pwd2: {
				required: true,
				minlength: 6,
				maxlength: 20,
				equalTo: "#pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight: function highlight(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function unhighlight(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});

/***/ }),
/* 18 */
/***/ (function(module, exports) {

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

$(function () {
  $("#example, #example2, #example3, #example4").popover();
});

!function ($) {
  "use strict";

  var Popover = function Popover(element, options) {
    this.init('popover', element, options);
  };
  /* NOTE: POPOVER EXTENDS BOOTSTRAP-TOOLTIP.js
  ========================================== */
  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype, {
    constructor: Popover,
    setContent: function setContent() {
      var $tip = this.tip(),
          title = this.getTitle(),
          content = this.getContent();
      $tip.find('.popover-title')[$.type(title) == 'object' ? 'append' : 'html'](title);
      $tip.find('.popover-content > *')[$.type(content) == 'object' ? 'append' : 'html'](content);
      $tip.removeClass('fade top bottom left right in');
    },
    hasContent: function hasContent() {
      return this.getTitle() || this.getContent();
    },
    getContent: function getContent() {
      var content,
          $e = this.$element,
          o = this.options;
      content = $e.attr('data-content') || (typeof o.content == 'function' ? o.content.call($e[0]) : o.content);
      content = content.toString().replace(/(^\s*|\s*$)/, "");
      return content;
    },
    tip: function tip() {
      if (!this.$tip) {
        this.$tip = $(this.options.template);
      }
      return this.$tip;
    }
  });
  /* POPOVER PLUGIN DEFINITION
  * ======================= */
  $.fn.popover = function (option) {
    return this.each(function () {
      var $this = $(this),
          data = $this.data('popover'),
          options = (typeof option === "undefined" ? "undefined" : _typeof(option)) == 'object' && option;
      if (!data) $this.data('popover', data = new Popover(this, options));
      if (typeof option == 'string') data[option]();
    });
  };
  $.fn.popover.Constructor = Popover;
  $.fn.popover.defaults = $.extend({}, $.fn.tooltip.defaults, {
    placement: 'right',
    content: '',
    template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
  });
}(window.jQuery);

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)();
exports.push([module.i, "// removed by extract-text-webpack-plugin", ""]);

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)();
exports.push([module.i, "// removed by extract-text-webpack-plugin", ""]);

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)();
exports.push([module.i, "// removed by extract-text-webpack-plugin", ""]);

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(4);
__webpack_require__(10);
__webpack_require__(11);
module.exports = __webpack_require__(9);


/***/ })
/******/ ]);