;(function($){
	$(document).ready(function(){
    	$('.mg-dismiss').on('click',function(){
            var url = new URL(location.href);
            url.searchParams.append('mghide',1);
            location.href= url;
        });
	});
})(jQuery);