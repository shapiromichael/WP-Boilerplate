<?php
	
	add_action('profile_personal_options', 'user_html_theme_style');
	function user_html_theme_style( $user ) {
		global $theme_url, $synchi_themes, $default_theme;

		$themes    = $synchi_themes;
		$thumb_src = $theme_url.'images/admin/editor/theme-previews/';
		$theme     = get_user_meta( $user->ID, 'user_editor_theme', true );
    	$theme     = ( empty($theme) && in_array($theme, $synchi_themes) ) ? $default_theme : $theme ;
		?>
			<table>
				<tr>
					<th>Choose HTML Editor Style</th>
				</tr>
				<tr>
					<td valign="top">Select Theme</td>
					<td valign="top"></td>
				</tr>
				<tr>
					<td valign="top">
						<select name="chosenTheme" id="themeSelect">
							<?php

								$counter = 0;
								foreach( $themes as $value ) {
									$counter + 1;
									?><option value="<?php echo $value; ?>" <?php echo ($theme == $value) ? 'selected="selected"': '' ; ?> ><?php echo ucfirst( $value ); ?></option><?php
								}
							?>
						</select>
					</td>
					<td>
						<img id="currThemeImg" src="<?php echo $thumb_src.$themes[1].'.png';?>" height="50%"/>
					</td>
				</tr>
			</table>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script type="text/javascript">

				$(document).ready(function(){
					var img=$('#currThemeImg');
					var themeSelect = $("#themeSelect");
					themeSelectOption=$("#themeSelect > option");
					var imgSrc = img.attr("src");
					var previewImgSrc="<?php echo $thumb_src;?>";
					refresh_img_url();

					themeSelect.on("change",function(){
						refresh_img_url();
					});
					
					function refresh_img_url(){
						var val=$("#themeSelect option:selected").val();
						img.attr("src",previewImgSrc+val+".png");
					}
				});
			</script>
		<?php
	}

	function update_theme( $user_id ){
		$val = $_POST['chosenTheme'];
		update_user_meta( $user_id, "user_editor_theme", $val);
	}
	add_action('edit_user_profile_update','update_theme');
	add_action('personal_options_update','update_theme');



