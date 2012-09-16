<?php

	function options_custom_labels() {

		// Prevent access for non-administratos
		if (!current_user_can('administrator'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		// Setup captions
		$sections = array(
			0 => 'General',
			1 => 'Post'

		);
		$labels = array(
			array( 'name' => 'search_placeholder', 'title' => 'Search This Blog',         'description' => 'Watermark text that will appear in the search field', 'section' => 0),
			array( 'name' => 'footer_copyrights',  'title' => 'Copyrights in the Footer', 'description' => 'for example: All rights reserved for Sinapsa &copy;', 'section' => 0),
			array( 'name' => 'before_author',      'title' => 'Before Author:',           'description' => 'Will appear before the author title',                 'section' => 1),
			array( 'name' => 'bofore_date',        'title' => 'Before Date:',             'description' => 'Will appear before the date',                         'section' => 1),
			array( 'name' => 'before_categories',  'title' => 'Before Categories',        'description' => 'Will appear before category links',                   'section' => 1),
			array( 'name' => 'before_tags',        'title' => 'Before Tags',              'description' => 'Will appear before tag links',                        'section' => 1)
		);
		$args = array(
			'name'   => 'labels',
			'sections' => $sections,
			'fields' => $labels
		);
		$settings = new Settings( $args );

		
		// Save options
		if( isset( $_POST['action'] ) && $_POST['action'] == 'update-labels' ){

			// Update labels
			$settings->update();

			echo "<div id='notice' class='updated fade'><p>The changes were saved</p></div>";

		}


		?>
		<div class="wrap">
			<div id="icon-options-32" class="icon32"></div>
			<h2>Custom Text</h2>
			<div style="padding:5px;"></div>

			<form method="post" action="admin.php?page=labels">
			<input type="hidden" name="action" value="update-labels" />
			<div class="panel">

				<?php
					$settings->screen();
				?>

			</div><!-- end .panel -->

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>

		</div>
		<?php
	}
