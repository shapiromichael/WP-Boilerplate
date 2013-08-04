<?php


	function theme_options_general() {

		// Prevent access for non-administratos
		if (!current_user_can('administrator'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		// global $conduit_blog_params, $conduit_blog_params_sections;

		// $args = array(
		// 	'name'     => 'blog-params',
		// 	'sections' => $conduit_blog_params_sections,
		// 	'fields'   => $conduit_blog_params
		// );

		// $settings = new Settings( $args );


		// Save options
		if( isset( $_POST['action'] ) && $_POST['action'] == 'update-general-settings' ){
			update_param_options();
			echo "<div id='notice' class='updated fade'><p>The changes were saved</p></div>";
		}		


		?>
		<div class="wrap">
			<div id="icon-options-32" class="icon32"><br></div>
			<h2>Custom Text</h2>
			<div style="padding:5px;"></div>

			<form method="post" action="admin.php?page=options">
			<input type="hidden" name="action" value="update-general-settings" />
			<div class="panel">

				<?php show_param_options(); ?>

			</div><!-- end .panel -->

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>

		</div>
		<?php

		// global $conduit_blog_params, $wp_rewrite;

	}

