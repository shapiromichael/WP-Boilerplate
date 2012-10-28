<?php

	add_action('profile_personal_options', 'user_html_theme_style');
	function user_html_theme_style( $user ) {

		global $theme_url, $editor_highlight_themes, $default_theme;
		$themes    = $editor_highlight_themes;
		$thumb_src = $theme_url.'images/admin/editor/theme-previews/';
		$theme     = get_user_meta( $user->ID, 'user_editor_theme', true );
    	$theme     = ( empty($theme) && in_array($theme, $editor_highlight_themes) ) ? $default_theme : $theme ;
		?>
		<link rel="stylesheet" href="<?php echo $thumb_src.'thumbs.css';?>">
			<h3>Choose HTML Editor Style</h3>
			<table class="form-table">
				<tr>
					<th valign="top">
						<select name="chosenTheme" id="themeSelect">
							<?php
								$counter = 0;
								foreach( $themes as $value ) {
									$counter + 1;
									?><option value="<?php echo $value; ?>" <?php echo ($theme == $value) ? 'selected="selected"': '' ; ?> ><?php echo ucfirst( $value ); ?></option><?php
								}
							?>
						</select>
					</th>
					<td>
						<div id="curr-theme-img" class=""/>
					</td>
				</tr>
			</table>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script type="text/javascript">

				$(document).ready(function(){
					var img           = $('#curr-theme-img');
					var themeSelect   = $("#themeSelect");
					themeSelectOption = $("#themeSelect > option");
					refresh_img_class();

					themeSelect.on("change",function(){
						refresh_img_class();
					});
					
					function refresh_img_class(){
						var val = $("#themeSelect option:selected").val();
						img.attr("class",val);
					}
				});
			</script>
		<?php
	}

	function update_theme( $user_id ){
		$val = $_POST['chosenTheme'];
		update_user_meta( $user_id, "user_editor_theme", $val);
	}
	// add_action('edit_user_profile_update','update_theme');
	add_action('personal_options_update','update_theme'); 



