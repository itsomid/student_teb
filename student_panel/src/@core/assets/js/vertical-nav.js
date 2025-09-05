import $ from "jquery";


const funcs = {

    menuToggle() {
        var e = $(".menu-toggle"),
            n = $(".sidebar-left"),
            l = $(".sidebar-left-secondary"),
            t = $(".sidebar-overlay"),
            a = $(".main-content-wrap"),
            i = $(".nav-item"),
            c = $(".search-bar input"),
            s = $(".search-close");

        function o() {
            n.addClass("open"), a.addClass("sidenav-open");
        }

        function r() {
            n.removeClass("open"), a.removeClass("sidenav-open");
        }

        function u() {
            l.addClass("open"), t.addClass("open");
        }

        function d() {
            l.removeClass("open"), t.removeClass("open");
        }

        (window.gullUtils = {
            isMobile: function () {
                return window && window.matchMedia("(max-width: 767px)").matches;
            },
        }),
            $(window).on("resize", function (e) {
                gullUtils.isMobile() && (r(), d());
            }),
            i.each(function (e) {
                var n = $(this);
                if (n.hasClass("active")) {
                    var t = n.data("item");
                    l.find('[data-parent="' + t + '"]').show();
                }
            }),
        gullUtils.isMobile() && (r(), d()),
            n.find(".nav-item").on("mouseenter", function (e) {
                var n,
                    t = $(e.currentTarget),
                    a = t.data("item");
                a ? ((n = t), $(".nav-item").removeClass("active"), n.addClass("active"), u()) : d(), l.find(".childNav").hide(), l.find('[data-parent="' + a + '"]').show();
            }),
            n.find(".nav-item").on("click", function (e) {
                $(event.currentTarget).data("item") && e.preventDefault();
            }),
            t.on("click", function (e) {
                gullUtils.isMobile() && r(), d();
            }),
            e.on("click", function (e) {
                var t = n.hasClass("open"),
                    a = l.hasClass("open"),
                    i = $(".nav-item.active").data("item");
                t && a && gullUtils.isMobile() ? (r(), d()) : t && a ? d() : t ? r() : t || a || i ? t || a || (o(), u()) : o();
            });
        var v = $(".search-ui");
        c.on("focus", function () {
            v.addClass("open");
        }),
            s.on("click", function () {
                v.removeClass("open");
            }),
            // $(".perfect-scrollbar, [data-perfect-scrollbar]").each(function (e) {
            //     var n = $(this);
            //     new PerfectScrollbar(this, {
            //         suppressScrollX: n.data("suppress-scroll-x"),
            //         suppressScrollY: n.data("suppress-scroll-y")
            //     });
            // }),
            $("[data-fullscreen]").on("click", function () {
                var e = document.body;
                return (
                    (document.fullScreenElement && null !== document.fullScreenElement) || document.mozFullScreen || document.webkitIsFullScreen
                        ? (function (e) {
                            var n = e.cancelFullScreen || e.webkitCancelFullScreen || e.mozCancelFullScreen || e.exitFullscreen;
                            if (n) n.call(e);
                            else if (void 0 !== window.ActiveXObject) {
                                var l = new ActiveXObject("WScript.Shell");
                                null !== l && l.SendKeys("{F11}");
                            }
                        })(document)
                        : (function (e) {
                            var n = e.requestFullScreen || e.webkitRequestFullScreen || e.mozRequestFullScreen || e.msRequestFullscreen;
                            if (n) n.call(e);
                            else if (void 0 !== window.ActiveXObject) {
                                var l = new ActiveXObject("WScript.Shell");
                                null !== l && l.SendKeys("{F11}");
                            }
                        })(e),
                        !1
                );
            });
    },
    lunchSidebarMenu() {
        const navbar = $("#top-nav");
        const promo_banner = $('#promo-header-banner')
        let navbar_offset_top
        if (navbar.length) {
            navbar_offset_top = navbar.offset().top;
        }


        if ($('.header-header-banner').length || !promo_banner.length) {
            const header_banner = $(".header-header-banner");
            const top_section = header_banner.height() + navbar.height();

            $("#sidebar-nav").css({
                'transition': 'none',
                'height': 'calc( 100vh - ' + top_section + 'px)',
                'top': top_section
            });
            window.onscroll = function () {

                calculateSideNavHeight(navbar_offset_top);

            };
        } else {
            navbar.addClass('navbar-sticky');
        }

        function calculateSideNavHeight(navbar_offset_top) {

            const header_banner = $(".header-header-banner");
            const top_section = header_banner.height() + navbar.height();

            if (window.pageYOffset > navbar_offset_top) {
                navbar.addClass("navbar-fixed");
                $(".main-content-wrap").css('margin-top', '80px')
                $("#sidebar-nav").removeAttr('style');

            } else if (window.pageYOffset < navbar_offset_top) {

                navbar.removeClass("navbar-fixed");

                $(".main-content-wrap").removeAttr('style')

                let nav_height = top_section - window.pageYOffset;
                if (window.innerWidth < 768) {
                    nav_height += 70;
                }
                $("#sidebar-nav").css({
                    'transition': 'all 0 ease',
                    'height': 'calc( 100vh - ' + nav_height + 'px)',
                    'top': top_section - window.pageYOffset
                });
            }
        }

        const mobileBreakPoint = 768
        if (window.innerWidth < mobileBreakPoint) {
            $('.nav-item').click(function () {
                $('.main-content-wrap').removeClass("sidenav-open")
                $('.sidebar-left').removeClass("open")
            })
        }
    }
}
export default funcs


//
// "use strict";$(document).ready(function(){var e=$(".menu-toggle"),n=$(".sidebar-left"),l=$(".sidebar-left-secondary"),t=$(".sidebar-overlay"),a=$(".main-content-wrap"),i=$(".nav-item"),c=$(".search-bar input"),s=$(".search-close");function o(){n.addClass("open"),a.addClass("sidenav-open")}function r(){n.removeClass("open"),a.removeClass("sidenav-open")}function u(){l.addClass("open"),t.addClass("open")}function d(){l.removeClass("open"),t.removeClass("open")}window.gullUtils={isMobile:function(){return window&&window.matchMedia("(max-width: 767px)").matches}},$(window).on("resize",function(e){gullUtils.isMobile()&&(r(),d())}),i.each(function(e){var n=$(this);if(n.hasClass("active")){var t=n.data("item");l.find('[data-parent="'+t+'"]').show()}}),gullUtils.isMobile()&&(r(),d()),n.find(".nav-item").on("mouseenter",function(e){var n,t=$(e.currentTarget),a=t.data("item");a?(n=t,$(".nav-item").removeClass("active"),n.addClass("active"),u()):d(),l.find(".childNav").hide(),l.find('[data-parent="'+a+'"]').show()}),n.find(".nav-item").on("click",function(e){$(event.currentTarget).data("item")&&e.preventDefault()}),t.on("click",function(e){gullUtils.isMobile()&&r(),d()}),e.on("click",function(e){var t=n.hasClass("open"),a=l.hasClass("open"),i=$(".nav-item.active").data("item");t&&a&&gullUtils.isMobile()?(r(),d()):t&&a?d():t?r():t||a||i?t||a||(o(),u()):o()});var v=$(".search-ui");c.on("focus",function(){v.addClass("open")}),s.on("click",function(){v.removeClass("open")}),$(".perfect-scrollbar, [data-perfect-scrollbar]").each(function(e){var n=$(this);new PerfectScrollbar(this,{suppressScrollX:n.data("suppress-scroll-x"),suppressScrollY:n.data("suppress-scroll-y")})}),$("[data-fullscreen]").on("click",function(){var e=document.body;return document.fullScreenElement&&null!==document.fullScreenElement||document.mozFullScreen||document.webkitIsFullScreen?function(e){var n=e.cancelFullScreen||e.webkitCancelFullScreen||e.mozCancelFullScreen||e.exitFullscreen;if(n)n.call(e);else if(void 0!==window.ActiveXObject){var l=new ActiveXObject("WScript.Shell");null!==l&&l.SendKeys("{F11}")}}(document):function(e){var n=e.requestFullScreen||e.webkitRequestFullScreen||e.mozRequestFullScreen||e.msRequestFullscreen;if(n)n.call(e);else if(void 0!==window.ActiveXObject){var l=new ActiveXObject("WScript.Shell");null!==l&&l.SendKeys("{F11}")}}(e),!1})});

