(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgposts_carousel.default", function (scope, $) {
       
            var mgpCarousel = $(scope).find(".mgpc-pcarousel");

            if (!mgpCarousel.length) {
                return;
            }

            var mgpCarLoop = mgpCarousel.data('loop');
            var mgpCarDirection = mgpCarousel.data('direction');
            var mgpCarNumber = mgpCarousel.data('number');
            var mgpCarMargin = mgpCarousel.data('margin');
            var mgpCarSpeed = mgpCarousel.data('speed');
            var mgpCarAutoplay = mgpCarousel.data('autoplay');
            var mgpCarAutoDelay = mgpCarousel.data('auto-delay');
            var mgpCarAutoHeight = mgpCarousel.data('auto-height');
            var mgpCarGrabCursor = mgpCarousel.data('grab-cursor');
            var mgpCarMarquee = mgpCarousel.data('marquee');
            var mgpCarMarqueeSpeed = mgpCarousel.data('marquee-speed') || 5;
            var mgpCarMarqueeDirection = mgpCarousel.data('marquee-direction') || 'left';
            var mgpCarMarqueePause = mgpCarousel.data('marquee-pause');

            // Marquee mode configuration
            if (mgpCarMarquee == 'yes') {
                // Calculate speed: higher marquee-speed value = faster
                // Speed maps to transition duration per slide (lower ms = faster)
                var marqueeTransitionSpeed = Math.max(1000, 10000 / mgpCarMarqueeSpeed);

                var autoPlayData = {
                    delay: 0,
                    disableOnInteraction: false,
                    reverseDirection: (mgpCarMarqueeDirection === 'right'),
                };

                // Use same breakpoints logic as normal mode
                if(mgpCarNumber > 1){
                    var marqueeBreakpoints = {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: mgpCarMargin,
                        },
                        991: {
                            slidesPerView: mgpCarNumber,
                            spaceBetween: mgpCarMargin,
                        },
                    }
                }else{
                    var marqueeBreakpoints = {
                        991: {
                            slidesPerView: mgpCarNumber,
                            spaceBetween: mgpCarMargin,
                        },
                    }
                }

                var swiperConfig = {
                    direction: 'horizontal',
                    slidesPerView: 1,
                    spaceBetween: mgpCarMargin,
                    loop: true,
                    loopedSlides: mgpCarNumber,
                    speed: marqueeTransitionSpeed,
                    autoplay: autoPlayData,
                    freeMode: {
                        enabled: true,
                        momentum: false,
                    },
                    grabCursor: false,
                    allowTouchMove: false,
                    watchSlidesProgress: true,
                    breakpoints: marqueeBreakpoints,
                    pagination: false,
                    navigation: false,
                };

            } else {
                // Normal carousel mode
                if(mgpCarAutoplay == 'yes'){
                    var autoPlayData = {
                        delay: mgpCarAutoDelay,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    };
                }else{
                    var autoPlayData = false;
                }

                // slider number set
                if(mgpCarNumber > 1){
                    var breakpointsValue = {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: mgpCarMargin,
                        },
                        991: {
                            slidesPerView: mgpCarNumber,
                            spaceBetween: mgpCarMargin,
                        },
                    }
                }else{
                    var breakpointsValue = {
                        991: {
                            slidesPerView: mgpCarNumber,
                            spaceBetween: mgpCarMargin,
                        },
                    }
                }

                var swiperConfig = {
                    direction: mgpCarDirection,
                    slidesPerView: 1,
                    spaceBetween: 10,
                    loop: mgpCarLoop,
                    speed: mgpCarSpeed,
                    autoplay: autoPlayData,
                    autoHeight: mgpCarAutoHeight,
                    grabCursor: mgpCarGrabCursor,
                    watchSlidesProgress: true,
                    breakpoints: breakpointsValue,
                    pagination: {
                        el: mgpCarousel.find('.swiper-pagination').get(0) || null,
                        clickable: true,
                    },
                    navigation: {
                        nextEl: mgpCarousel.find('.swiper-button-next').get(0) || null,
                        prevEl: mgpCarousel.find('.swiper-button-prev').get(0) || null,
                    },
                };
            }

            // Remove no-load class before Swiper init so dimensions are calculated correctly
            mgpCarousel.find('.swiper-slide').removeClass('no-load');

            var swiperContainer = mgpCarousel.get(0);

            // Ensure the container has the 'swiper' class for Swiper 8 CSS compatibility
            if (!mgpCarousel.hasClass('swiper')) {
                mgpCarousel.addClass('swiper');
            }

            var shopCarouselSwiper = new Swiper(swiperContainer, swiperConfig);

            // Marquee: pause on hover
            if (mgpCarMarquee == 'yes' && mgpCarMarqueePause == 'yes' && shopCarouselSwiper) {
                mgpCarousel.on('mouseenter', function() {
                    shopCarouselSwiper.autoplay.stop();
                });
                mgpCarousel.on('mouseleave', function() {
                    shopCarouselSwiper.autoplay.start();
                });
            }

            // Normal carousel: hover pause
            if (mgpCarMarquee != 'yes' && mgpCarAutoplay == 'yes' && shopCarouselSwiper) {
                mgpCarousel.hover(function() {
                    shopCarouselSwiper.autoplay.stop();
                }, function() {
                    shopCarouselSwiper.autoplay.start();
                });
            }
            
        });
    });

}(jQuery));


