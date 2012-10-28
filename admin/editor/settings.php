<?php 
  // echo "settings.php loaded"."<br>";  
// =============================================================================
// File: settings.php
// Version: 2.0
// 
// Renders editor_highlight settings.
// =============================================================================

// check access
if(!defined('editor_highlight')) exit('Direct access is not allowed...'); 

?>

<script type="text/javascript">
    $(function(){
        console.log(this);
        $("#editor_highlight_theme").change(function(){
            $("#editor_highlight_theme_preview").attr('src','<?php echo $theme_url; ?>img/theme-previews/' + $(this).val() + '.png');
        });
        $("#editor_highlight_theme").change();
    });
</script>

<div class="wrap">
    
    <h2>editor_highlight Settings</h2>
    
    <form method="post" action="<?php echo $admin_url; ?>/index.php">
        
        <h3>Global Settings</h3>
        <table class='form-table'>
            <tr valign='top'>
                <th scope='row'>editor_highlight IDE in Plugins Editor</th>
                <td>
                    <select name="editor_highlight_option_flag_plugins">
                        <option value="0" <?php if($editor_highlight_settings['flag_plugins'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['flag_plugins'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>editor_highlight IDE in Themes Editor</th>
                <td>
                    <select name="editor_highlight_option_flag_themes">
                        <option value="0" <?php if($editor_highlight_settings['flag_themes'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['flag_themes'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>editor_highlight Editor in Articles Editor</th>
                <td>
                    <select name="editor_highlight_option_flag_articles">
                        <option value="0" <?php if($editor_highlight_settings['flag_articles'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['flag_articles'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <h3>Editing Settings</h3>
        <table class='form-table'>
            <tr valign='top'>
                <th scope='row'>Line Numbers</th>
                <td>
                    <select name="editor_highlight_option_lineNumbers">
                        <option value="0" <?php if($editor_highlight_settings['lineNumbers'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['lineNumbers'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>Match Brackets</th>
                <td>
                    <select name="editor_highlight_option_matchBrackets">
                        <option value="0" <?php if($editor_highlight_settings['matchBrackets'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['matchBrackets'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>Font size (px)</th>
                <td>
                    <select name="editor_highlight_option_fontSize">
                        <?php for($i=10; $i<=16; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php if($editor_highlight_settings['fontSize'] == $i) echo 'selected="selected"'; ?>><?php echo $i; ?> px</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>Tab Size</th>
                <td>
                    <select name="editor_highlight_option_tabSize">
                        <option value="2" <?php if($editor_highlight_settings['tabSize'] == 2) echo 'selected="selected"'; ?>>2</option>
                        <option value="3" <?php if($editor_highlight_settings['tabSize'] == 3) echo 'selected="selected"'; ?>>3</option>
                        <option value="4" <?php if($editor_highlight_settings['tabSize'] == 4) echo 'selected="selected"'; ?>>4</option>
                        <option value="5" <?php if($editor_highlight_settings['tabSize'] == 5) echo 'selected="selected"'; ?>>5</option>
                        <option value="6" <?php if($editor_highlight_settings['tabSize'] == 6) echo 'selected="selected"'; ?>>6</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>Indent With Tabs</th>
                <td>
                    <select name="editor_highlight_option_indentWithTabs">
                        <option value="0" <?php if($editor_highlight_settings['indentWithTabs'] == 0) echo 'selected="selected"'; ?>>no</option>
                        <option value="1" <?php if($editor_highlight_settings['indentWithTabs'] == 1) echo 'selected="selected"'; ?>>yes</option>
                    </select>
                </td>
            </tr>
            <tr valign='top'>
                <th scope='row'>Theme</th>
                <td>
                    <select id="editor_highlight_theme" name="editor_highlight_option_theme">
                        <?php foreach($editor_highlight_themes as $theme_option) { ?>
                        <option 
                            value="<?php echo $theme_option; ?>" 
                            <?php if($theme_option == $theme) echo 'selected="selected"'; ?>>
                            <?php echo $theme_option; ?>
                        </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope='row'></th>
                <td>
                    theme preview:<br />
                    <img id="editor_highlight_theme_preview" src="" style="width: 590px; height: 300px; border: 1px solid black;" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
        <input type="hidden" name="editor_highlight_action" value="update_settings" />
    </form>

</div>