"use strict";
let menu, animate, isRtl = window.Helpers.isRtl(), isDarkStyle = window.Helpers.isDarkStyle(), isHorizontalLayout = !1;
document.getElementById("layout-menu") && (isHorizontalLayout = document.getElementById("layout-menu").classList.contains("menu-horizontal")), function () {
    function e() {
        var e = document.querySelector(".layout-page");
        e && (window.pageYOffset > 0 ? e.classList.add("window-scrolled") : e.classList.remove("window-scrolled"))
    }

    "undefined" != typeof Waves && (Waves.init(), Waves.attach(".btn[class*='btn-']:not(.position-relative):not([class*='btn-outline-']):not([class*='btn-label-'])", ["waves-light"]), Waves.attach("[class*='btn-outline-']:not(.position-relative)"), Waves.attach("[class*='btn-label-']:not(.position-relative)"), Waves.attach(".pagination .page-item .page-link"), Waves.attach(".dropdown-menu .dropdown-item"), Waves.attach(".light-style .list-group .list-group-item-action"), Waves.attach(".dark-style .list-group .list-group-item-action", ["waves-light"]), Waves.attach(".nav-tabs:not(.nav-tabs-widget) .nav-item .nav-link"), Waves.attach(".nav-pills .nav-item .nav-link", ["waves-light"]), Waves.attach(".menu-vertical .menu-item .menu-link.menu-toggle")), setTimeout((() => {
        e()
    }), 200), window.onscroll = function () {
        e()
    }, setTimeout((function () {
        window.Helpers.initCustomOptionCheck()
    }), 1e3), document.querySelectorAll("#layout-menu").forEach((function (e) {
        menu = new Menu(e, {
            orientation: isHorizontalLayout ? "horizontal" : "vertical",
            closeChildren: !!isHorizontalLayout,
            showDropdownOnHover: localStorage.getItem("templateCustomizer-" + templateName + "--ShowDropdownOnHover") ? "true" === localStorage.getItem("templateCustomizer-" + templateName + "--ShowDropdownOnHover") : void 0 === window.templateCustomizer || window.templateCustomizer.settings.defaultShowDropdownOnHover
        }), window.Helpers.scrollToActive(animate = !1), window.Helpers.mainMenu = menu
    })), document.querySelectorAll(".layout-menu-toggle").forEach((e => {
        e.addEventListener("click", (e => {
            if (e.preventDefault(), window.Helpers.toggleCollapsed(), config.enableMenuLocalStorage && !window.Helpers.isSmallScreen()) try {
                localStorage.setItem("templateCustomizer-" + templateName + "--LayoutCollapsed", String(window.Helpers.isCollapsed()));
                let e = document.querySelector(".template-customizer-layouts-options");
                if (e) {
                    let t = window.Helpers.isCollapsed() ? "collapsed" : "expanded";
                    e.querySelector(`input[value="${t}"]`).click()
                }
            } catch (e) {
            }
        }))
    })), window.Helpers.swipeIn(".drag-target", (function (e) {
        window.Helpers.setCollapsed(!1)
    })), window.Helpers.swipeOut("#layout-menu", (function (e) {
        window.Helpers.isSmallScreen() && window.Helpers.setCollapsed(!0)
    }));
    let t = document.getElementsByClassName("menu-inner"), a = document.getElementsByClassName("menu-inner-shadow")[0];
    t.length > 0 && a && t[0].addEventListener("ps-scroll-y", (function () {
        this.querySelector(".ps__thumb-y").offsetTop ? a.style.display = "block" : a.style.display = "none"
    }));
    let s = document.querySelector(".dropdown-style-switcher"),
        o = localStorage.getItem("templateCustomizer-" + templateName + "--Style") || (window.templateCustomizer?.settings?.defaultStyle ?? "light");
    if (window.templateCustomizer && s) {
        [].slice.call(s.children[1].querySelectorAll(".dropdown-item")).forEach((function (e) {
            e.addEventListener("click", (function () {
                let e = this.getAttribute("data-theme");
                "light" === e ? window.templateCustomizer.setStyle("light") : "dark" === e ? window.templateCustomizer.setStyle("dark") : window.templateCustomizer.setStyle("system")
            }))
        }));
        const e = s.querySelector("i");
        "light" === o ? (e.classList.add("mdi-weather-sunny"), new bootstrap.Tooltip(e, {
            title: "Light Mode",
            fallbackPlacements: ["bottom"]
        })) : "dark" === o ? (e.classList.add("mdi-weather-night"), new bootstrap.Tooltip(e, {
            title: "Dark Mode",
            fallbackPlacements: ["bottom"]
        })) : (e.classList.add("mdi-monitor"), new bootstrap.Tooltip(e, {
            title: "System Mode",
            fallbackPlacements: ["bottom"]
        }))
    }
    var n;
    "system" === (n = o) && (n = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"), [].slice.call(document.querySelectorAll("[data-app-" + n + "-img]")).map((function (e) {
        const t = e.getAttribute("data-app-" + n + "-img");
        e.src = assetsPath + "img/" + t
    }));
    const i = document.querySelector(".dropdown-notifications-all"),
        l = document.querySelectorAll(".dropdown-notifications-read");
    i && i.addEventListener("click", (e => {
        l.forEach((e => {
            e.closest(".dropdown-notifications-item").classList.add("marked-as-read")
        }))
    })), l && l.forEach((e => {
        e.addEventListener("click", (t => {
            e.closest(".dropdown-notifications-item").classList.toggle("marked-as-read")
        }))
    }));
    document.querySelectorAll(".dropdown-notifications-archive").forEach((e => {
        e.addEventListener("click", (t => {
            e.closest(".dropdown-notifications-item").remove()
        }))
    }));
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((function (e) {
        return new bootstrap.Tooltip(e)
    }));
    const r = function (e) {
        "show.bs.collapse" == e.type || "show.bs.collapse" == e.type ? e.target.closest(".accordion-item").classList.add("active") : e.target.closest(".accordion-item").classList.remove("active")
    };
    [].slice.call(document.querySelectorAll(".accordion")).map((function (e) {
        e.addEventListener("show.bs.collapse", r), e.addEventListener("hide.bs.collapse", r)
    }));
    window.Helpers.setAutoUpdate(!0), window.Helpers.initPasswordToggle(), window.Helpers.initSpeechToText(), window.Helpers.navTabsAnimation(), window.Helpers.initNavbarDropdownScrollbar();
    let d = document.querySelector("[data-template^='horizontal-menu']");
    if (d && (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? window.Helpers.setNavbarFixed("fixed") : window.Helpers.setNavbarFixed("")), window.addEventListener("resize", (function (e) {
        window.innerWidth >= window.Helpers.LAYOUT_BREAKPOINT && document.querySelector(".search-input-wrapper") && (document.querySelector(".search-input-wrapper").classList.add("d-none"), document.querySelector(".search-input").value = ""), d && (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? window.Helpers.setNavbarFixed("fixed") : window.Helpers.setNavbarFixed(""), setTimeout((function () {
            window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-horizontal") && menu.switchMenu("vertical") : document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-vertical") && menu.switchMenu("horizontal")
        }), 100)), window.Helpers.navTabsAnimation()
    }), !0), !isHorizontalLayout && !window.Helpers.isSmallScreen() && ("undefined" != typeof TemplateCustomizer && (window.templateCustomizer.settings.defaultMenuCollapsed ? window.Helpers.setCollapsed(!0, !1) : window.Helpers.setCollapsed(!1, !1)), "undefined" != typeof config && config.enableMenuLocalStorage)) try {
        null !== localStorage.getItem("templateCustomizer-" + templateName + "--LayoutCollapsed") && window.Helpers.setCollapsed("true" === localStorage.getItem("templateCustomizer-" + templateName + "--LayoutCollapsed"), !1)
    } catch (e) {
    }
}(), "undefined" != typeof $ && $((function () {
    window.Helpers.initSidebarToggle();
    var e = $(".search-toggler"), t = $(".search-input-wrapper"), a = $(".search-input"), s = $(".content-backdrop");
    if (e.length && e.on("click", (function () {
        t.length && (t.toggleClass("d-none"), a.focus())
    })), $(document).on("keydown", (function (e) {
        let s = e.ctrlKey, o = 191 === e.which;
        s && o && t.length && (t.toggleClass("d-none"), a.focus())
    })), setTimeout((function () {
        var e = $(".twitter-typeahead");
        a.on("focus", (function () {
            t.hasClass("container-xxl") ? (t.find(e).addClass("container-xxl"), e.removeClass("container-fluid")) : t.hasClass("container-fluid") && (t.find(e).addClass("container-fluid"), e.removeClass("container-xxl"))
        }))
    }), 10), a.length) {
        var o = function (e) {
            return function (t, a) {
                let s;
                s = [], e.filter((function (e) {
                    if (e.name.toLowerCase().startsWith(t.toLowerCase())) s.push(e); else {
                        if (e.name.toLowerCase().startsWith(t.toLowerCase()) || !e.name.toLowerCase().includes(t.toLowerCase())) return [];
                        s.push(e), s.sort((function (e, t) {
                            return t.name < e.name ? 1 : -1
                        }))
                    }
                })), a(s)
            }
        }, n = "search-vertical.json";
        if ($("#layout-menu").hasClass("menu-horizontal")) n = "search-horizontal.json";
        var i, l = $.ajax({url: assetsPath + "json/" + n, dataType: "json", async: !1}).responseJSON;
        a.each((function () {
            var e = $(this);
            a.typeahead({
                hint: !1,
                classNames: {
                    menu: "tt-menu navbar-search-suggestion",
                    cursor: "active",
                    suggestion: "suggestion d-flex justify-content-between px-3 py-2 w-100"
                }
            }, {
                name: "pages",
                display: "name",
                limit: 5,
                source: o(l.pages),
                templates: {
                    header: '<h6 class="suggestions-header text-primary mb-0 mx-3 mt-3 pb-2">Pages</h6>',
                    suggestion: function ({url: e, icon: t, name: a}) {
                        return '<a href="' + baseUrl + e + '"><div><i class="mdi ' + t + ' me-2"></i><span class="align-middle">' + a + "</span></div></a>"
                    },
                    notFound: '<div class="not-found px-3 py-2"><h6 class="suggestions-header text-primary mb-2">Pages</h6><p class="py-2 mb-0"><i class="mdi mdi-alert-circle-outline me-2 mdi-14px"></i> No Results Found</p></div>'
                }
            }, {
                name: "files",
                display: "name",
                limit: 4,
                source: o(l.files),
                templates: {
                    header: '<h6 class="suggestions-header text-primary mb-0 mx-3 mt-3 pb-2">Files</h6>',
                    suggestion: function ({src: e, name: t, subtitle: a, meta: s}) {
                        return '<a href="javascript:;"><div class="d-flex w-50"><img class="me-3" src="' + assetsPath + e + '" alt="' + t + '" height="32"><div class="w-75"><h6 class="mb-0">' + t + '</h6><small class="text-muted">' + a + '</small></div></div><small class="text-muted">' + s + "</small></a>"
                    },
                    notFound: '<div class="not-found px-3 py-2"><h6 class="suggestions-header text-primary mb-2">Files</h6><p class="py-2 mb-0"><i class="mdi mdi-alert-circle-outline me-2 mdi-14px"></i> No Results Found</p></div>'
                }
            }, {
                name: "members",
                display: "name",
                limit: 4,
                source: o(l.members),
                templates: {
                    header: '<h6 class="suggestions-header text-primary mb-0 mx-3 mt-3 pb-2">Members</h6>',
                    suggestion: function ({name: e, src: t, subtitle: a}) {
                        return '<a href="' + baseUrl + 'app/user/view/account"><div class="d-flex align-items-center"><img class="rounded-circle me-3" src="' + assetsPath + t + '" alt="' + e + '" height="32"><div class="user-info"><h6 class="mb-0">' + e + '</h6><small class="text-muted">' + a + "</small></div></div></a>"
                    },
                    notFound: '<div class="not-found px-3 py-2"><h6 class="suggestions-header text-primary mb-2">Members</h6><p class="py-2 mb-0"><i class="mdi mdi-alert-circle-outline me-2 mdi-14px"></i> No Results Found</p></div>'
                }
            }).bind("typeahead:render", (function () {
                s.addClass("show").removeClass("fade")
            })).bind("typeahead:select", (function (e, t) {
                "javascript:;" !== t.url && (window.location = baseUrl + t.url)
            })).bind("typeahead:close", (function () {
                a.val(""), e.typeahead("val", ""), t.addClass("d-none"), s.addClass("fade").removeClass("show")
            })), a.on("keyup", (function () {
                "" == a.val() && s.addClass("fade").removeClass("show")
            }))
        })), $(".navbar-search-suggestion").each((function () {
            i = new PerfectScrollbar($(this)[0], {wheelPropagation: !1, suppressScrollX: !0})
        })), a.on("keyup", (function () {
            i.update()
        }))
    }
}));
