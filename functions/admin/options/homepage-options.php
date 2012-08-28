<?php

	function theme_homepage_options(){

		// Prevent access for non-administratos
		if (!current_user_can('administrator'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}



		//////////////////////////     Slides      //////////////////////////
		$items_structure = array(
			'name'           => 'component_name', // the name of the option - required and unique.
			'section_title'  => 'Slides', // (optional) - adds a section title.
			'table_title'    => 'Title', // (optional) - Title that will appear on the tabe.
			'new_title'      => '[Untitled]', // Default title for new elements.
			'remove_label'   => 'Delete Permanently', // the Delete Button label.
			'add_label'      => 'Add New Slide', // the Add New Item button label.
			'row_label_name' => 'title',
			'fields'         =>  array(
				  array(
					'type'         => 'text',
					'name'         => 'title',
					'id'           => 'title',
					'title'        => 'Title',
					'descriptions' => '(This is only for the Admin panel)',
					'placeholder'  => '',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				),
				  array(
					'type'         => 'textarea',
					'name'         => 'quote',
					'id'           => 'quote',
					'title'        => 'Quote Text',
					'descriptions' => '(About 250 Charachters or 40 words)',
					'placeholder'  => '',
					'class_name'   => 'widefat',
					'style'        => 'min-height:40px; max-height: 150px; min-width: 300px; max-width: 300px;'
				),
				array(
					'type'         => 'text',
					'name'         => 'image_url',
					'id'           => 'image_url',
					'title'        => 'Image URL',
					'descriptions' => '(780 x 340 px)',
					'placeholder'  => 'http://',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				),
				array(
					'type'         => 'text',
					'name'         => 'link_url',
					'id'           => 'link_url',
					'title'        => 'Link URL',
					'descriptions' => '(Link for the Green Button)',
					'placeholder'  => 'http://',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				)
			)
		);


		$_slides = array(
			'name'           => 'tfx_home_slides',
			'counter_name'   => 'tfx_home_slides_counter',
			'remove_name'    => 'tfx_home_slides_remove',
			'sort_name'      => 'tfx_home_slides_sort',
			'headline'       => 'Slides',
			'title'          => 'Title',
			'new_title'      => '[Untitled]',
			'remove_label'   => 'Delete Permanently',
			'add_label'      => 'Add New Slide',
			'row_label_name' => 'title',
			'form_items'     =>  array(
				  array(
					'name'         => 'title',
					'title'        => 'Title',
					'type'         => 'text',
					'descriptions' => '(This is only for the Admin panel)',
					'placeholder'  => '',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				),
				  array(
					'name'         => 'quote',
					'title'        => 'Quote Text',
					'type'         => 'textarea',
					'descriptions' => '(About 250 Charachters or 40 words)',
					'placeholder'  => '',
					'class_name'   => 'widefat',
					'style'        => 'min-height:40px; max-height: 150px; min-width: 300px; max-width: 300px;'
				),
				array(
					'name'         => 'image_url',
					'title'        => 'Image URL',
					'type'         => 'text',
					'descriptions' => '(780 x 340 px)',
					'placeholder'  => 'http://',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				),
				array(
					'name'         => 'link_url',
					'title'        => 'Link URL',
					'type'         => 'text',
					'descriptions' => '(Link for the Green Button)',
					'placeholder'  => 'http://',
					'class_name'   => 'widefat regular-text',
					'style'        => ''
				)
			)
		);

		update_option('my_silly_option', $_slides );

		if( isset( $_POST['action'] ) && $_POST['action'] == 'homepage-options' ){
			update_sortlist( $_slides );
		}

		?>
		<div class="wrap">
			<h2>Homepage Options</h2>
			<div style="padding:5px;"></div>

			<form method="post" action="admin.php?page=homepage-options" onSubmit="return parseSlides()" >
				<input type="hidden" name="action" value="homepage-options"/>
				<div class="sep"></div>

				<?php display_sortlist( $_slides ); ?>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>


				<p>
					<h3>This is a sampe Option</h3>
					<?php

						$silly = get_option('my_silly_option');

					?>
					<span style="display:none"><?php print_r( $silly ); ?></span>
					<input type="text" value="<?php echo $silly ?>">
				</p>
			</form>


			<script id="another-row">
				'<tr><td class="drag-handle"></td><td><input type="text" class="slide-image" /></td><td><textarea name="banner-text" style="width:350px; height:60px;"></textarea></td><td><input type="text" class="slide-link" /></td>td class="remove-row"></td></tr>'
			</script>

		</div>

		<?php

	}