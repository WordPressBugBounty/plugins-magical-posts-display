/**
 * Magical Posts Display - Theme Builder frontend scripts.
 *
 * Powers AJAX Load More buttons and Infinite Scroll sentinels rendered by
 * the Archive Posts and Post Pagination theme widgets. Appends freshly
 * rendered post items into the `[data-mgpd-archive]` grid on the page.
 *
 * @package Magical_Posts_Display
 */
(function ($) {
	'use strict';

	if (typeof mgpdThemeBuilder === 'undefined') {
		return;
	}

	var config = mgpdThemeBuilder;

	/**
	 * Fetch the next page of items for an archive container.
	 *
	 * @param {jQuery} $container Archive grid element ([data-mgpd-archive]).
	 * @param {number} page       Page number to load.
	 * @param {Function} done     Callback(success, data).
	 */
	function fetchPage($container, page, done) {
		$.ajax({
			url: config.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'mgpd_theme_load_more',
				nonce: config.nonce,
				page: page,
				query_args: $container.attr('data-query-args') || '{}',
				widget_settings: $container.attr('data-widget-settings') || '{}'
			},
			success: function (response) {
				if (response && response.success) {
					done(true, response.data || {});
				} else {
					done(false, response);
				}
			},
			error: function () {
				done(false, null);
			}
		});
	}

	/**
	 * Append rendered items with a soft entrance animation.
	 *
	 * @param {jQuery} $container Archive grid element.
	 * @param {string} html       Item markup.
	 */
	function appendItems($container, html) {
		var $items = $(html).filter(function () {
			return this.nodeType === 1;
		});

		$items.addClass('mgpd-item-enter');
		$container.append($items);

		// Double rAF so the initial styles are committed before transitioning.
		window.requestAnimationFrame(function () {
			window.requestAnimationFrame(function () {
				$items.removeClass('mgpd-item-enter');
			});
		});

		$(document).trigger('mgpd:posts-appended', [$items]);
	}

	/**
	 * Reveal the "end of list" message inside a pagination nav.
	 *
	 * @param {jQuery} $nav Pagination nav element.
	 */
	function showEndMessage($nav) {
		var $end = $nav.find('.mgpd-end-message');
		if ($end.length) {
			$end.removeAttr('hidden');
		}
	}

	/**
	 * Load the next page for a trigger element (button or sentinel).
	 *
	 * @param {jQuery} $trigger Element carrying page/max/target data.
	 */
	function loadNext($trigger) {
		if ($trigger.data('mgpdBusy')) {
			return;
		}

		var $nav = $trigger.closest('.mgpd-archive-pagination, .mgpd-theme-pagination');
		var $container = $($trigger.attr('data-target') || '[data-mgpd-archive]').first();

		// Post Pagination widget without an Archive Posts widget on the
		// page: fall back to a regular page load so links still work.
		if (!$container.length) {
			var page = parseInt($trigger.attr('data-page'), 10) + 1;
			if (page >= 2) {
				var url = new URL(window.location.href);
				url.searchParams.set('paged', page);
				window.location.href = url.toString();
			}
			return;
		}

		var page = parseInt($trigger.attr('data-page'), 10) || 1;
		var max = parseInt($trigger.attr('data-max'), 10) || 1;
		var next = page + 1;

		if (next > max) {
			$trigger.attr('data-exhausted', '1');
			if ($nav.length) {
				showEndMessage($nav);
			}
			return;
		}

		$trigger.data('mgpdBusy', true);

		if ($trigger.is('button')) {
			$trigger.addClass('loading').prop('disabled', true);
		} else {
			$nav.find('.mgpd-infinite-loader').addClass('active');
		}

		fetchPage($container, next, function (success, data) {
			$trigger.data('mgpdBusy', false);

			if ($trigger.is('button')) {
				$trigger.removeClass('loading').prop('disabled', false);
			} else {
				$nav.find('.mgpd-infinite-loader').removeClass('active');
			}

			if (!success) {
				window.console && console.warn('MGPD: load more request failed.', data);
				return;
			}

			if (data.html) {
				appendItems($container, data.html);
			}

			$trigger.attr('data-page', next);

			var hasMore = typeof data.has_more !== 'undefined'
				? !!data.has_more
				: next < max;

			if (!hasMore) {
				$trigger.attr('data-exhausted', '1');
				if ($trigger.is('button')) {
					$trigger[0].hidden = true;
				}
				if ($nav.length) {
					showEndMessage($nav);
				}
			}
		});
	}

	// Load More buttons (Archive Posts widget + Post Pagination widget).
	$(document).on('click', '[data-mgpd-loadmore]', function (e) {
		e.preventDefault();
		loadNext($(this));
	});

	// Infinite Scroll sentinels.
	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}

				var $trigger = $(entry.target);
				if ($trigger.attr('data-exhausted')) {
					observer.unobserve(entry.target);
					return;
				}

				loadNext($trigger);
			});
		}, {
			rootMargin: '400px 0px',
			threshold: 0
		});

		function observeSentinels() {
			$('[data-mgpd-infinite]').each(function () {
				if (!this.dataset.mgpdObserved) {
					this.dataset.mgpdObserved = '1';
					observer.observe(this);
				}
			});
		}

		observeSentinels();
		$(document).on('mgpd:posts-appended', function () {
			observeSentinels();

			// Stop observing exhausted sentinels.
			$('[data-mgpd-infinite][data-exhausted]').each(function () {
				observer.unobserve(this);
			});
		});
	} else {
		// Legacy fallback: treat infinite scroll as a load more button.
		$(document).on('click', '[data-mgpd-infinite]', function (e) {
			e.preventDefault();
			loadNext($(this));
		});
	}
})(jQuery);
