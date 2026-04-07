(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgposts_dslider.default", function (scope, $) {
       
            var vbpSlider = $(scope).find(".mgps-main");

            if (!vbpSlider.length) {
                return;
            }

            var mgsLoop = vbpSlider.data('loop');
            var mgsEffect = vbpSlider.data('effect');
            var mgsDirection = vbpSlider.data('direction');
            var mgsSpeed = vbpSlider.data('speed');
            var mgsAutoplay = vbpSlider.data('autoplay');
            var mgsAutoDelay = vbpSlider.data('auto-delay');
            var mgsGrabCursor = vbpSlider.data('grab-cursor');
            var mgsNav = vbpSlider.data('nav');
            var mgsDots = vbpSlider.data('dots');

            if(mgsAutoplay == true){
              var autoPlayData = {
                    delay: mgsAutoDelay,
                    disableOnInteraction: false,
                  };
            }else{
              var autoPlayData = false;
            }

            // Ensure the container has the 'swiper' class for Swiper 8 CSS compatibility
            if (!vbpSlider.hasClass('swiper')) {
                vbpSlider.addClass('swiper');
            }

            var mgsSwiper = new Swiper (vbpSlider.get(0), {
                  // Optional parameters
                  direction: mgsDirection, // vertical
                  loop: mgsLoop,
                  effect: mgsEffect, //"slide", "fade", "cube", "coverflow" or "flip"
                  speed: mgsSpeed,
                  autoplay: autoPlayData,
                 // autoHeight: true,
                 // mousewheel: true,
                  grabCursor: mgsGrabCursor,
                  parallax: true,
                  watchSlidesProgress: true,
                  pagination: {
                    el: vbpSlider.find('.swiper-pagination').get(0) || null,
                    clickable: true,
                  },
                  navigation: {
                    nextEl: vbpSlider.find('.swiper-button-next').get(0) || null,
                    prevEl: vbpSlider.find('.swiper-button-prev').get(0) || null,
                  },
                });
            
        });
    });

}(jQuery));	


