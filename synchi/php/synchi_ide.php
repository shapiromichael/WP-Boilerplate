<?php 
    
// =============================================================================
// File: ide.php
// Version: 1.0
// 
// Renders editor HTML.
// =============================================================================

// check access
if(!defined('SYNCHI')) exit('Direct access is not allowed...'); 

// define editor controls
$editor_controls = array(
    'save','save_all','spacer',
    'find_prev','search','find_next','search_replace','spacer',
    'indent_left','format','indent_right','spacer',
    'undo','redo','spacer',
    'goto','fullscreen'
);

// define sidebar controls
$sidebar_controls = array(
    'new_file' => 'New File',
    'new_folder' => 'New Folder',
    'delete' => 'Delete',
    'cut' => 'Cut',
    'copy' => 'Copy',
    'paste' => 'Paste',
    //'upload' => 'Upload',
    //'download' => 'Download',
);

// define tab controls
$tab_controls = array(
    'close' => 'Close',
    'close_other' => 'Close Other',
    'close_all' => 'Close All',
);

if(!isset($editor_mode)) $editor_mode = 'Files';

?>

<div id="synchi_ide">
    <table width="100%" height="500" cellpadding="0" cellspacing="0">
        <tr style="height: 30px; vertical-align: bottom">
            <td style="width: 5px;"></td>
            <td style="border-bottom: 1px solid #DFDFDF;">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                    <tr style="vertical-align: bottom">
                        <td width="5"></td>
                        <td><div id="synchi_ide_tabs"></div></td>
                        <td width="5"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 10px;"></td>
            <td style="width: 300px; border-bottom: 1px solid #DFDFDF; text-align: center; font-size: 10px; font-weight: bold">
                - <?php echo ucfirst($editor_mode); ?> -
            </td>
            <td style="width: 5px;"></td>
        </tr>
        <tr style="vertical-align: top">
            <td style="width: 5px;"></td>
            <td style="border-left: 1px solid #DFDFDF; ">
                <div style="margin-right: 6px;">
                    <div id="synchi_ide_editor"></div>
                </div>
            </td>
            <td style="width: 10px; border-left: 1px solid #DFDFDF;"></td>
            <td style="width: 300px; border-left: 1px solid #DFDFDF; border-right: 1px solid #DFDFDF;">
                <div id="synchi_ide_sidebar" tabindex="0"></div>
            </td>
            <td style="width: 5px;"></td>
        </tr>
        <tr style="height: 30px">
            <td style="width: 5px;"></td>
            <td style="border-top: 1px solid #DFDFDF; text-align: right">
                <div id="synchi_ide_editor_controls">
                    <?php
                    foreach($editor_controls as $control) {
                        $src = $synchi_url . "/synchi/img/ide/$control.png";
                        switch($control) {
                            case 'save' :$title = 'Save (Ctrl-S)';break;
                            case 'save_all' :$title = 'Save All (Ctrl-Shift-S)'; break;
                            case 'search' :$title = 'Search (Ctrl-F)';break;
                            case 'find_prev' :$title = 'Find Previous (Ctrl-left)';break;
                            case 'find_next' :$title = 'Find Next (Ctrl-Right)';break;
                            case 'search_replace' :$title = 'Replace (Ctrl-R)';break;
                            case 'format' :$title = 'Format (Alt-Shift-F)';break;
                            case 'indent_left' :$title = 'Indent left (Alt-Shift-Left)';break;
                            case 'indent_right' :$title = 'Indent right (Alt-Shift-Right)';break;
                            case 'undo' :$title = 'Undo (Ctrl-Z)';break;
                            case 'redo' :$title = 'Redo (Ctrl-Y)';break;
                            case 'goto' :$title = 'Go to line (Ctrl-G)';break;
                            case 'fullscreen' :$title = 'Toggle Fullscreen (Alt-Enter)';break;
                            //case 'comment' :$title = 'Comment Selection (Alt+Shift+/)';break;
                            default :$title = 'action';
                        }
                    ?>
                    <?php if($control == "spacer") { ?>
                    <a href="#" onclick="return false;" class="synchi_spacer"><img src="<?php echo $src; ?>" border="0" /></a>
                    <?php } else { ?>
                    <a href="#" onclick="synchiIDE_editor_action('<?php echo $control; ?>'); return false;" title="<?php echo $title; ?>"><img src="<?php echo $src; ?>" border="0" /></a>
                    <?php }} ?>
                </div>
            </td>
            <td style="width: 10px;"></td>
            <td style="width: 300px; border-top: 1px solid #DFDFDF; text-align: right">
                <span id="synchi_ide_sidebar_filesize"></span>
            </td>
            <td style="width: 5px;"></td>
        </tr>
    </table>
    <br style="clear: both" />
</div>

<div class="contextMenu" id="synchi_ide_sidebar_menu" style="display: none">
    <ul>
        <?php foreach($sidebar_controls as $control => $title) { ?>
        <li id="synchi_sidebar_<?php echo $control; ?>"><img src="<?php echo $synchi_url . "/synchi/img/ide/menu/$control.png"; ?>" /> <?php echo $title; ?></li>
        <?php } ?>
    </ul>
</div>

<div class="contextMenu" id="synchi_ide_tabs_menu" style="display: none">
    <ul>
        <?php foreach($tab_controls as $control => $title) { ?>
        <li id="synchi_tabs_<?php echo $control; ?>"><img src="<?php echo $synchi_url . "/synchi/img/ide/menu/$control.png"; ?>" /> <?php echo $title; ?></li>
        <?php } ?>
    </ul>
</div>