(function ($) {
"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgpdtestti_carousel.default", function (scope, $) {
       
            var mGpTCarousel = $(scope).find(".mgpd-testimonial-carousel");

            if (!mGpTCarousel.length) {
                return;
            }

            var xscarLoop = mGpTCarousel.data('loop');
            var xscarDirection = mGpTCarousel.data('direction');
            var xscarNumber = mGpTCarousel.data('number');
            var xscarMargin = mGpTCarousel.data('margin');
            var xscarSpeed = mGpTCarousel.data('speed');
            var xscarAutoplay = mGpTCarousel.data('autoplay');
            var xscarAutoDelay = mGpTCarousel.data('auto-delay');
            var xscarGrabCursor = mGpTCarousel.data('grab-cursor');
            var xscarEffects = mGpTCarousel.data('effect');
          
            if(xscarAutoplay == 'yes'){
              var autoPlayData = {
                    delay: xscarAutoDelay,
                    disableOnInteraction: false,
                  };
            }else{
              var autoPlayData = false;
            }

            if(xscarNumber > 1){
              var breakpointsValue = {
                768: {
                  slidesPerView: 2,
                  spaceBetween: xscarMargin,
                },
                991: {
                  slidesPerView: xscarNumber,
                  spaceBetween: xscarMargin,
                },
              }
            }else{
              var breakpointsValue = {
                991: {
                  slidesPerView: xscarNumber,
                  spaceBetween: xscarMargin,
                },
              }
            }

            mGpTCarousel.find('.swiper-slide').removeClass('no-load');

            if (!mGpTCarousel.hasClass('swiper')) {
                mGpTCarousel.addClass('swiper');
            }

            var shopCarouselSwiper = new Swiper (mGpTCarousel.get(0), {
                  direction: xscarDirection,
                  effect: xscarEffects,
                  slidesPerView: 1,
                  spaceBetween: 10,
                  loop: xscarLoop,
                  speed: xscarSpeed,
                  autoplay: autoPlayData,
                  grabCursor: xscarGrabCursor,
                  watchSlidesProgress: true,
                  breakpoints: breakpointsValue,
                  pagination: {
                    el: mGpTCarousel.find('.swiper-pagination').get(0) || null,
                    clickable: true,
                  },
                  navigation: {
                    nextEl: mGpTCarousel.find('.swiper-button-next').get(0) || null,
                    prevEl: mGpTCarousel.find('.swiper-button-prev').get(0) || null,
                  },
                });
            
        });
    });

}(jQuery));
