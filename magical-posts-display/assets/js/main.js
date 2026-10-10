(function ($) {
    "use strict";

    /**
     * Initialize Masonry for a given scope or all containers
     *
     * @param {jQuery|HTMLElement|null} scope Optional Elementor widget scope
     */
    window.mgpdInitSingleMasonry = function (scope) {
        var $targetContainers = scope ? $(scope).find('.mgpd-masonry') : $('.mgpd-masonry');

        if (!$targetContainers.length) {
            return;
        }

        $targetContainers.each(function () {
            var container = this;
            var $container = $(this);
            var $wrapper = $container.closest('.mgpd-masonry-container');

            // Fallback if libraries are missing
            if (typeof imagesLoaded === 'undefined' || typeof Masonry === 'undefined') {
                $wrapper.addClass('masonry-loaded');
                return;
            }

            imagesLoaded(container, function () {
                try {
                    // Destroy previous instance if re-rendering in Elementor editor
                    var existingMasonry = $container.data('masonry');
                    if (existingMasonry && typeof existingMasonry.destroy === 'function') {
                        try {
                            existingMasonry.destroy();
                        } catch (e) {
                            // Suppress destroy errors during rapid editor redraws
                        }
                    }

                    var masonryInstance = new Masonry(container, {
                        itemSelector: '.mgpd-masonry-item',
                        percentPosition: true,
                        gutter: 0,
                        horizontalOrder: true,
                        fitWidth: false,
                        transitionDuration: '0.2s'
                    });

                    // Store reference
                    $container.data('masonry', masonryInstance);

                    // Reveal container smoothly
                    $wrapper.addClass('masonry-loaded');
                    $container.css('height', 'auto');

                    // Force reflow after images settle
                    setTimeout(function () {
                        if (masonryInstance && typeof masonryInstance.layout === 'function') {
                            masonryInstance.layout();
                        }
                    }, 150);

                } catch (err) {
                    $wrapper.addClass('masonry-loaded');
                }
            });
        });
    };

    // Document ready initialization
    $(document).ready(function () {
        // Show sticker lists
        $('.mgpd-sticker ul').show();

        // Pre-initialize masonry containers
        $('.mgpd-masonry').each(function () {
            var $container = $(this);
            if (!$container.closest('.mgpd-masonry-container').hasClass('masonry-loaded')) {
                $container.css('min-height', '300px');
            }
        });

        // Initialize on DOM ready
        window.mgpdInitSingleMasonry();
    });

    // Window load fallback
    $(window).on('load', function () {
        window.mgpdInitSingleMasonry();

        // Initialize Premium Features if available
        if (typeof initMGPDPremiumFeatures === 'function') {
            initMGPDPremiumFeatures();
        }
    });

    // Elementor Editor Live Re-initialization Hooks
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            var masonryWidgets = [
                'frontend/element_ready/mgposts_dgrid.default',
                'frontend/element_ready/mgposts_adv_grid1.default',
                'frontend/element_ready/mgposts_adv_grid2.default',
                'frontend/element_ready/mgposts_adv_img_grid.default'
            ];

            $.each(masonryWidgets, function (index, hookName) {
                elementorFrontend.hooks.addAction(hookName, function ($scope) {
                    window.mgpdInitSingleMasonry($scope);
                });
            });
        }
    });

    // Global throttled re-layout helper
    var mgpdMasonryThrottle = false;
    window.mgpdReinitializeMasonry = function () {
        if (mgpdMasonryThrottle) {
            return;
        }

        mgpdMasonryThrottle = true;
        setTimeout(function () {
            mgpdMasonryThrottle = false;
        }, 300);

        window.mgpdInitSingleMasonry();
    };

})(jQuery);
