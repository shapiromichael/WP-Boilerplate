<?php
	

/**
 *	Utility function - to retrieve a param from the data array.
 *	Give a key and recieve a value.
 *	Use it anywhere in the theme to display param options.
 */
function get_param( $key ) {
	return Params::get( $key );
}


/**
 *	Utility function prints HTML of all the params as form input fields.
 *	Use it on dashboard, when you want to display the params as input fields.
 */
function show_param_options() {
	return Params::screen();
}


/**
 *	Utility function to update the params.
 *	Use it on dashboard, when you update the params.
 */
function update_param_options() {
	return Params::update();
}


function initialize_param_data() {
	global $OPTIONS_PARAMS_SECTIONS, $OPTIONS_PARAMS;
	Params::init( array(
		'name'     => 'options-params',
		'sections' => $OPTIONS_PARAMS_SECTIONS,
		'fields'   => $OPTIONS_PARAMS
	) );
}
add_filter( 'init', 'initialize_param_data' );


class Params {

	static private $params = array();
	static private $defaults = array(
		'name'     => 'unnammed_settings_set',
		'method'   => 'post',
		'trim'     => true,
		'sections' => array(),
		'fields'   => array()
	);
	static private $data = array();
	static private $is_initialized;


	public static function init( $args ) {

		// if aleady initialized - there there is nothing to do here.
		if( self::$is_initialized ) {
			return;
		}
		
		self::$is_initialized = true;
		self::$params = $args; //array_merge( self::$defaults, $args );

		// Create an empty section 
		if( !count(self::$params['sections']) ) {
			self::$params['sections'] = array(0 => '');
		}

		// Load the data
		self::$data = get_option( self::$params['name'], array() );

	}


	// Public
	public static function get( $key ) {
		return self::$data[ $key ];
	}

	public static function set( $key, $value ) {
		self::$data[ $key ] = $value;
		self::save();
	}

	public static function remove( $key ){
		unset(self::$data[ $key ]);
		self::save();
	}

	public static function screen() {

		foreach (self::$params['sections'] as $section_key => $title) {

			?>
			<h3 class="title"><?php echo $title; ?></h3>
			<table class="form-table">
				<?php

					foreach( self::$params['fields'] as $field_key => $field_args ) {
						$default = array(
							'name'        => 'untitled',
							'title'       => 'Default',
							'description' => '',
							'placeholder' => '',
							'section'     => 0,
							'type'        => 'text'
						);
						$field = array_merge($default,$field_args);

						if( $field['section'] == $section_key ){
							self::draw_field( $field );
						}
					}

				?>
			</table>
			<?php

		}
	}

	public static function update() {
		foreach( self::$params['fields'] as $key => $field ) {
			$value = (self::$params['method'] == 'get' && isset($_GET[$field['name']])) ? $_GET[$field['name']] : (isset($_POST[$field['name']])) ? $_POST[$field['name']] : '' ;
			$value = (self::$params['trim']) ? trim( $value ) : $value ;
			if( $value ){
				self::$data[ $field['name'] ] = $value;
			}
		}
		self::save();
	}

	// Private
	private static function draw_field( $field ){
		switch( $field['type'] ){
			default: // Text field
				?>
				<tr>
					<th scope="row"><?php echo $field['title'] ?>:</th>
					<td>
						<input type="text" name="<?php echo $field['name'] ?>" class="regular-text" value="<?php echo self::get( $field['name'] ) ?>" >
						<?php echo ($field['description']) ? '<p class="description">(' . $field['description'] . ')</p>': '' ; ?>
					</td>
				</tr>
				<?php
			break;
		}
	}

	private static function save() {
		update_option( self::$params['name'], self::$data );
	}


} // Params