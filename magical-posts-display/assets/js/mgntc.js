;(function($){
	$(document).ready(function(){
		$('.mgp-pronotice .mghideme').on('click',function(event){
			event.preventDefault();
			var url = new URL(location.href);
			url.searchParams.append('mgfnotice',1);
			location.href= url;
		});
		$('.button.skipelementor').on('click',function(event){
			event.preventDefault();
			var url = new URL(location.href);
			url.searchParams.append('mgelhide',1);
			location.href= url;
		});
		$('.mgade-notice-hide').on('click',function(event){
			event.preventDefault();
			var url = new URL(location.href);
			url.searchParams.append('mgrecnot',1);
			location.href= url;
		});
	});
})(jQuery);