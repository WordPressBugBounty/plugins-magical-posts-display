;(function ($) {
	'use strict';

	$(document).ready(function () {
		// "Maybe Later" AJAX Snooze handler (Hides notice for 30 days)
		$(document).on('click', '.mgade-notice-hide', function (event) {
			event.preventDefault();
			var $btn = $(this);
			var $notice = $btn.closest('.mgadin-notice, .mgadin-pro-upsell-notice, .notice');

			// Immediately disable button to prevent multiple clicks
			$btn.prop('disabled', true).css('opacity', '0.6');

			// Smooth UI dismissal
			$notice.slideUp(350, function () {
				$(this).remove();
			});

			// Resolve nonce and ajax URL
			var nonce = $btn.data('nonce') ||
				$notice.find('[data-nonce]').data('nonce') ||
				(typeof mgpd_notice_data !== 'undefined' ? mgpd_notice_data.nonce : '');

			var ajaxUrl = (typeof mgpd_notice_data !== 'undefined' && mgpd_notice_data.ajax_url) ?
				mgpd_notice_data.ajax_url :
				(typeof ajaxurl !== 'undefined' ? ajaxurl : '');

			if (ajaxUrl && nonce) {
				$.ajax({
					url: ajaxUrl,
					type: 'POST',
					data: {
						action: 'mgpd_hide_pro_notice',
						nonce: nonce
					}
				});
			}
		});

		// Legacy notice handlers
		$('.mgp-pronotice .mghideme').on('click', function (event) {
			event.preventDefault();
			var url = new URL(location.href);
			url.searchParams.append('mgfnotice', 1);
			location.href = url;
		});

		$('.button.skipelementor').on('click', function (event) {
			event.preventDefault();
			var url = new URL(location.href);
			url.searchParams.append('mgelhide', 1);
			location.href = url;
		});
	});
})(jQuery);