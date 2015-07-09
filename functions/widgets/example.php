<?php

class BP_Example_Widget extends WP_Widget {
	
	// Constructor
	function __construct() {
		parent::WP_Widget( 'theme_example_widget_id', 'Widget Title', array( 'description' => 'This is a simple description which will show up below the title on the widgets dashboard' ) );
	}

	// The widget view
	function widget( $args, $instance ) {
		extract( $args );

		$title = $instance['title'];

		echo $before_widget;
		?>
			<h3 class="widget-title"><?php echo $title; ?></h3>
		<?php
		echo $after_widget;

	}

	// Updating the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	// The widget editing form
	function form( $instance ) {
		$title = ($instance) ? esc_attr( $instance[ 'title' ] ) : '' ;
		
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
		<?php
				
	}

}
register_widget('BP_Example_Widget');
