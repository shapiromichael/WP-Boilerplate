<?php

	function theme_sortlist(){

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
					'title'        => 'Title',
					'description'  => 'This is only for the Admin panel',
					'placeholder'  => '',
					'class'        => 'widefat regular-text',
					'style'        => ''
				),
				
				array(
					'type'         => 'textarea',
					'name'         => 'quote',
					'title'        => 'Quote Text',
					'description'  => 'About 250 Charachters or 40 words',
					'placeholder'  => '',
					'class'        => 'widefat', // widefat is a class used by the dashboard CSS - make the field as wide as it can fix
					'style'        => 'min-height:40px; max-height: 150px; min-width: 300px; max-width: 300px;'
				),

				array(
					'type'         => 'select',
					'name'         => 'effect',
					'title'        => 'Select Effect',
					'description'  => 'Effect of the slide',
					'class'        => '',
					'style'        => '',
					'options'      => array( // You must provide key and value pairs - only values wont work.
						'val'      => 'Text',
						'random'   => 'Random',
						'slideup'  => 'Slide Up'
					)
				),

				array(
					'type'         => 'check', // 'checkbox'
					'name'         => 'hide',
					'title'        => 'display to logged in users only',
					'description'  => 'the user must log in to see this',
					'class'        => '', // Class attribut of the tag.
					'style'        => '', // Style attribut of the tag.
					'options'      => array( // You must provide key and value pairs - only values wont work.
						'val'      => 'Text',
						'random'   => 'Random',
						'slideup'  => 'Slide Up'
					)
				),

				array(
					'type'         => 'checkbox',
					'name'         => 'hide-on',
					'title'        => 'display to logged in users only',
					'description'  => 'the user must log in to see this',
					'class'        => '', // Class attribut of the tag.
					'style'        => '', // Style attribut of the tag.
					'options'      => array( // You must provide key and value pairs - only values wont work.
						'val'      => 'Text',
						'random'   => 'Random',
						'slideup'  => 'Slide Up'
					)
				),

				array(
					'type'         => 'radio', // Radio Buttons group
					'name'         => 'job',
					'title'        => 'Select Effect',
					'description'  => 'Effect of the slide',
					'class'        => '',
					'style'        => '',
					'buttons'      => array(
						array(
							'id'       => 'qa',
							'label'    => 'QA',
							'value'    => 'qa',
							'selected' => true // (optional) Selected by default - if no other option is selected.
						),
						array(
							'id'       => 'web',
							'label'    => 'Web Developer',
							'value'    => 'web'
						),
						array(
							'id'       => 'team',
							'label'    => 'Team Leader',
							'value'    => 'team'
						)
					)
				),

				array(
					'type'         => 'date',
					'name'         => 'birthday',
					'title'        => 'Birthday',
					'description'  => 'Select the date that you were born.'
 				),

 				array(
					'type'         => 'color',
					'name'         => 'bg',
					'title'        => 'Button Color',
					'description'  => 'Choose a color for the button',
					'color'        => 'F2F2F2' // Default color, when no color is set - HEXA value please.
 				),

 				array(
					'type'         => 'editor',
					'name'         => 'editme',
					'title'        => 'Put some pretty text',
					'settings'     => array(
						'wpautop'       => true, // Whether to use wpautop for adding in paragraphs
						'media_buttons' => false, // Whether to display media insert/upload buttons
						'textarea_rows' => 10, // The number of rows to display for the textarea
						'teeny'         => true // Whether to output the minimal editor configuration used in PressThis
						// 'tinymce'       => array() // Load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
					)
 				)

			)
		);


		if( isset( $_POST['action'] ) && $_POST['action'] == 'sortlist' ){
			// new_sortlist_update( $items_structure );
			update_sortlist( $items_structure );

		}

		?>
		<div class="wrap">
			<h2>Sortlist</h2>
			<div style="padding:5px;"></div>

			<form method="post" action="admin.php?page=sortlist" >
				<input type="hidden" name="action" value="sortlist"/>
				<div class="sep"></div>

				<?php display_sortlist( $items_structure ); ?>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>

			</form>

		</div>


		<?php

	}