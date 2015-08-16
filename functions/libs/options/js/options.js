(function($){
	
	var _transition_speed = 0;
	
	if($('#last_tab').val() == ''){

		$('.nhp-opts-group-tab:first').slideDown('fast');
		$('#nhp-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = $('#last_tab').val();
		$('#'+tabid+'_section_group').slideDown('fast');
		$('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	$('input[name="'+nhp_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(nhp_opts.reset_confirm)){
			return false;
		}
	});
	
	$('.nhp-opts-group-tab-link-a').click(function(){
		relid = $(this).attr('data-rel');
		
		$('#last_tab').val(relid);
		
		$('.nhp-opts-group-tab').each(function(){
			if($(this).attr('id') == relid+'_section_group'){
				$(this).delay(_transition_speed).fadeIn(_transition_speed);
			}else{
				$(this).fadeOut(_transition_speed);
			}
			
		});
		
		$('.nhp-opts-group-tab-link-li').each(function(){
				if($(this).attr('id') != relid+'_section_group_li' && $(this).hasClass('active')){
					$(this).removeClass('active');
				}
				if($(this).attr('id') == relid+'_section_group_li'){
					$(this).addClass('active');
				}
		});
	});
	
	
	
	
	if($('#nhp-opts-save').is(':visible')){
		$('#nhp-opts-save').delay(2000).slideUp('slow');
	}
	
	if($('#nhp-opts-imported').is(':visible')){
		$('#nhp-opts-imported').delay(2000).slideUp('slow');
	}	
	
	$('input, textarea, select').change(function(){
		$('#nhp-opts-save-warn').slideDown('slow');
	});
	
	
	$('#nhp-opts-import-code-button').click(function(){
		if($('#nhp-opts-import-link-wrapper').is(':visible')){
			$('#nhp-opts-import-link-wrapper').fadeOut(_transition_speed);
			$('#import-link-value').val('');
		}
		$('#nhp-opts-import-code-wrapper').fadeIn(_transition_speed);
	});
	
	$('#nhp-opts-import-link-button').click(function(){
		if($('#nhp-opts-import-code-wrapper').is(':visible')){
			$('#nhp-opts-import-code-wrapper').fadeOut(_transition_speed);
			$('#import-code-value').val('');
		}
		$('#nhp-opts-import-link-wrapper').fadeIn(_transition_speed);
	});
	
	
	
	
	$('#nhp-opts-export-code-copy').click(function(){
		if($('#nhp-opts-export-link-value').is(':visible')){$('#nhp-opts-export-link-value').fadeOut(_transition_speed);}
		$('#nhp-opts-export-code').toggle('fade');
	});
	
	$('#nhp-opts-export-link').click(function(){
		if($('#nhp-opts-export-code').is(':visible')){$('#nhp-opts-export-code').fadeOut(_transition_speed);}
		$('#nhp-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
})(window.jQuery);