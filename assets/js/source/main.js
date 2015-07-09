(function($){
'use strict';

	var BP = {
		params: {
			
		},
		init: function(){
			
			// Enlarge images setup
			if('fancybox' in $){
				
				$('img').each(function(){
					var $parent = $(this).parent();
					if( $parent.is('a[href$=jpg]') || $parent.is('a[href$=jpeg]') || $parent.is('a[href$=png]') || $parent.is('a[href$=gif]') || $parent.is('a[href$=bmp]') ){
						$parent.addClass('enlarge');
					}
				});

				// Fancybox
				$('a.enlarge').fancybox();
			}
					
		}
	};

	window.BP = BP;

	$(BP.init);

})(window.jQuery);
