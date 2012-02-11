
	var theme = {
		
		params: {
			
		},
		init: function(){
			
			// Add a browser class
			var browser_class = '';
			$.browser.msie?browser_class="ie v"+parseInt($.browser.version.toString()):$.browser.mozilla?browser_class="ff":$.browser.webkit&&(browser_class=null!=navigator.userAgent.match(/iPad/i)?"ipad":null!=navigator.userAgent.match(/iPhone/i)||null!=navigator.userAgent.match(/iPod/i)? "iphone":null!=navigator.userAgent.match(/Safari/i)&&null==navigator.userAgent.match(/Chrome/i)?"sf":"wk");
			$('body').addClass( browser_class );
			
			// Adding costume classes
			$('ul li:first-child').addClass('first');
			$('ul li:last-child').addClass('last');
			
			// Adding support for clickable elements
			$('.clickable').mousedown(function(){
				$(this).addClass('down');
			}).bind('mouseup mouseleave',function(){
				$(this).removeClass('down');
			});
			
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
	$(document).ready(theme.init);
	