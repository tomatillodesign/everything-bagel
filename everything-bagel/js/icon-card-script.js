jQuery(function( $ ){

    $('.icon-card').click( function(){
		$(this).parent().find('.icon-card-body').slideToggle('fast');
		$(this).toggleClass('on');
		return false;
	});

});
