<?php
	
	// Changing the footer text
	function theme_footer_text() {
		return "<span id=\"footer-thankyou\">You're awesome! thanks for using <a href=\"https://github.com/sinapsa/WordPress-Theme-Template\" target=\"_blank\">WordPress Theme Template</a>.</span>";
	}
	add_action('admin_footer_text', 'theme_footer_text');