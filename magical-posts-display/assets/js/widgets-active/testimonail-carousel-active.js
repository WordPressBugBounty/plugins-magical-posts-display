(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgpdtestti_carousel.default", function (scope, $) {
       
            var mGpTCarousel = $(scope).find(".mgpd-testimonial-carousel");
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
            
          
            


            var shopCarouselSwiper = new Swiper (mGpTCarousel.get(0), {
                  // Optional parameters
                  direction: xscarDirection, // vertical
                  effect: xscarEffects, //"slide", "fade", "cube", "coverflow" or "flip"
                  slidesPerView: 1,
                  spaceBetween: 10,
                  loop: xscarLoop,
                  speed: xscarSpeed,
                  autoplay: autoPlayData,
                 // autoHeight: true,
                  grabCursor: xscarGrabCursor,
                  watchSlidesProgress: true,
                  watchSlidesVisibility: true,
                  breakpoints: breakpointsValue,
                  pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                  },
                  navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                  },
                })
                $( document ).ready(function() {
                    $('.mgpd-testimonial-carousel .swiper-slide').removeClass('no-load');
                 });
            
        });
    })

  


}(jQuery));	


