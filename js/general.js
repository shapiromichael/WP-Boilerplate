
	var $ = jQuery,
		theme = {
		
		params: {
			
		},
		init: function(){
			
			if('fancybox' in $){
				// Enlarge images setup
				$('img').each(function(){
					var parent = jQuery(this).parent();
					if( parent.is('a[href$=jpg]') || parent.is('a[href$=jpeg]') || parent.is('a[href$=png]') || parent.is('a[href$=gif]') || parent.is('a[href$=bmp]') ){
						parent.addClass('enlarge');
					};
				});

				// Fancybox
				$('a.enlarge').fancybox();
			}
					
		}
		
	}

	$(theme.init);
	
	// make it safe to use console.log always
	(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
	(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());
	