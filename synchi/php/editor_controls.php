<?php 

  
// =============================================================================
// File: editor_controls.php
// Version: 1.0
// 
// Renders controls for article editor
// =============================================================================
$editor_highlight_url = get_bloginfo('template_url') . '/editor_highlight/'; //1)this is instead the $editor_highlight_url
// check access
if(!defined('editor_highlight')) exit('Direct access is not allowed...'); 

// define editor controls
$editor_controls = array(
    'find_prev','search','find_next','search_replace','spacer',
    'indent_left','format','indent_right','spacer',
    'undo','redo','spacer',
    'goto','fullscreen'
);

?>

<div id="ed_toolbar" class="editor_highlight_editor_controls">
    <?php
    foreach ($editor_controls as $control) {
        $src = $editor_highlight_url . "img/ide/$control.png";

        switch ($control) {
            case 'search' :$title = 'Search (Ctrl-F)';
                break;
            case 'find_prev' :$title = 'Find Previous (Ctrl-left)';
                break;
            case 'find_next' :$title = 'Find Next (Ctrl-Right)';
                break;
            case 'search_replace' :$title = 'Replace (Ctrl-R)';
                break;
            case 'format' :$title = 'Format (Alt-Shift-F)';
                break;
            case 'indent_left' :$title = 'Indent left (Alt-Shift-Left)';
                break;
            case 'indent_right' :$title = 'Indent right (Alt-Shift-Right)';
                break;
            case 'undo' :$title = 'Undo (Ctrl-Z)';
                break;
            case 'redo' :$title = 'Redo (Ctrl-Y)';
                break;
            case 'goto' :$title = 'Go to line (Ctrl-G)';
                break;
            case 'fullscreen' :$title = 'Toggle Fullscreen (Alt-Enter)';
                break;
            default :$title = 'action';
        }
        ?>
    <?php if ($control == "spacer") { ?>
            <a href="#" onclick="return false;" class="editor_highlight_spacer"><img src="<?php echo $src; ?>" border="0" /></a>
    <?php } else { ?>
            <a href="#" onclick="editor_highlight_Control('<?php echo $control; ?>'); return false;" title="<?php echo $title; ?>"><img src="<?php echo $src; ?>" border="0" /></a>
    <?php }
} ?>
</div>