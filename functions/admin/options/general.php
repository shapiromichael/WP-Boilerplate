<?php

	function theme_options_general(){
		
		// Prevent access for non-administratos
		if (!current_user_can('publish_posts'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		// Save options
		if( isset( $_POST['action'] ) && $_POST['action'] == 'update-general-options' ){
			
			$_updateFields = array(
				'ga_account'			
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
								<label for="ga_account">Google Analytics Account</label>
							</th>
							<td>
								<input name="ga_account" type="text" id="ga_account" value="<?php echo get_option('ga_account') ?>" class="regular-text" autocomplete="off">
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
