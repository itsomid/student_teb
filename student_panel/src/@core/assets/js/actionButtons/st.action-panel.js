/*
 * Copyright 2016
 * Released under the MIT license
 * https://github.com/snowytech/st-action-panel-git
 *
 * @author: Drew D. Lenhart
 * @version: 0.0.1
 */
import $ from 'jquery'

(function ($) {
    'use strict';
    $.fn.launchBtn = function (options) {

        var mainBtn, panel, clicks, settings, launchPanelAnim, closePanelAnim, openPanel, boxClick;

        mainBtn = $(".st-btn-main");
        panel = $(".st-panel");

        clicks = 0;

        //default settings
        settings = $.extend({
            openDuration: 600,
            closeDuration: 200,
            rotate: true
        }, options);

        //Open panel animation
        launchPanelAnim = function () {
            panel.animate({
                opacity: "toggle",
                height: "toggle"
            }, settings.openDuration);
        };

        //Close panel animation
        closePanelAnim = function () {
            panel.animate({
                opacity: "hide",
                height: "hide"
            }, settings.closeDuration);
        };

        //Open panel and rotate icon
        openPanel = function (e) {
            var img = document.getElementById('customerServiceImg');
            var pulse = document.getElementById('pulse');
            var overlay = document.getElementById('overlay');
            if (clicks === 0) {
                if (settings.rotate) {
                    pulse.classList.add('d-none');
                    img.classList.add('d-flex');
                    $(this).removeClass('rotateBackward').toggleClass('rotateForward');
                    if ($(window).width() < 992) {
                        overlay.classList.add('visible');
                    }

                }
                launchPanelAnim();
            } else {
                if (settings.rotate) {
                    img.classList.remove('d-none');
                    $(this).removeClass('rotateForward').toggleClass('rotateBackward');

                }
                closePanelAnim();
                // clicks--;
            }
            e.preventDefault();
            return false;
        };

        //Allow clicking in panel
        boxClick = function (e) {
            document.querySelector('.st-btn-main').classList.remove('rotateForward');
            document.querySelector('.overlay').classList.remove('visible')
            return e
        };

        //Main button click
        mainBtn.on('click', openPanel);

        //Prevent closing panel when clicking inside
        // panel.on(boxClick);


        panel.click(function () {
            boxClick()
            closePanelAnim()
        });
        //Click away closes panel when clicked in document


        // If the class exists, load the script
        // if

        // the child element has the rotateForward class
        // add your code here
        const el = document.getElementsByClassName('app-admin-wrap');
        $(el).click(function () {
            if ($('.st-btn-container').children().hasClass('rotateForward')) {
                document.querySelector('.st-btn-main').classList.remove('rotateForward')
                document.querySelector('.overlay').classList.remove('visible')

                closePanelAnim();
                var image = document.getElementById('customerServiceImg')
                image.classList.add('d-flex');
                if (clicks === 1) {
                    mainBtn.removeClass('rotateForward').toggleClass('rotateBackward');
                    image.classList.add('d-none')
                }
                clicks = 0;
            }
        });
    };
}($));
