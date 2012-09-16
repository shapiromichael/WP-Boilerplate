<?php

class Settings {

	// Data members
	private $params = array();
	private $defaults = array(
		'name'     => 'unnammed_settings_set',
		'method'   => 'post',
		'trim'     => true,
		'sections' => array(),
		'fields'   => array()
	);
	private $data = array();

	// Constructor
	function __construct( $args ) {
		$this->params = array_merge( $this->defaults, $args );

		// Create an empty section 
		if( !count($this->params['sections']) ){
			$this->params['sections'] = array(0 => '');
		}

		// Load the data
		$this->data = get_option( $this->params['name'], array());
	}

	// Public
	public function get( $key ){
		return $this->data[ $key ];
	}

	public function set( $key, $value ){
		$this->data[ $key ] = $value;
		$this->save();
	}

	public function remove( $key ){
		unset($this->data[ $key ]);
		$this->save();
	}

	public function screen(){
		foreach ($this->params['sections'] as $section_key => $title) {

			?>
			<h3 class="title"><?php echo $title; ?></h3>
			<table class="form-table">
				<?php

				foreach( $this->params['fields'] as $field_key => $field_args ) {
					$default = array(
						'name'        => 'untitled',
						'title'       => 'Default',
						'description' => '',
						'placeholder' => '',
						'section'	  => 0,
						'type'        => 'text'
					);
					$field = array_merge($default,$field_args);

					if( $field['section'] == $section_key ){
						$this->draw_field( $field );
					}
				}

				?>
			</table>
			<?php

		}
	}

	public function update(){
		foreach( $this->params['fields'] as $key => $field ) {
			$value = ($this->params['method'] == 'get' && isset($_GET[$field['name']])) ? $_GET[$field['name']] : (isset($_POST[$field['name']])) ? $_POST[$field['name']] : '' ;
			$value = ($this->params['trim']) ? trim( $value ) : $value ;
			if( $value ){
				$this->data[ $field['name'] ] = $value;
			}
		}
		$this->save();
	}

	// Private
	private function draw_field( $field ){
		switch( $field['type'] ){
			default: // Text field
				?>
				<tr>
					<th scope="row"><?php echo $field['title'] ?>:</th>
					<td>
						<input type="text" name="<?php echo $field['name'] ?>" class="regular-text" value="<?php echo $this->get( $field['name'] ) ?>" >
						<?php echo ($field['description']) ? '<p class="description">(' . $field['description'] . ')</p>': '' ; ?>
					</td>
				</tr>
				<?php
			break;
		}
	}

	private function save(){
		update_option( $this->params['name'], $this->data);
	}

}