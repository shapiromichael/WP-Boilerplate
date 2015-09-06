<?php
	
	// Changing the footer text
	function BP_footer_text() {
		return "<span id=\"footer-thankyou\">You're awesome! thanks for using <a href=\"https://github.com/syncode/WP-Boilerplate\" target=\"_blank\">WP Boilerplate</a>.</span>";
	}
	add_action('admin_footer_text', 'BP_footer_text');