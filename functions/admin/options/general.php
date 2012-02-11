<?php

	function theme_options_general(){
		
		// Prevent access for non-administratos
		if (!current_user_can('publish_posts'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		// Save options
		if( isset( $_POST['action'] ) && $_POST['action'] == 'update-general-options' ){
			
			$_updateFields = array(
				'theme_temp_1',
				'theme_temp_2'				
			);
			
			foreach($_updateFields as $field){
				if( isset( $_POST[ $field ] ) ){
					update_option( $field , $_POST[ $field ] );
				}
			}
			
			
			echo "<div id='notice' class='updated fade'><p>Options saved.</p></div>";
		}
		
		?>
		<div class="wrap">
			<div id="icon-options-32" class="icon32"><br></div>
			<h2>Theme Options</h2>
			<div style="padding:5px;"></div>
			
			<form method="post" action="admin.php?page=options">
			<input type="hidden" name="action" value="update-general-options" /> 
			<div class="panel">
				
				<h3 class="tm-title">Social Channels</h3>
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="theme_temp_1">Temp #1</label>
							</th>
							<td>
								<input name="theme_temp_1" type="text" id="theme_temp_1" value="<?php echo get_option('theme_temp_1') ?>" class="regular-text" autocomplete="off">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="theme_temp_2">Temp #2</label>
							</th>
							<td>
								<input name="theme_temp_2" type="text" id="theme_temp_2" value="<?php echo get_option('theme_temp_2') ?>" class="regular-text" autocomplete="off">
							</td>
						</tr>
					</tbody>
				</table>
			
			</div><!-- end .panel -->
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			</form>
			
		</div>
		<?php
		
	}
