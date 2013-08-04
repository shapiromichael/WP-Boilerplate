var sortlist = {};

jQuery(function($){

	window.sortlist = {

		params: {
			speed: 250,
			autoclose: true
		},

		init: function() {

			$('.sort-list li .label').live('click', function(){
				$(this).next('.details').animate({ height : 850 }, 500);
			});

			$('.sort-list ul').sortable({
				placeholder: 'drop-zone',
				handle: '.dragger',
				items: 'li',
				stop: sortlist.update,
				opacity: 0.9,
				delay: 0
			});
			$('.sort-list li .label').click( sortlist.toggle );
			$('.sort-list .add').click( sortlist.add );
			$('.sort-list li .remove').click( sortlist.remove );
			$('.sort-list input[type=date]').datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true
			});

			$('.sortlist-colorpicker').each(function(){
				var $elem = $(this),
					default_color = 'FFFFFF';

				if( $elem.attr('color') != '' ) {
					default_color = $elem.attr('color');
				}

				$elem.ColorPicker({
					color : default_color,
					livePreview : true,
					onChange : function( bhs, hex, rgb ){
						$elem.css('background-color', '#' + hex );
						$elem.find('input').val( hex );
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					}
				});

			});




			sortlist.updateAll();
		},

		toggle: function() {

			if( $(this).parents('li').hasClass('open') ){
				sortlist.close( $(this).parents('li') );
			}else{
				sortlist.open( $(this).parents('li') );
			}

		},

		open: function( li ) {
			if( sortlist.params.autoclose ){
				sortlist.close( $('.sort-list li.open') );
			}
			li.addClass('open');
			li.find('.details').slideDown( sortlist.params.speed );
		},

		close: function( li ) {
			li.removeClass('open');
			li.find('.details').slideUp( sortlist.params.speed );
		},

		add: function() {
			// console.log( $(this) );
			//  var counter = $(this).parents('.sort-list').find('input[type=hidden][counter=true]'),
			//  	 num = parseInt( counter.val() );
			//  counter.val( num + 1 );
			 $(this).parents('.sort-list').append('<input type="hidden" name="add-new-sortlist-item" value="' + ($(this).parents('.sort-list li').size() + 1) + '"/>');
			 $('form').submit();
		},

		remove: function() {
			$(this).parents('li').css({'background':'#FF9999'}).animate({'opacity':'1'}, sortlist.params.speed * 2, function(){
				var remove = $(this).parents('.sort-list').find('input[type=hidden][remove=true]');
			 	remove.val( $(this).attr('pos') );
				$(this).remove();
				sortlist.updateAll();
				$('form').submit();
			});
		},

		update: function( e ) {
			sortlist.updateAll();
		},

		updateAll: function(){
			$('.sort-list').each(function(){
				var sorter = $(this).find('input[type=hidden].order-data');
				sorter.val('');
				$(this).find('li').each(function(){
					if( sorter.val() ){
						sorter.val( sorter.val() + ',' + $(this).attr('pos') );
					}else{
						sorter.val( $(this).attr('pos') );
					}
				});
			});
		}

	}

	sortlis.init();

})(window.jQuery);