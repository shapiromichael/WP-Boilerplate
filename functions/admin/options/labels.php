<?php


	function options_custom_labels() {

		// Prevent access for non-administratos
		if (!current_user_can('administrator'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}


		// Setup captions
		$_labels = array(
			
			'General Labels' => array(
				array( 'name' => 'search_placeholder', 'title' => 'Search This Blog',         'description' => 'Watermark text that will appear in the search field'),
				array( 'name' => 'footer_copyrights',  'title' => 'Copyrights in the Footer', 'description' => 'for example: All rights reserved for Sinapsa &copy;')
			),
			
			'Post' => array(
				array( 'name' => 'before_author',      'title' => 'Before Author:',           'description' => 'Will appear before the author title'),
				array( 'name' => 'bofore_date',        'title' => 'Before Date:',             'description' => 'Will appear before the date'),
				array( 'name' => 'before_categories',  'title' => 'Before Categories',        'description' => 'Will appear before category links'),
				array( 'name' => 'before_tags',        'title' => 'Before Tags',              'description' => 'Will appear before tag links')
			)

		);

		
		// Save options
		if( isset( $_POST['action'] ) && $_POST['action'] == 'update-labels' ){

			// Update labels
			foreach( $_labels as $section_title => $section ){
				
				foreach( $section as $label ){
					if( isset( $_POST[ $label['name'] ] ) ){
						update_option( $label['name'], $_POST[ $label['name'] ] );
					}
				}

			}

			echo "<div id='notice' class='updated fade'><p>The changes were saved</p></div>";

		}


		?>
		<div class="wrap">
			<div id="icon-options-temeh" class="icon32"><br></div>
			<h2>Custom Text</h2>
			<div style="padding:5px;"></div>

			<form method="post" action="admin.php?page=labels">
			<input type="hidden" name="action" value="update-labels" />
			<div class="panel">

				<?php

				// Display all the captions
				foreach( $_labels as $section_title => $section){

					?>
					<h3 class="tm-title"><?php echo $section_title; ?></h3>
					<table class="form-table">
						<?php

						foreach( $section as $caption ) {
							?>
								<tr>
									<th scope="row"><?php echo $caption['title'] ?>:</th>
									<td><input type="text" name="<?php echo $caption['name'] ?>" class="regular-text" value="<?php echo get_option( $caption['name'] ); ?>" ><?php echo ($caption['description']) ? '<span class="meta">('.$caption['description'].')</span>': '' ; ?></td>
								</tr>
							<?php
						}

						?>
					</table>
					<?php
				}

				?>

			</div><!-- end .panel -->

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>

		</div>
		<?php
	}