<?php 
    
// =============================================================================
// File: head_ide.php
// Version: 2.6
// 
// Indcludes head files for synchi IDE
// =============================================================================

// check access
if(!defined('SYNCHI')) exit('Direct access is not allowed...'); 

$css_includes = array(
    // CodeMirror core
    'lib/codemirror/codemirror',
    // CodeMirror util
    'lib/codemirror/util/dialog',
    'lib/codemirror/util/simple-hint',
    // FileTree
    'lib/jqueryFileTree/jqueryFileTree',
    // Tooltip
    'lib/jquery-tooltip/jquery.tooltip',
    // Synchi
    'css/synchi',
    'css/synchi_ide',
);

$js_includes = array(
    // JQuery UI
    'lib/jquery/jquery-ui-1.8.21.custom.min',
    // CodeMirror core
    'lib/codemirror/codemirror',
    // CodeMirror modess
    'lib/codemirror/mode/clike',
    'lib/codemirror/mode/css',
    'lib/codemirror/mode/htmlmixed',
    'lib/codemirror/mode/javascript',
    'lib/codemirror/mode/mysql',
    'lib/codemirror/mode/php',
    'lib/codemirror/mode/xml',
    // CodeMirror utils
    'lib/codemirror/util/dialog',
    'lib/codemirror/util/formatting',
    'lib/codemirror/util/searchcursor',
        'lib/codemirror/util/search',
        'lib/codemirror/util/match-highlighter',
    'lib/codemirror/util/simple-hint',
    'lib/codemirror/util/javascript-hint',
    'lib/codemirror/util/php-hint',
    // FileTree
    'lib/jqueryFileTree/jqueryFileTree',
    // Keyboard Shortcuts
    'lib/shortcut/shortcut',
    // Context Menu
    'lib/contextmenu/jquery.contextmenu.r2.packed',
    // Tooltip
    'lib/jquery-tooltip/jquery.tooltip',
    // Synchi
    'js/jquery.synchi',
    'js/synchi_ide',
);

?>

<script type="text/javascript">
    $ = jQuery;
    var synchi_settings = <?php echo json_encode($synchi_settings); ?>;
    var synchi_editor_root = '<?php echo $editor_root; ?>/';
    var synchi_editor_mode = '<?php echo $editor_mode; ?>/';
    var synchi_path = '<?php echo $synchi_url; ?>';
    var synchi_serialized_tabs = <?php echo json_encode($serialized_tabs) ?>;
</script>

<style type="text/css">
    .CodeMirror-scroll {
        font-size : <?php echo $synchi_settings['fontSize']; ?>px;
        <?php if($theme == 'default') { ?>background-color: #FAFAFA;<?php } ?>
    }
</style>

<?php

foreach($css_includes as $css) synchi_echoCSSinclude($css);
foreach($js_includes as $js) synchi_echoJSinclude($js);
if($synchi_settings['theme'] != 'default') synchi_echoCSSinclude("lib/codemirror/theme/{$synchi_settings['theme']}");

?>