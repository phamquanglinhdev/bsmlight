!function (t, e) {
    if ("object" == typeof exports && "object" == typeof module) module.exports = e(); else if ("function" == typeof define && define.amd) define([], e); else {
        var i = e();
        for (var a in i) ("object" == typeof exports ? exports : t)[a] = i[a]
    }
}(self, (function () {
    return function () {
        var t = {
            88483: function (t, e, i) {
                "use strict";
                var a = i(23645), s = i.n(a)()((function (t) {
                    return t[1]
                }));
                s.push([t.id, '#template-customizer{background:#fff;box-shadow:0 4px 18px 0 rgba(58,53,65,.14);display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;font-family:Open Sans,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol!important;font-size:inherit!important;height:100%;position:fixed;right:0;top:0;-webkit-transform:translateX(420px);transform:translateX(420px);transition:all .2s ease-in;width:400px;z-index:99999999}.dark-style #template-customizer{box-shadow:0 4px 18px 0 rgba(19,17,32,.2)}#template-customizer h5{font-size:11px;position:relative}#template-customizer>h5{-ms-flex:0 0 auto;flex:0 0 auto}#template-customizer .disabled{color:#d1d2d3!important}#template-customizer .form-label{font-size:.9375rem}#template-customizer .form-check-label{font-size:.8125rem}#template-customizer .template-customizer-t-panel_header{font-size:1.125rem}#template-customizer.template-customizer-open{-webkit-transform:none!important;transform:none!important;transition-delay:.1s}#template-customizer.template-customizer-open .custom-option.checked{border-width:2px;color:var(--bs-primary)}#template-customizer.template-customizer-open .custom-option.checked .custom-option-content{border:none}#template-customizer.template-customizer-open .custom-option .custom-option-content{border:1px solid transparent}#template-customizer .template-customizer-header a:hover{color:inherit!important}#template-customizer .template-customizer-open-btn{background:var(--bs-primary);border-bottom-left-radius:15%;border-top-left-radius:15%;color:#fff!important;display:block;font-size:18px!important;height:42px;left:0;line-height:42px;opacity:1;position:absolute;text-align:center;top:180px;-webkit-transform:translateX(-62px);transform:translateX(-62px);transition:all .1s linear .2s;width:42px;z-index:-1}@media (max-width:991.98px){#template-customizer .template-customizer-open-btn{top:145px}}.dark-style #template-customizer .template-customizer-open-btn{background:var(--bs-primary)}#template-customizer .template-customizer-open-btn:before{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAABClJREFUaEPtmY1RFEEQhbsjUCIQIhAiUCNQIxAiECIQIxAiECIAIpAMhAiECIQI2vquZqnZvp6fhb3SK5mqq6Ju92b69bzXf6is+dI1t1+eAfztG5z1BsxsU0S+ici2iPB3vm5E5EpEDlSVv2dZswFIxv8UkZcNy+5EZGcuEHMCOBeR951uvVDVD53vVl+bE8DvDu8Pxtyo6ta/BsByg1R15Bwzqz5/LJgn34CZwfnPInI4BUB6/1hV0cSjVxcAM4PbcBZjL0XklIPN7Is3fLCkdQPpPYw/VNXj5IhPIvJWRIhSl6p60ULWBGBm30Vk123EwRxCuIzWkkjNrCZywith10ewE1Xdq4GoAjCz/RTXW44Ynt+LyBEfT43kYfbj86J3w5Q32DNcRQDpwF+dkQXDMey8xem0L3TEqB4g3PZWad8agBMRgZPeu96D1/C2Zbh3X0p80Op1xxloztN48bMQQNoc7+eLEuAoPSPiIDY4Ooo+E6ixeNXM+D3GERz2U3CIqMstLJUgJQDe+7eq6mub0NYEkLAKwEHkiBQDCZtddZCZ8d6r7JDwFkoARklHRPZUFVDVZWbwGuNrC4EfdOzFrRABh3Wnqhv+d70AEBLGFROPmeHlnM81G69UdSd6IUuM0GgUVn1uqWmg5EmMfBeEyB7Pe3txBkY+rGT8j0J+WXq/BgDkUCaqLgEAnwcRog0veMIqFAAwCy2wnw+bI2GaGboBgF9k5N0o0rUSGUb4eO0BeO9j/GYhkSHMHMTIqwGARX6p6a+nlPBl8kZuXMD9j6pKfF9aZuaFOdJCEL5D4eYb9wCYVCanrBmGyii/tIq+SLj/HQBCaM5bLzwfPqdQ6FpVHyra4IbuVbXaY7dETC2ESPNNWiIOi69CcdgSMXsh4tNSUiklMgwmC0aNd08Y5WAES6HHehM4gu97wyhBgWpgqXsrASglprDy7CwhehMZOSbK6JMSma+Fio1KltCmlBIj7gfZOGx8ppQSXrhzFnOhJ/31BDkjFHRvOd09x0mRBA9SFgxUgHpQg0q0t5ymPMlL+EnldFTfDA0NAmf+OTQ0X0sRouf7NNkYGhrOYNrxtIaGg83MNzVDSe3LXLhP7O/yrCsCz1zlWTpjWkuZAOBpX3yVnLqI1yLCOKU6qMrmP7SSrUEw54XF4WBIK5FxCMOr3lVsfGqNSmPzBXUnJTIX1jyVBq9wO6UObOpgC5GjO98vFKnTdQMZXxEsWZlDiCZMIxAbNxQOqlpVZtobejBaZNoBnRDzMFpkxvTQOD36BlrcySZuI6p1ACB6LU3wWuf5581+oHfD1vi89bz3nFUC8Nm7ZlP3nKkFbM4bWPt/MSFwklprYItwt6cmvpWJ2IVcQBCz6bLysSCv3SaANCiTsnaNRrNRqMXVVT1/BrAqz/buu/Y38Ad3KC5PARej0QAAAABJRU5ErkJggg==");background-size:100% 100%;content:"";display:block;height:22px;margin:10px;position:absolute;width:22px}.customizer-hide #template-customizer .template-customizer-open-btn{display:none}[dir=rtl] #template-customizer .template-customizer-open-btn{border-radius:0;border-bottom-right-radius:15%;border-top-right-radius:15%}[dir=rtl] #template-customizer .template-customizer-open-btn:before{margin-left:-2px}#template-customizer.template-customizer-open .template-customizer-open-btn{opacity:0;-webkit-transform:none!important;transform:none!important;transition-delay:0s}#template-customizer .template-customizer-inner{-ms-flex:0 1 auto;flex:0 1 auto;opacity:1;overflow:auto;position:relative;transition:opacity .2s}#template-customizer .template-customizer-inner>div:first-child>hr:first-of-type{display:none!important}#template-customizer .template-customizer-inner>div:first-child>h5:first-of-type{padding-top:0!important}#template-customizer .template-customizer-themes-inner{opacity:1;position:relative;transition:opacity .2s}#template-customizer .template-customizer-theme-item{-ms-flex-align:center;-ms-flex-pack:justify;align-items:center;cursor:pointer;display:-ms-flexbox;display:flex;-ms-flex:1 1 100%;flex:1 1 100%;justify-content:space-between;margin-bottom:10px;padding:0 24px;width:100%}#template-customizer .template-customizer-theme-item input{opacity:0;position:absolute;z-index:-1}#template-customizer .template-customizer-theme-item input~span{opacity:.25;transition:all .2s}#template-customizer .template-customizer-theme-item .template-customizer-theme-checkmark{border-bottom:1px solid;border-right:1px solid;display:inline-block;height:12px;opacity:0;-webkit-transform:rotate(45deg);transform:rotate(45deg);transition:all .2s;width:6px}[dir=rtl] #template-customizer .template-customizer-theme-item .template-customizer-theme-checkmark{border-left:1px solid;border-right:none;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}#template-customizer .template-customizer-theme-item input:checked:not([disabled])~span,#template-customizer .template-customizer-theme-item input:checked:not([disabled])~span .template-customizer-theme-checkmark,#template-customizer .template-customizer-theme-item:hover input:not([disabled])~span{opacity:1}#template-customizer .template-customizer-theme-colors span{border-radius:50%;box-shadow:inset 0 0 0 1px rgba(0,0,0,.1);display:block;height:10px;margin:0 1px;width:10px}#template-customizer.template-customizer-loading .template-customizer-inner,#template-customizer.template-customizer-loading-theme .template-customizer-themes-inner{opacity:.2}#template-customizer.template-customizer-loading .template-customizer-inner:after,#template-customizer.template-customizer-loading-theme .template-customizer-themes-inner:after{bottom:0;content:"";display:block;left:0;position:absolute;right:0;top:0;z-index:999}@media (max-width:1200px){#template-customizer{display:none;visibility:hidden!important}}@media (max-width:575.98px){#template-customizer{-webkit-transform:translateX(320px);transform:translateX(320px);width:300px}}.layout-menu-100vh #template-customizer{height:100vh}[dir=rtl] #template-customizer{left:0;right:auto;-webkit-transform:translateX(-420px);transform:translateX(-420px)}[dir=rtl] #template-customizer .template-customizer-open-btn{left:auto;right:0;-webkit-transform:translateX(62px);transform:translateX(62px)}[dir=rtl] #template-customizer .template-customizer-close-btn{left:0;right:auto}#template-customizer .template-customizer-layouts-options[disabled]{opacity:.5;pointer-events:none}[dir=rtl] .template-customizer-t-style_switch_light{padding-right:0!important}', ""]), e.Z = s
            }, 23645: function (t) {
                "use strict";
                t.exports = function (t) {
                    var e = [];
                    return e.toString = function () {
                        return this.map((function (e) {
                            var i = t(e);
                            return e[2] ? "@media ".concat(e[2], " {").concat(i, "}") : i
                        })).join("")
                    }, e.i = function (t, i, a) {
                        "string" == typeof t && (t = [[null, t, ""]]);
                        var s = {};
                        if (a) for (var n = 0; n < this.length; n++) {
                            var o = this[n][0];
                            null != o && (s[o] = !0)
                        }
                        for (var r = 0; r < t.length; r++) {
                            var l = [].concat(t[r]);
                            a && s[l[0]] || (i && (l[2] ? l[2] = "".concat(i, " and ").concat(l[2]) : l[2] = i), e.push(l))
                        }
                    }, e
                }
            }, 32950: function (t) {
                t.exports = '<div id="template-customizer" class="invert-bg-white"> <a href="javascript:void(0)" class="template-customizer-open-btn" tabindex="-1"></a> <div class="p-4 m-0 lh-1 border-bottom template-customizer-header position-relative py-3"> <h4 class="template-customizer-t-panel_header mb-2"></h4> <p class="template-customizer-t-panel_sub_header mb-0"></p> <div class="d-flex align-items-center gap-2 position-absolute end-0 top-0 mt-4 me-3"> <a href="javascript:void(0)" class="template-customizer-reset-btn text-body" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reset Customizer"><i class="mdi mdi-cached mdi-20px"></i><span class="badge rounded-pill bg-danger badge-dot badge-notifications d-none"></span></a> <a href="javascript:void(0)" class="template-customizer-close-btn fw-light text-body" tabindex="-1"> <i class="mdi mdi-close mdi-20px"></i> </a> </div> </div> <div class="template-customizer-inner pt-4"> <div class="template-customizer-theming"> <h5 class="m-0 px-4 py-4 lh-1 d-block"> <span class="template-customizer-t-theming_header bg-label-primary rounded-1 py-1 px-2 fs-big"></span> </h5> <div class="m-0 px-4 pb-3 pt-1 template-customizer-style w-100"> <label for="customizerStyle" class="form-label d-block template-customizer-t-style_label"></label> <div class="row px-1 template-customizer-styles-options"></div> </div> <div class="m-0 px-4 pt-3 template-customizer-themes w-100"> <label for="customizerTheme" class="form-label template-customizer-t-theme_label"></label> <div class="row px-1 template-customizer-themes-options"></div> </div> </div> <div class="template-customizer-layout"> <hr class="m-0 px-4 my-4"/> <h5 class="m-0 px-4 pb-4 pt-2 d-block"> <span class="template-customizer-t-layout_header bg-label-primary rounded-1 py-1 px-2 fs-big"></span> </h5> <div class="m-0 px-4 pb-3 d-block template-customizer-layouts"> <label for="customizerStyle" class="form-label d-block template-customizer-t-layout_label"></label> <div class="row px-1 template-customizer-layouts-options"> </div> </div> <div class="m-0 px-4 pb-3 template-customizer-headerOptions w-100"> <label for="customizerHeader" class="form-label template-customizer-t-layout_header_label"></label> <div class="row px-1 template-customizer-header-options"></div> </div> <div class="m-0 px-4 pb-3 template-customizer-layoutNavbarOptions w-100"> <label for="customizerNavbar" class="form-label template-customizer-t-layout_navbar_label"></label> <div class="row px-1 template-customizer-navbar-options"></div> </div> <div class="m-0 px-4 pb-3 template-customizer-content w-100"> <label for="customizerContent" class="form-label template-customizer-t-content_label"></label> <div class="row px-1 template-customizer-content-options"></div> </div> <div class="m-0 px-4 pb-3 template-customizer-directions w-100"> <label for="customizerDirection" class="form-label template-customizer-t-direction_label"></label> <div class="row px-1 template-customizer-directions-options"></div> </div> </div> </div> </div> '
            }, 93379: function (t, e, i) {
                "use strict";
                var a, s = function () {
                    return void 0 === a && (a = Boolean(window && document && document.all && !window.atob)), a
                }, n = function () {
                    var t = {};
                    return function (e) {
                        if (void 0 === t[e]) {
                            var i = document.querySelector(e);
                            if (window.HTMLIFrameElement && i instanceof window.HTMLIFrameElement) try {
                                i = i.contentDocument.head
                            } catch (t) {
                                i = null
                            }
                            t[e] = i
                        }
                        return t[e]
                    }
                }(), o = [];

                function r(t) {
                    for (var e = -1, i = 0; i < o.length; i++) if (o[i].identifier === t) {
                        e = i;
                        break
                    }
                    return e
                }

                function l(t, e) {
                    for (var i = {}, a = [], s = 0; s < t.length; s++) {
                        var n = t[s], l = e.base ? n[0] + e.base : n[0], c = i[l] || 0, u = "".concat(l, " ").concat(c);
                        i[l] = c + 1;
                        var d = r(u), m = {css: n[1], media: n[2], sourceMap: n[3]};
                        -1 !== d ? (o[d].references++, o[d].updater(m)) : o.push({
                            identifier: u,
                            updater: v(m, e),
                            references: 1
                        }), a.push(u)
                    }
                    return a
                }

                function c(t) {
                    var e = document.createElement("style"), a = t.attributes || {};
                    if (void 0 === a.nonce) {
                        var s = i.nc;
                        s && (a.nonce = s)
                    }
                    if (Object.keys(a).forEach((function (t) {
                        e.setAttribute(t, a[t])
                    })), "function" == typeof t.insert) t.insert(e); else {
                        var o = n(t.insert || "head");
                        if (!o) throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
                        o.appendChild(e)
                    }
                    return e
                }

                var u, d = (u = [], function (t, e) {
                    return u[t] = e, u.filter(Boolean).join("\n")
                });

                function m(t, e, i, a) {
                    var s = i ? "" : a.media ? "@media ".concat(a.media, " {").concat(a.css, "}") : a.css;
                    if (t.styleSheet) t.styleSheet.cssText = d(e, s); else {
                        var n = document.createTextNode(s), o = t.childNodes;
                        o[e] && t.removeChild(o[e]), o.length ? t.insertBefore(n, o[e]) : t.appendChild(n)
                    }
                }

                function h(t, e, i) {
                    var a = i.css, s = i.media, n = i.sourceMap;
                    if (s ? t.setAttribute("media", s) : t.removeAttribute("media"), n && "undefined" != typeof btoa && (a += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(n)))), " */")), t.styleSheet) t.styleSheet.cssText = a; else {
                        for (; t.firstChild;) t.removeChild(t.firstChild);
                        t.appendChild(document.createTextNode(a))
                    }
                }

                var p = null, y = 0;

                function v(t, e) {
                    var i, a, s;
                    if (e.singleton) {
                        var n = y++;
                        i = p || (p = c(e)), a = m.bind(null, i, n, !1), s = m.bind(null, i, n, !0)
                    } else i = c(e), a = h.bind(null, i, e), s = function () {
                        !function (t) {
                            if (null === t.parentNode) return !1;
                            t.parentNode.removeChild(t)
                        }(i)
                    };
                    return a(t), function (e) {
                        if (e) {
                            if (e.css === t.css && e.media === t.media && e.sourceMap === t.sourceMap) return;
                            a(t = e)
                        } else s()
                    }
                }

                t.exports = function (t, e) {
                    (e = e || {}).singleton || "boolean" == typeof e.singleton || (e.singleton = s());
                    var i = l(t = t || [], e);
                    return function (t) {
                        if (t = t || [], "[object Array]" === Object.prototype.toString.call(t)) {
                            for (var a = 0; a < i.length; a++) {
                                var s = r(i[a]);
                                o[s].references--
                            }
                            for (var n = l(t, e), c = 0; c < i.length; c++) {
                                var u = r(i[c]);
                                0 === o[u].references && (o[u].updater(), o.splice(u, 1))
                            }
                            i = n
                        }
                    }
                }
            }
        }, e = {};

        function i(a) {
            var s = e[a];
            if (void 0 !== s) return s.exports;
            var n = e[a] = {id: a, exports: {}};
            return t[a](n, n.exports, i), n.exports
        }

        i.n = function (t) {
            var e = t && t.__esModule ? function () {
                return t.default
            } : function () {
                return t
            };
            return i.d(e, {a: e}), e
        }, i.d = function (t, e) {
            for (var a in e) i.o(e, a) && !i.o(t, a) && Object.defineProperty(t, a, {enumerable: !0, get: e[a]})
        }, i.o = function (t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }, i.r = function (t) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(t, "__esModule", {value: !0})
        }, i.nc = void 0;
        var a = {};
        return function () {
            "use strict";
            i.r(a), i.d(a, {
                TemplateCustomizer: function () {
                    return w
                }
            });
            var t = i(93379), e = i.n(t), s = i(88483), n = {insert: "head", singleton: !1},
                o = (e()(s.Z, n), s.Z.locals, i(32950)), r = i.n(o);

            function l(t) {
                return l = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
                    return typeof t
                } : function (t) {
                    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
                }, l(t)
            }

            function c(t, e) {
                for (var i = 0; i < e.length; i++) {
                    var a = e[i];
                    a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), Object.defineProperty(t, u(a.key), a)
                }
            }

            function u(t) {
                var e = function (t, e) {
                    if ("object" !== l(t) || null === t) return t;
                    var i = t[Symbol.toPrimitive];
                    if (void 0 !== i) {
                        var a = i.call(t, e || "default");
                        if ("object" !== l(a)) return a;
                        throw new TypeError("@@toPrimitive must return a primitive value.")
                    }
                    return ("string" === e ? String : Number)(t)
                }(t, "string");
                return "symbol" === l(e) ? e : String(e)
            }

            var d,
                m = ["rtl", "style", "headerType", "contentLayout", "layoutCollapsed", "showDropdownOnHover", "layoutNavbarOptions", "layoutFooterFixed", "themes"],
                h = ["light", "dark", "system"], p = ["sticky", "static", "hidden"],
                y = document.documentElement.classList;
            d = y.contains("layout-navbar-fixed") ? "sticky" : y.contains("layout-navbar-hidden") ? "hidden" : "static";
            var v = document.getElementsByTagName("HTML")[0].getAttribute("data-theme") || 0,
                f = y.contains("dark-style") ? "dark" : "light",
                g = "rtl" === document.documentElement.getAttribute("dir"), b = !!y.contains("layout-menu-collapsed"),
                _ = d, z = y.contains("layout-wide") ? "wide" : "compact", S = !!y.contains("layout-footer-fixed"),
                x = y.contains("layout-menu-offcanvas") ? "static-offcanvas" : y.contains("layout-menu-fixed") ? "fixed" : y.contains("layout-menu-fixed-offcanvas") ? "fixed-offcanvas" : "static",
                w = function () {
                    function t(e) {
                        var i = e.cssPath, a = e.themesPath, s = e.cssFilenamePattern, n = e.displayCustomizer,
                            o = e.controls, r = e.defaultTextDir, l = e.defaultHeaderType, c = e.defaultContentLayout,
                            u = e.defaultMenuCollapsed, d = e.defaultShowDropdownOnHover, y = e.defaultNavbarType,
                            w = e.defaultFooterFixed, C = e.styles, k = e.navbarOptions, T = e.defaultStyle,
                            N = e.availableContentLayouts, L = e.availableDirections, A = e.availableStyles,
                            O = e.availableThemes, E = e.availableLayouts, I = e.availableHeaderTypes,
                            F = e.availableNavbarOptions, D = e.defaultTheme, q = e.pathResolver,
                            H = e.onSettingsChange, M = e.lang;
                        if (function (t, e) {
                            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                        }(this, t), !this._ssr) {
                            if (!window.Helpers) throw new Error("window.Helpers required.");
                            if (this.settings = {}, this.settings.cssPath = i, this.settings.themesPath = a, this.settings.cssFilenamePattern = s || "%name%.css", this.settings.displayCustomizer = void 0 === n || n, this.settings.controls = o || m, this.settings.defaultTextDir = "rtl" === r || g, this.settings.defaultHeaderType = l || x, this.settings.defaultMenuCollapsed = void 0 !== u ? u : b, this.settings.defaultContentLayout = void 0 !== c ? c : z, this.settings.defaultShowDropdownOnHover = void 0 === d || d, this.settings.defaultNavbarType = void 0 !== y ? y : _, this.settings.defaultFooterFixed = void 0 !== w ? w : S, this.settings.availableDirections = L || t.DIRECTIONS, this.settings.availableStyles = A || t.STYLES, this.settings.availableThemes = O || t.THEMES, this.settings.availableHeaderTypes = I || t.HEADER_TYPES, this.settings.availableContentLayouts = N || t.CONTENT, this.settings.availableLayouts = E || t.LAYOUTS, this.settings.availableNavbarOptions = F || t.NAVBAR_OPTIONS, this.settings.defaultTheme = this._getDefaultTheme(void 0 !== D ? D : v), this.settings.styles = C || h, this.settings.navbarOptions = k || p, this.settings.defaultStyle = T || f, this.settings.lang = M || "en", this.pathResolver = q || function (t) {
                                return t
                            }, this.settings.styles.length < 2) {
                                var B = this.settings.controls.indexOf("style");
                                -1 !== B && (this.settings.controls = this.settings.controls.slice(0, B).concat(this.settings.controls.slice(B + 1)))
                            }
                            this.settings.onSettingsChange = "function" == typeof H ? H : function () {
                            }, this._loadSettings(), this._listeners = [], this._controls = {}, this._initDirection(), this._initStyle(), this._initTheme(), this.setLayoutType(this.settings.headerType, !1), this.setContentLayout(this.settings.contentLayout, !1), this.setDropdownOnHover(this.settings.showDropdownOnHover, !1), this.setLayoutNavbarOption(this.settings.layoutNavbarOptions, !1), this.setLayoutFooterFixed(this.settings.layoutFooterFixed, !1), this._setup()
                        }
                    }

                    var e, i, a;
                    return e = t, i = [{
                        key: "setRtl", value: function (t) {
                            this._hasControls("rtl") && (this._setSetting("Rtl", String(t)), window.location.reload())
                        }
                    }, {
                        key: "setContentLayout", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            this._hasControls("contentLayout") && (this.settings.contentLayout = t, e && this._setSetting("contentLayout", t), window.Helpers.setContentLayout(t), e && this.settings.onSettingsChange.call(this, this.settings))
                        }
                    }, {
                        key: "setStyle", value: function (t) {
                            this._setSetting("Style", t), window.location.reload()
                        }
                    }, {
                        key: "setTheme", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1],
                                i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null;
                            if (this._hasControls("themes")) {
                                var a = this._getThemeByName(t);
                                if (a) {
                                    this.settings.theme = a, e && this._setSetting("Theme", t);
                                    var s, n, o,
                                        r = this.pathResolver(this.settings.themesPath + this.settings.cssFilenamePattern.replace("%name%", t + ("light" !== this.settings.style ? "-".concat(this.settings.style) : "")));
                                    this._loadStylesheets((s = {}, n = r, o = document.querySelector(".template-customizer-theme-css"), (n = u(n)) in s ? Object.defineProperty(s, n, {
                                        value: o,
                                        enumerable: !0,
                                        configurable: !0,
                                        writable: !0
                                    }) : s[n] = o, s), i || function () {
                                    }), e && this.settings.onSettingsChange.call(this, this.settings)
                                }
                            }
                        }
                    }, {
                        key: "setLayoutType", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            if (this._hasControls("headerType") && ("static" === t || "static-offcanvas" === t || "fixed" === t || "fixed-offcanvas" === t)) {
                                this.settings.headerType = t, e && this._setSetting("LayoutType", t), window.Helpers.setPosition("fixed" === t || "fixed-offcanvas" === t, "static-offcanvas" === t || "fixed-offcanvas" === t), e && this.settings.onSettingsChange.call(this, this.settings);
                                var i = window.Helpers.menuPsScroll, a = window.PerfectScrollbar;
                                "fixed" === this.settings.headerType || "fixed-offcanvas" === this.settings.headerType ? a && i && (window.Helpers.menuPsScroll.destroy(), i = new a(document.querySelector(".menu-inner"), {
                                    suppressScrollX: !0,
                                    wheelPropagation: !1
                                }), window.Helpers.menuPsScroll = i) : i && window.Helpers.menuPsScroll.destroy()
                            }
                        }
                    }, {
                        key: "setDropdownOnHover", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            if (this._hasControls("showDropdownOnHover")) {
                                if (this.settings.showDropdownOnHover = t, e && this._setSetting("ShowDropdownOnHover", t), window.Helpers.mainMenu) {
                                    window.Helpers.mainMenu.destroy(), config.showDropdownOnHover = t;
                                    var i = window.Menu;
                                    window.Helpers.mainMenu = new i(document.getElementById("layout-menu"), {
                                        orientation: "horizontal",
                                        closeChildren: !0,
                                        showDropdownOnHover: config.showDropdownOnHover
                                    })
                                }
                                e && this.settings.onSettingsChange.call(this, this.settings)
                            }
                        }
                    }, {
                        key: "setLayoutNavbarOption", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            this._hasControls("layoutNavbarOptions") && (this.settings.layoutNavbarOptions = t, e && this._setSetting("FixedNavbarOption", t), window.Helpers.setNavbar(t), e && this.settings.onSettingsChange.call(this, this.settings))
                        }
                    }, {
                        key: "setLayoutFooterFixed", value: function (t) {
                            var e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
                            this.settings.layoutFooterFixed = t, e && this._setSetting("FixedFooter", t), window.Helpers.setFooterFixed(t), e && this.settings.onSettingsChange.call(this, this.settings)
                        }
                    }, {
                        key: "setLang", value: function (e) {
                            var i = this, a = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                            if (e !== this.settings.lang || a) {
                                if (!t.LANGUAGES[e]) throw new Error('Language "'.concat(e, '" not found!'));
                                var s = t.LANGUAGES[e];
                                ["panel_header", "panel_sub_header", "theming_header", "style_label", "style_switch_light", "style_switch_dark", "layout_header", "layout_label", "layout_header_label", "content_label", "layout_static", "layout_offcanvas", "layout_fixed", "layout_fixed_offcanvas", "layout_dd_open_label", "layout_navbar_label", "layout_footer_label", "misc_header", "theme_label", "direction_label"].forEach((function (t) {
                                    var e = i.container.querySelector(".template-customizer-t-".concat(t));
                                    e && (e.textContent = s[t])
                                }));
                                for (var n = s.themes || {}, o = this.container.querySelectorAll(".template-customizer-theme-item") || [], r = 0, l = o.length; r < l; r++) {
                                    var c = o[r].querySelector('input[type="radio"]').value;
                                    o[r].querySelector(".template-customizer-theme-name").textContent = n[c] || this._getThemeByName(c).title
                                }
                                this.settings.lang = e
                            }
                        }
                    }, {
                        key: "update", value: function () {
                            if (!this._ssr) {
                                var t = !!document.querySelector(".layout-navbar"),
                                    e = !!document.querySelector(".layout-menu"),
                                    i = !!document.querySelector(".layout-menu-horizontal.menu, .layout-menu-horizontal .menu"),
                                    a = (document.querySelector(".layout-wrapper.layout-navbar-full"), !!document.querySelector(".content-footer"));
                                this._controls.showDropdownOnHover && (e ? (this._controls.showDropdownOnHover.setAttribute("disabled", "disabled"), this._controls.showDropdownOnHover.classList.add("disabled")) : (this._controls.showDropdownOnHover.removeAttribute("disabled"), this._controls.showDropdownOnHover.classList.remove("disabled"))), this._controls.layoutNavbarOptions && (t ? (this._controls.layoutNavbarOptions.removeAttribute("disabled"), this._controls.layoutNavbarOptionsW.classList.remove("disabled")) : (this._controls.layoutNavbarOptions.setAttribute("disabled", "disabled"), this._controls.layoutNavbarOptionsW.classList.add("disabled")), i && t && "fixed" === this.settings.headerType && (this._controls.layoutNavbarOptions.setAttribute("disabled", "disabled"), this._controls.layoutNavbarOptionsW.classList.add("disabled"))), this._controls.layoutFooterFixed && (a ? (this._controls.layoutFooterFixed.removeAttribute("disabled"), this._controls.layoutFooterFixedW.classList.remove("disabled")) : (this._controls.layoutFooterFixed.setAttribute("disabled", "disabled"), this._controls.layoutFooterFixedW.classList.add("disabled"))), this._controls.headerType && (e || i ? this._controls.headerType.removeAttribute("disabled") : this._controls.headerType.setAttribute("disabled", "disabled"))
                            }
                        }
                    }, {
                        key: "clearLocalStorage", value: function () {
                            if (!this._ssr) {
                                var t = this._getLayoutName();
                                ["Theme", "Style", "LayoutCollapsed", "FixedNavbarOption", "LayoutType", "contentLayout", "Rtl"].forEach((function (e) {
                                    var i = "templateCustomizer-".concat(t, "--").concat(e);
                                    localStorage.removeItem(i)
                                })), this._showResetBtnNotification(!1)
                            }
                        }
                    }, {
                        key: "destroy", value: function () {
                            this._ssr || (this._cleanup(), this.settings = null, this.container.parentNode.removeChild(this.container), this.container = null)
                        }
                    }, {
                        key: "_loadSettings", value: function () {
                            var t, e, i = this._getSetting("Rtl"), a = this._getSetting("Style"),
                                s = this._getSetting("Theme"), n = this._getSetting("contentLayout"),
                                o = this._getSetting("LayoutCollapsed"), r = this._getSetting("ShowDropdownOnHover"),
                                l = this._getSetting("FixedNavbarOption"), c = this._getSetting("FixedFooter"),
                                u = this._getSetting("LayoutType");
                            "" !== i || "" !== a || "" !== s || "" !== n || "" !== o || "" !== l || "" !== u ? this._showResetBtnNotification(!0) : this._showResetBtnNotification(!1), t = "" !== u && -1 !== ["static", "static-offcanvas", "fixed", "fixed-offcanvas"].indexOf(u) ? u : this.settings.defaultHeaderType, this.settings.headerType = t, this.settings.rtl = "" !== i ? "true" === i : this.settings.defaultTextDir, this.settings.stylesOpt = -1 !== this.settings.styles.indexOf(a) ? a : this.settings.defaultStyle, "system" === this.settings.stylesOpt ? window.matchMedia("(prefers-color-scheme: dark)").matches ? (this.settings.style = "dark", document.cookie = "style=dark") : (this.settings.style = "light", document.cookie = "style=light") : (document.cookie = "style=; expires=Thu, 01 Jan 2000 00:00:00 UTC; path=/;", this.settings.style = -1 !== this.settings.styles.indexOf(a) ? a : this.settings.defaultStyle), -1 === this.settings.styles.indexOf(this.settings.style) && (this.settings.style = this.settings.styles[0]), this.settings.contentLayout = "" !== n ? n : this.settings.defaultContentLayout, this.settings.layoutCollapsed = "" !== o ? "true" === o : this.settings.defaultMenuCollapsed, this.settings.showDropdownOnHover = "" !== r ? "true" === r : this.settings.defaultShowDropdownOnHover, e = "" !== l && -1 !== ["static", "sticky", "hidden"].indexOf(l) ? l : this.settings.defaultNavbarType, this.settings.layoutNavbarOptions = e, this.settings.layoutFooterFixed = "" !== c ? "true" === c : this.settings.defaultFooterFixed, this.settings.theme = this._getThemeByName(this._getSetting("Theme"), !0), this._hasControls("rtl") || (this.settings.rtl = "rtl" === document.documentElement.getAttribute("dir")), this._hasControls("style") || (this.settings.style = y.contains("dark-style") ? "dark" : "light"), this._hasControls("contentLayout") || (this.settings.contentLayout = null), this._hasControls("headerType") || (this.settings.headerType = null), this._hasControls("layoutCollapsed") || (this.settings.layoutCollapsed = null), this._hasControls("layoutNavbarOptions") || (this.settings.layoutNavbarOptions = null), this._hasControls("themes") || (this.settings.theme = null)
                        }
                    }, {
                        key: "_setup", value: function () {
                            var t = this, e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : document,
                                i = function (e, i, a, s, n) {
                                    return n = n || e, t._getElementFromString('<div class="col-4 px-2">\n        <div class="form-check custom-option custom-option-icon">\n        <label class="form-check-label custom-option-content p-0" for="'.concat(a).concat(e, '">\n          <span class="custom-option-body mb-0">\n            <img src="').concat(assetsPath, "img/customizer/").concat(n).concat(s ? "-dark" : "", '.svg" alt="').concat(i, '" class="img-fluid scaleX-n1-rtl" />\n          </span>\n          <input\n            name="').concat(a, '"\n            class="form-check-input d-none"\n            type="radio"\n            value="').concat(e, '"\n            id="').concat(a).concat(e, '" />\n        </label>\n      </div>\n      <label class="form-check-label small" for="').concat(a).concat(e, '">').concat(i, "</label>\n    </div>"))
                                };
                            this._cleanup(), this.container = this._getElementFromString(r());
                            var a = this.container;
                            this.settings.displayCustomizer ? a.setAttribute("style", "visibility: visible") : a.setAttribute("style", "visibility: hidden");
                            var s = this.container.querySelector(".template-customizer-open-btn"), n = function () {
                                t.container.classList.add("template-customizer-open"), t.update(), t._updateInterval && clearInterval(t._updateInterval), t._updateInterval = setInterval((function () {
                                    t.update()
                                }), 500)
                            };
                            s.addEventListener("click", n), this._listeners.push([s, "click", n]);
                            var o = this.container.querySelector(".template-customizer-reset-btn"), l = function () {
                                t.clearLocalStorage(), window.location.reload()
                            };
                            o.addEventListener("click", l), this._listeners.push([o, "click", l]);
                            var c = this.container.querySelector(".template-customizer-close-btn"), u = function () {
                                t.container.classList.remove("template-customizer-open"), t._updateInterval && (clearInterval(t._updateInterval), t._updateInterval = null)
                            };
                            c.addEventListener("click", u), this._listeners.push([c, "click", u]);
                            var d = this.container.querySelector(".template-customizer-style"),
                                m = d.querySelector(".template-customizer-styles-options");
                            if (this._hasControls("style")) {
                                this.settings.availableStyles.forEach((function (t) {
                                    var e = i(t.name, t.title, "customRadioIcon", y.contains("dark-style"));
                                    m.appendChild(e)
                                })), m.querySelector('input[value="'.concat(this.settings.stylesOpt, '"]')).setAttribute("checked", "checked");
                                var h = function (e) {
                                    t._loadingState(!0), t.setStyle(e.target.value, !0, (function () {
                                        t._loadingState(!1)
                                    }))
                                };
                                m.addEventListener("change", h), this._listeners.push([m, "change", h])
                            } else d.parentNode.removeChild(d);
                            var p = this.container.querySelector(".template-customizer-themes"),
                                v = p.querySelector(".template-customizer-themes-options");
                            if (this._hasControls("themes")) {
                                this.settings.availableThemes.forEach((function (t) {
                                    var e = "";
                                    e = "theme-semi-dark" === t.name ? "semi-dark" : "theme-bordered" === t.name ? "border" : "default";
                                    var a = i(t.name, t.title, "themeRadios", y.contains("dark-style"), e);
                                    v.appendChild(a)
                                })), v.querySelector('input[value="'.concat(this.settings.theme.name, '"]')).setAttribute("checked", "checked");
                                var f = function (e) {
                                    t._loading = !0, t._loadingState(!0, !0), t.setTheme(e.target.value, !0, (function () {
                                        t._loading = !1, t._loadingState(!1, !0)
                                    }))
                                };
                                v.addEventListener("change", f), this._listeners.push([v, "change", f])
                            } else p.parentNode.removeChild(p);
                            var g = this.container.querySelector(".template-customizer-theming");
                            this._hasControls("style") || this._hasControls("themes") || g.parentNode.removeChild(g);
                            var b = this.container.querySelector(".template-customizer-layout");
                            if (this._hasControls("rtl headerType contentLayout layoutCollapsed layoutNavbarOptions", !0)) {
                                var _ = this.container.querySelector(".template-customizer-directions");
                                if (this._hasControls("rtl") && rtlSupport) {
                                    var z = _.querySelector(".template-customizer-directions-options");
                                    this.settings.availableDirections.forEach((function (t) {
                                        var e = i(t.name, t.title, "directionRadioIcon", y.contains("dark-style"));
                                        z.appendChild(e)
                                    })), z.querySelector('input[value="'.concat(this.settings.rtl ? "rtl" : "ltr", '"]')).setAttribute("checked", "checked");
                                    var S = function (e) {
                                        t._loadingState(!0), t.setRtl("rtl" === e.target.value, !0, (function () {
                                            t._loadingState(!1)
                                        }))
                                    };
                                    z.addEventListener("change", S), this._listeners.push([z, "change", S])
                                } else _.parentNode.removeChild(_);
                                var x = this.container.querySelector(".template-customizer-headerOptions"),
                                    w = document.documentElement.getAttribute("data-template").split("-");
                                if (this._hasControls("headerType")) {
                                    var C = x.querySelector(".template-customizer-header-options");
                                    setTimeout((function () {
                                        w.includes("vertical") && x.parentNode.removeChild(x)
                                    }), 100), this.settings.availableHeaderTypes.forEach((function (t) {
                                        var e = i(t.name, t.title, "headerRadioIcon", y.contains("dark-style"), "horizontal-".concat(t.name));
                                        C.appendChild(e)
                                    })), C.querySelector('input[value="'.concat(this.settings.headerType, '"]')).setAttribute("checked", "checked");
                                    var k = function (e) {
                                        t.setLayoutType(e.target.value)
                                    };
                                    C.addEventListener("change", k), this._listeners.push([C, "change", k])
                                } else x.parentNode.removeChild(x);
                                var T = this.container.querySelector(".template-customizer-content");
                                if (this._hasControls("contentLayout")) {
                                    var N = T.querySelector(".template-customizer-content-options");
                                    this.settings.availableContentLayouts.forEach((function (t) {
                                        var e = i(t.name, t.title, "contentRadioIcon", y.contains("dark-style"));
                                        N.appendChild(e)
                                    })), N.querySelector('input[value="'.concat(this.settings.contentLayout, '"]')).setAttribute("checked", "checked");
                                    var L = function (e) {
                                        t._loading = !0, t._loadingState(!0, !0), t.setContentLayout(e.target.value, !0, (function () {
                                            t._loading = !1, t._loadingState(!1, !0)
                                        }))
                                    };
                                    N.addEventListener("change", L), this._listeners.push([N, "change", L])
                                } else T.parentNode.removeChild(T);
                                var A = this.container.querySelector(".template-customizer-layouts");
                                if (this._hasControls("layoutCollapsed")) {
                                    setTimeout((function () {
                                        document.querySelector(".layout-menu-horizontal") && A.parentNode.removeChild(A)
                                    }), 100);
                                    var O = A.querySelector(".template-customizer-layouts-options");
                                    this.settings.availableLayouts.forEach((function (t) {
                                        var e = i(t.name, t.title, "layoutsRadios", y.contains("dark-style"));
                                        O.appendChild(e)
                                    })), O.querySelector('input[value="'.concat(this.settings.layoutCollapsed ? "collapsed" : "expanded", '"]')).setAttribute("checked", "checked");
                                    var E = function (e) {
                                        window.Helpers.setCollapsed("collapsed" === e.target.value, !0), t._setSetting("LayoutCollapsed", "collapsed" === e.target.value)
                                    };
                                    O.addEventListener("change", E), this._listeners.push([O, "change", E])
                                } else A.parentNode.removeChild(A);
                                var I = this.container.querySelector(".template-customizer-layoutNavbarOptions");
                                if (this._hasControls("layoutNavbarOptions")) {
                                    setTimeout((function () {
                                        w.includes("horizontal") && I.parentNode.removeChild(I)
                                    }), 100);
                                    var F = I.querySelector(".template-customizer-navbar-options");
                                    this.settings.availableNavbarOptions.forEach((function (t) {
                                        var e = i(t.name, t.title, "navbarOptionRadios", y.contains("dark-style"));
                                        F.appendChild(e)
                                    })), F.querySelector('input[value="'.concat(this.settings.layoutNavbarOptions, '"]')).setAttribute("checked", "checked");
                                    var D = function (e) {
                                        t._loading = !0, t._loadingState(!0, !0), t.setLayoutNavbarOption(e.target.value, !0, (function () {
                                            t._loading = !1, t._loadingState(!1, !0)
                                        }))
                                    };
                                    F.addEventListener("change", D), this._listeners.push([F, "change", D])
                                } else I.parentNode.removeChild(I)
                            } else b.parentNode.removeChild(b);
                            setTimeout((function () {
                                var e = t.container.querySelector(".template-customizer-layout");
                                document.querySelector(".menu-vertical") ? t._hasControls("rtl contentLayout layoutCollapsed layoutNavbarOptions", !0) || e && e.parentNode.removeChild(e) : document.querySelector(".menu-horizontal") && (t._hasControls("rtl contentLayout headerType", !0) || e && e.parentNode.removeChild(e))
                            }), 100), this.setLang(this.settings.lang, !0), e === document ? e.body ? e.body.appendChild(this.container) : window.addEventListener("DOMContentLoaded", (function () {
                                return e.body.appendChild(t.container)
                            })) : e.appendChild(this.container)
                        }
                    }, {
                        key: "_initDirection", value: function () {
                            this._hasControls("rtl") && document.documentElement.setAttribute("dir", this.settings.rtl ? "rtl" : "ltr")
                        }
                    }, {
                        key: "_initStyle", value: function () {
                            if (this._hasControls("style")) {
                                var t = this.settings.style;
                                this._insertStylesheet("template-customizer-core-css", this.pathResolver(this.settings.cssPath + this.settings.cssFilenamePattern.replace("%name%", "core".concat("light" !== t ? "-".concat(t) : "")))), ("light" === t ? ["dark-style"] : ["light-style"]).forEach((function (t) {
                                    document.documentElement.classList.remove(t)
                                })), document.documentElement.classList.add("".concat(t, "-style"))
                            }
                        }
                    }, {
                        key: "_initTheme", value: function () {
                            if (this._hasControls("themes")) this._insertStylesheet("template-customizer-theme-css", this.pathResolver(this.settings.themesPath + this.settings.cssFilenamePattern.replace("%name%", this.settings.theme.name + ("light" !== this.settings.style ? "-".concat(this.settings.style) : "")))); else {
                                var t = this._getSetting("Theme");
                                this._insertStylesheet("template-customizer-theme-css", this.pathResolver(this.settings.themesPath + this.settings.cssFilenamePattern.replace("%name%", t || "theme-default" + ("light" !== this.settings.style ? "-".concat(this.settings.style) : ""))))
                            }
                        }
                    }, {
                        key: "_insertStylesheet", value: function (t, e) {
                            var i = document.querySelector(".".concat(t));
                            if ("number" == typeof document.documentMode && document.documentMode < 11) {
                                if (!i) return;
                                if (e === i.getAttribute("href")) return;
                                var a = document.createElement("link");
                                a.setAttribute("rel", "stylesheet"), a.setAttribute("type", "text/css"), a.className = t, a.setAttribute("href", e), i.parentNode.insertBefore(a, i.nextSibling)
                            } else document.write('<link rel="stylesheet" type="text/css" href="'.concat(e, '" class="').concat(t, '">'));
                            i.parentNode.removeChild(i)
                        }
                    }, {
                        key: "_loadStylesheets", value: function (t, e) {
                            var i = Object.keys(t), a = i.length, s = 0;

                            function n(t, e, i) {
                                var a = document.createElement("link");
                                a.setAttribute("href", t), a.setAttribute("rel", "stylesheet"), a.setAttribute("type", "text/css"), a.className = e.className;
                                var s, n = "sheet" in a ? "sheet" : "styleSheet",
                                    o = "sheet" in a ? "cssRules" : "rules", r = setTimeout((function () {
                                        clearInterval(s), clearTimeout(r), e.parentNode.removeChild(a), i(!1, t)
                                    }), 15e3);
                                s = setInterval((function () {
                                    try {
                                        a[n] && a[n][o].length && (clearInterval(s), clearTimeout(r), e.parentNode.removeChild(e), i(!0))
                                    } catch (t) {
                                    }
                                }), 10), e.parentNode.insertBefore(a, e.nextSibling)
                            }

                            for (var o = 0; o < i.length; o++) n(i[o], t[i[o]], void ((s += 1) >= a && e()))
                        }
                    }, {
                        key: "_loadingState", value: function (t, e) {
                            this.container.classList[t ? "add" : "remove"]("template-customizer-loading".concat(e ? "-theme" : ""))
                        }
                    }, {
                        key: "_getElementFromString", value: function (t) {
                            var e = document.createElement("div");
                            return e.innerHTML = t, e.firstChild
                        }
                    }, {
                        key: "_getSetting", value: function (t) {
                            var e = null, i = this._getLayoutName();
                            try {
                                e = localStorage.getItem("templateCustomizer-".concat(i, "--").concat(t))
                            } catch (t) {
                            }
                            return String(e || "")
                        }
                    }, {
                        key: "_showResetBtnNotification", value: function () {
                            var t = this, e = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];
                            setTimeout((function () {
                                var i = t.container.querySelector(".template-customizer-reset-btn .badge");
                                e ? i.classList.remove("d-none") : i.classList.add("d-none")
                            }), 200)
                        }
                    }, {
                        key: "_setSetting", value: function (t, e) {
                            var i = this._getLayoutName();
                            try {
                                localStorage.setItem("templateCustomizer-".concat(i, "--").concat(t), String(e)), this._showResetBtnNotification()
                            } catch (t) {
                            }
                        }
                    }, {
                        key: "_getLayoutName", value: function () {
                            return document.getElementsByTagName("HTML")[0].getAttribute("data-template")
                        }
                    }, {
                        key: "_removeListeners", value: function () {
                            for (var t = 0, e = this._listeners.length; t < e; t++) this._listeners[t][0].removeEventListener(this._listeners[t][1], this._listeners[t][2])
                        }
                    }, {
                        key: "_cleanup", value: function () {
                            this._removeListeners(), this._listeners = [], this._controls = {}, this._updateInterval && (clearInterval(this._updateInterval), this._updateInterval = null)
                        }
                    }, {
                        key: "_ssr", get: function () {
                            return "undefined" == typeof window
                        }
                    }, {
                        key: "_hasControls", value: function (t) {
                            var e = this, i = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                            return t.split(" ").reduce((function (t, a) {
                                return -1 !== e.settings.controls.indexOf(a) ? (i || !1 !== t) && (t = !0) : i && !0 === t || (t = !1), t
                            }), null)
                        }
                    }, {
                        key: "_getDefaultTheme", value: function (t) {
                            var e;
                            if (!(e = "string" == typeof t ? this._getThemeByName(t, !1) : this.settings.availableThemes[t])) throw new Error('Theme ID "'.concat(t, '" not found!'));
                            return e
                        }
                    }, {
                        key: "_getThemeByName", value: function (t) {
                            for (var e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1], i = this.settings.availableThemes, a = 0, s = i.length; a < s; a++) if (i[a].name === t) return i[a];
                            return e ? this.settings.defaultTheme : null
                        }
                    }], i && c(e.prototype, i), a && c(e, a), Object.defineProperty(e, "prototype", {writable: !1}), t
                }();
            w.STYLES = [{name: "light", title: "Light"}, {name: "dark", title: "Dark"}, {
                name: "system",
                title: "System"
            }], w.THEMES = [{name: "theme-default", title: "Default"}, {
                name: "theme-bordered",
                title: "Bordered"
            }, {name: "theme-semi-dark", title: "Semi Dark"}], w.LAYOUTS = [{
                name: "expanded",
                title: "Expanded"
            }, {name: "collapsed", title: "Collapsed"}], w.NAVBAR_OPTIONS = [{
                name: "sticky",
                title: "Sticky"
            }, {name: "static", title: "Static"}, {name: "hidden", title: "Hidden"}], w.HEADER_TYPES = [{
                name: "fixed",
                title: "Fixed"
            }, {name: "static", title: "Static"}], w.CONTENT = [{name: "compact", title: "Compact"}, {
                name: "wide",
                title: "Wide"
            }], w.DIRECTIONS = [{name: "ltr", title: "Left to Right"}, {
                name: "rtl",
                title: "Right to Left"
            }], w.LANGUAGES = {
                en: {
                    panel_header: "Template Customizer",
                    panel_sub_header: "Customize and preview in real time",
                    theming_header: "Theming",
                    style_label: "Style (Mode)",
                    theme_label: "Themes",
                    layout_header: "Layout",
                    layout_label: "Menu (Navigation)",
                    layout_header_label: "Header Types",
                    content_label: "Content",
                    layout_navbar_label: "Navbar Type",
                    direction_label: "Direction"
                },
                fr: {
                    panel_header: "Modèle De Personnalisation",
                    panel_sub_header: "Personnalisez et prévisualisez en temps réel",
                    theming_header: "Thématisation",
                    style_label: "Style (Mode)",
                    theme_label: "Thèmes",
                    layout_header: "Disposition",
                    layout_label: "Menu (Navigation)",
                    layout_header_label: "Types d'en-tête",
                    content_label: "Contenu",
                    layout_navbar_label: "Type de barre de navigation",
                    direction_label: "Direction"
                },
                ar: {
                    panel_header: "أداة تخصيص القالب",
                    panel_sub_header: "تخصيص ومعاينة في الوقت الحقيقي",
                    theming_header: "السمات",
                    style_label: "النمط (الوضع)",
                    theme_label: "المواضيع",
                    layout_header: "تَخطِيط",
                    layout_label: "القائمة (الملاحة)",
                    layout_header_label: "أنواع الرأس",
                    content_label: "محتوى",
                    layout_navbar_label: "نوع شريط التنقل",
                    direction_label: "اتجاه"
                },
                de: {
                    panel_header: "Vorlagen-Anpasser",
                    panel_sub_header: "Anpassen und Vorschau in Echtzeit",
                    theming_header: "Themen",
                    style_label: "Stil (Modus)",
                    theme_label: "Themen",
                    layout_header: "Layout",
                    layout_label: "Menü (Navigation)",
                    layout_header_label: "Header-Typen",
                    content_label: "Inhalt",
                    layout_navbar_label: "Art der Navigationsleiste",
                    direction_label: "Richtung"
                },
                pt: {
                    panel_header: "Personalizador De Modelo",
                    panel_sub_header: "Personalize e visualize em tempo real",
                    theming_header: "Temas",
                    style_label: "Estilo (Modo)",
                    theme_label: "Temas",
                    layout_header: "Esquema",
                    layout_label: "Menu (Navegação)",
                    layout_header_label: "Tipos de cabeçalho",
                    content_label: "Contente",
                    layout_navbar_label: "Tipo de barra de navegação",
                    direction_label: "Direção"
                }
            }
        }(), a
    }()
}));
