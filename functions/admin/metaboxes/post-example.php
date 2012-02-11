<?php
	
	// Example post metabox
	function theme_post_example_metabox(){
		add_meta_box( 'traffix-page-options', 'Example Metabox Title', 'theme_post_example_metabox_form', 'post', 'side');
	}
	add_action("admin_init", 'theme_post_example_metabox');
	
	// The metabox editing form
	function theme_post_example_metabox_form(){
		global $post;

		$custom = get_post_custom( $post->ID );

		$example_title = '';
		
		if( isset($custom['example_title']) ){
			$example_title = $custom['example_title'][0];
		}
		
		?>
			<p>
				<label for="example_title">Title: </label>
				<input type="text" id="example_title" name="example_title" value="<?php echo $example_title; ?>" />
			</p>
		<?php
	}

	// The metabox update function
	function theme_post_example_metabox_update(){
		global $post;

		// veify theat you are in a correct post type
		if( !isset($_POST['post_type']) || 'post' != $_POST['post_type'] ){
			return;
		}

		// verify if this is an auto save routine. 
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return;
		}
		
		// Remove the old values
		delete_post_meta($post->ID, 'example_title');

		// Asd the New Values
		if( isset($_POST['example_title']) ){
			add_post_meta( $post->ID, 'example_title', $_POST['example_title'], true );
		}

	}
	add_action( 'save_post','theme_post_example_metabox_update');
	