jQuery(document).ready(function($){

	
	/*
	 *
	 * BP_Options_upload function
	 * Adds media upload functionality to the page
	 *
	 */
	 
	 var formfield = '',
	 	 _header_clicked = false,
		 _orig_send_attachment = wp.media.editor.send.attachment;
	 
	$("img[src='']").attr("src", nhp_upload.url);
	
	$('.nhp-opts-upload').click(function() {
		_header_clicked = true;
		formfield = $(this).attr('rel-id');

		var send_attachment_bkp = wp.media.editor.send.attachment;

	    wp.media.editor.send.attachment = function(props, attachment) {

	    	if (_header_clicked) {

				$('#nhp-opts-screenshot-' + formfield).attr('src', attachment.url).removeAttr('empty');
				$('#' + formfield).val( attachment.url );
				$('#' + formfield).next().fadeIn('slow');
				$('#' + formfield).next().next().fadeOut('slow');
				$('#' + formfield).next().next().next().fadeIn('slow');
				tb_remove();
				_header_clicked = false;

			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			}
	    }

	    wp.media.editor.open();
	    return false;
	});
	
	$('.nhp-opts-upload-remove').click(function(){
		$relid = $(this).attr('rel-id');
		$('#'+$relid).val('');
		$(this).prev().fadeIn('slow');
		$(this).prev().prev().fadeOut('slow', function(){$(this).attr("src", nhp_upload.url);});
		$(this).fadeOut('slow');
	});

	$('.add_media').on('click', function(){
	    _header_clicked = false;
	});
});