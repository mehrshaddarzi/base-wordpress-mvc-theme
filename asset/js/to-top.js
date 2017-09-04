jQuery(document).ready(function($) {

$('body').append('<div id="toTop" class="hidden-sm hidden-xs"><i class="fa fa-chevron-up"></i></div>');
    	$(window).scroll(function () {
			if ($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();
			} else {
				$('#toTop').fadeOut();
			}
		}); 
    $('#toTop').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
});

  
});