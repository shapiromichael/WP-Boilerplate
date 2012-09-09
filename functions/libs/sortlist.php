<?php


function update_sortlist( $structure ) {
	$sl = new WP_SortList();
	$sl->update_sortlist( $structure );
}

function display_sortlist( $structure ) {
	$sl = new WP_SortList();
	$sl->display_sortlist( $structure );
}

/**
 * Class WP_SortList
 *
 * Displays and updates the sortlist component
 */
class WP_SortList {

	// $_structure = '';


	function __construct(){
		// $this->_structure = $_sotrlist_struncture;
	}


	/**
	 * Function update_sortlist
	 *
	 * Updates the sortlist data (content and order).
	 *
	 * @param (array) $sort_data: contains the sortlist structure
	 */
	function update_sortlist( $sort_data ) {
		$sort_name = $sort_data['name'];
		$order     = $_POST[ $sort_name . '_order' ];
		$deleted   = $_POST[ $sort_name . '_deleted' ];

		$order   = explode(',', $order);
		$deleted = explode(',', $deleted);

		$new_data = array();
		$index = 0;

		if( !empty($_POST[$sort_name]) ) {
			foreach( $_POST[$sort_name] as $val ) {
				$item_position = array_shift( $order );
				$new_data[ $index ] = $_POST[ $sort_name ][ $item_position ];
				$index += 1;
			}
		}

		if( isset( $_POST['add-new-sortlist-item'] ) && !empty($_POST['add-new-sortlist-item']) ) {
			$new_data[ $index ] = array('_' => '&nbsp;');
		}

		update_option( $sort_name, $new_data );
	}


	/**
	 * Function display_sortlist
	 *
	 * Displays the sortlist component
	 *
	 * @param (array) $sortlist: containing the sortlist structure
	 */
	function display_sortlist( $sortlist ) {
		// if there is no data - then nothing to do.
		if( empty($sortlist) )
			return;

		$name = $sortlist['name'];

		if( $sortlist['section_title'] ) {
			?><h3 class="tm-title"><?php echo $sortlist['section_title']; ?></h3><?php
		}

		if( $sortlist['table_title'] ) {
			?><div class="sort-list-header"><p><?php echo ( empty($sortlist['table_title'])) ? '&nbsp;' : $sortlist['table_title'] ; ?></p></div><?php
		}

		?>

			<div class="sort-list" data-name="<?php echo $name; ?>" >
				<input type="hidden" name="<?php echo $name; ?>_order" class="order-data" value="" />
				<input type="hidden" name="<?php echo $name; ?>_deleted" value="" />
				<ul>
					<?php

						$data = get_option( $name );
						$index = 0;

						if( !empty($data) ) {
							foreach( $data as $item ) {
								$this->get_item( $sortlist, $item, $index );
								$index += 1;
							}
						}

					?>
				</ul>
				<?php

					if( $sortlist['add_label'] ) {
						?><input type="button" class="button add" value="<?php echo $sortlist['add_label']; ?>" /><?php
					}

				?>
			</div>
		<?php
	}




	/**
	 * Function get_item
	 *
	 * Outputs a single item of the sortlist
	 *
	 * @param (array) $sortlist containing the sortlist structure
	 * @param (array) $item array containing the content of this field
	 * @param (integer) $loop the number of the loop - the order of this field
	 */
	private function get_item( $sortlist, $item, $loop ) {

		if( empty($item) )
			return;

		$title = ($item['title']) ? $item['title'] : '<span>' . $sortlist['new_title'] . '</span>';

		?>
		<li pos="<?php echo $loop; ?>">
			<div class="dragger"></div>
			<div class="label"><?php echo $title; ?></div>
			<div class="details">
				<table class="form-table">
					<tbody>
						<?php
							foreach( $sortlist['fields'] as $field ) {
								$this->get_field( $field, $item, $loop, $sortlist['name'] );
							}
						?>
					</tbody>
				</table>
			</div>
			<?php

				if( $sortlist['remove_label'] ) {
					?><div class="actions"><div class="remove"><?php echo $sortlist['remove_label']; ?></div></div><?php
				}

			?>
		</li>
		<?php
	}



	/**
	 * Function get_field
	 *
	 * Outputs the actual field with the contnet
	 *
	 * @param (array)   $field: about this param
	 * @param (array)   $item: about this param
	 * @param (integer) $loop: the number of the loop - the order of this field
	 * @param (string)  $name: the name of the sorlist component - thi will be a prefix for every field
	 */
	private function get_field( $field, $item, $loop, $name ) {
		if( empty($field) || empty($item) || empty($name) || !isset($field['name']) )
			return;


		$attr_name = 'name="' . $name . '[' . $loop . '][' . $field['name'] . ']" ';
		$attr_id   = 'id="' . $name . '[' . $loop . '][' . $field['name'] . ']" ';
		$val       = $item[ $field['name'] ];
		$class     = ( isset($field['class']) ) ? 'class="textfield ' . $field['class'] . '" ' : 'class="textfield" ' ;
		$style     = ( isset($field['style']) ) ? 'style="' . $field['style'] . '" ' : '' ;


		?>
			<tr valign="top">
				<th scope="row">
					<?php if( $field['type'] != 'check' && $field['type'] != 'checkbox' ) : ?>
						<label for="<?php echo $attr_id; ?>"><?php echo $field['title']; ?></label>
					<?php endif; ?>
				</th>
				<td>
					<?php

						switch( $field['type'] ) {
							case 'textarea':
								$this->get_text_area( $attr_name, $attr_id, $class, $style, $val );
								break;

							case 'select':
								$this->get_select( $field['options'], $attr_name, $attr_id, $class, $style );
								break;

							case 'checkbox': case 'check':
								$this->get_checkbox( $attr_name, $attr_id, $class, $style, $val );
								break;

							case 'radio':
								$this->get_radio_buttons( $field['buttons'], $attr_name, $val, $loop );
								break;

							case 'range':
								break;

							case 'color':
								$this->get_color( $attr_name, $attr_id, $val, $field['color'] );
								break;

							case 'editor':
								$editor_id = $name . '[' . $loop . '][' . $field['name'] . ']';
								$editor_name = $editor_id;
								$this->get_editor( $editor_id, $editor_name, $val, $field['settings'] );
								break;

							case 'date':
								$this->get_date_field( $attr_name, $attr_id, $class, $style, $val );
								break;

							case 'wp_func':
							case 'wp-func':
							case 'wp_function':
							case 'wp-function':
								$func = $field['function'];
								$args = ( isset($field['options']) ) ? $field['options'] : null ;
								$this->get_wordpress_func( $func, $args );
								break;

							default: // text or any other kind of input
								$this->get_text_field( $attr_name, $attr_id, $class, $style, $val, $field['placeholder'] );
								break;
						}


						if( isset( $field['description'] ) ) {
							?>&nbsp;&nbsp;<span class="meta note"><?php echo $field['description']; ?></span><?php
						}

					?>
				</td>
			</tr>
		<?php
	}


	/**
	 * Function get_text_field
	 *
	 * Outputs text field with its content
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $class: the class attribute of the field
	 * @param (string) $style: the style attribute of the field
	 * @param (string) $val: the value
	 * @param (string) $placeholder: the placeholder attribute of the field
	 */
	private function get_text_field( $attr_name, $attr_id, $class, $style, $val, $placeholder = '' ) {
		$placeholder = (!empty($placeholder)) ? ' placeholder="' . $placeholder . '"' : '' ;
		?><input type="text" <?php echo $attr_name . $attr_id . $class . $style . 'value="' . $val . '"' . $placeholder; ?> autocomplete="off" /><?php
	}


	/**
	 * Function get_text_area
	 *
	 * Outputs textarea field with its content
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $class: the class attribute of the field
	 * @param (string) $style: the style attribute of the field
	 * @param (string) $val: the value
	 */
	private function get_text_area( $attr_name, $attr_id, $class, $style, $val ) {
		?><textarea <?php echo $attr_name . $attr_id . $class . $style; ?> ><?php echo $val; ?></textarea><?php
	}


	/**
	 * Function get_date_field
	 *
	 * Outputs date field with its content
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $class: the class attribute of the field
	 * @param (string) $style: the style attribute of the field
	 * @param (string) $val: the value
	 */
	private function get_date_field( $attr_name, $attr_id, $class, $style, $val ) {
		?><input type="date" <?php echo $attr_name . $attr_id . $class . $style . 'value="' . $val . '"'; ?> /><?php
	}


	/**
	 * Function get_radio_buttons
	 *
	 * Outputs a group of radiobuttons.
	 *
	 * @param (array) $buttons: contains a list of all the radio buttons and their properties
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $val: the value
	 * @param (integer) $loop: the number of the loop this field is in
	 */
	private function get_radio_buttons( $buttons, $attr_name, $val, $loop ) {

		if( empty($buttons) )
			return;

		foreach( $buttons as $button ) {

			if( !is_array($button) )
				continue;

			$radio_label = ( isset($button['label']) ) ? $button['label'] : '' ;
			$radio_value = ( isset($button['value']) ) ? $button['value'] : '' ;
			$radio_id    = ( isset($button['id']) ) ? $button['id'] . '_' . $loop : $radio_value . '_' . $loop;

			?>
				<input type="radio" name="<?php echo $attr_name; ?>" id="<?php echo $radio_id; ?>" value="<?php echo $radio_value; ?>" <?php echo ( $val == $radio_value ) ? 'checked="checked"' : '' ; ?> />
				<label for="<?php echo $radio_id; ?>"><?php echo $radio_label; ?></label><br>
			<?php

		}

	}


	/**
	 * Function get_select
	 *
	 * outputs the select field with all its options attributees.
	 *
	 * @param (array) $options: contains an options list for select field
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $class: the class attribute of the field
	 * @param (string) $style: the style attribute of the field
	 */
	private function get_select( $options, $attr_name, $attr_id, $class, $style ) {
		if( empty($options) || !is_array($options) )
			return;

		?><select <?php echo $attr_name . $attr_id . $class . $style; ?> ><?php
			foreach ( $options as $key => $value) {
				?><option value="<?php echo $key; ?>" <?php echo ( $val == $key ) ? 'selected="selected"' : '' ; ?>  ><?php echo $value; ?></option><?php
			}
		?></select><?php
	}


	/**
	 * Function get_checkbox
	 *
	 * Outputs a checkbox.
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $class: the class attribute of the field
	 * @param (string) $style: the style attribute of the field
	 * @param (string) $val: the value
	 */
	private function get_checkbox( $attr_name, $attr_id, $class, $style, $val ) {
		$checked = ( $val ) ? ' checked="checked" ' : '' ;
		?>
			<input type="checkbox" <?php echo $attr_name . $attr_id . $class . $style . $checked; ?> />
			<label for="<?php echo $attr_id; ?>"><?php echo $field['title']; ?></label>
		<?php
	}


	/**
	 * Function get_color
	 *
	 * Outputs a color picker field.
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $val: the value
	 * @param (string) $color: the value
	 */
	private function get_color( $attr_name, $attr_id, $val, $color = '' ) {

		if( !empty($val) ) {
			$color = 'color="' . $val . '"';
		} else {
			$color = ( !empty($color) ) ? 'color="' . $color . '" ' : 'color="FFFFFF" ' ;
		}

		?>
			<div class="sortlist-colorpicker" <?php echo $color; ?> style="background-color:#<?php echo $val; ?>" >
				<input type="hidden" <?php echo $attr_name . $attr_id . 'value="' . $val . '"'; ?> />
			</div>
		<?php
	}

	/**
	 * Function get_color
	 *
	 * Outputs a color picker field.
	 *
	 * @param (string) $attr_name: the name attribute of the field
	 * @param (string) $attr_id: the id attribute of the field
	 * @param (string) $val: the value
	 * @param (string) $color: the value
	 */
	private function get_editor( $attr_id, $attr_name, $content, $settings ) {
		$settings['textarea_name'] = $attr_name;
		?><div class="sortlist-editor"><?php 
			wp_editor( $content, $attr_id, $settings );
		?></div><?php
	}




	/**
	 *	Function get_wordpress_func
	 *
	 *	Calls a wordpress fucntion with any arguemnts that you have passed
	 *
	 * @param (array) arguments - any arguments that the wordpress fucntion might excpect.
	 */
	private function get_wordpress_func( $func_name, $args = null ) {
		if ( function_exists($func_name) ) {
			$func_name( $args );
		}
	}


}