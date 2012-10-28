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
    'functions/libs/editor/codemirror/codemirror',
    // CodeMirror util
    'functions/libs/editor/codemirror/util/dialog',
    'functions/libs/editor/codemirror/util/simple-hint',
    // FileTree
    'functions/libs/editor/jqueryFileTree/jqueryFileTree',
    // Tooltip
    'functions/libs/editor/jquery-tooltip/jquery.tooltip',
    // Synchi
    'css/admin/editor/synchi',
    'css/admin/editor/synchi_ide',
);

$js_includes = array(
    // JQuery UI
    'js/libs/jquery-ui', //need to load minify jQuary ui
    // CodeMirror core
    'functions/libs/editor/codemirror/codemirror',
    // CodeMirror modess
    'functions/libs/editor/lib/codemirror/mode/clike',
    'functions/libs/editor/lib/codemirror/mode/css',
    'functions/libs/editor/lib/codemirror/mode/htmlmixed',
    'functions/libs/editor/lib/codemirror/mode/javascript',
    'functions/libs/editor/lib/codemirror/mode/mysql',
    'functions/libs/editor/lib/codemirror/mode/php',
    'functions/libs/editor/lib/codemirror/mode/xml',
    // CodeMirror utils
    'functions/libs/editor/lib/codemirror/util/dialog',
    'functions/libs/editor/lib/codemirror/util/formatting',
    'functions/libs/editor/lib/codemirror/util/searchcursor',
    'functions/libs/editor/lib/codemirror/util/search',
    'functions/libs/editor/lib/codemirror/util/match-highlighter',
    'functions/libs/editor/lib/codemirror/util/simple-hint',
    'functions/libs/editor/lib/codemirror/util/javascript-hint',
    'functions/libs/editor/lib/codemirror/util/php-hint',
    // FileTree
    'functions/libs/editor/jqueryFileTree/jqueryFileTree',
    // Keyboard Shortcuts
    'functions/libs/editor/shortcut/shortcut',
    // Context Menu
    'functions/libs/editor/contextmenu/jquery.contextmenu.r2.packed',
    // Tooltip
    'functions/libs/editor/jquery-tooltip/jquery.tooltip',
    // Synchi
    'js/admin/editor/jquery.synchi',
    'js/admin/editor/synchi_ide',
);

?>

<script type="text/javascript">
    $ = jQuery;
    var synchi_settings = <?php echo json_encode($synchi_settings); ?>;
    var synchi_editor_root = '<?php echo $editor_root; ?>/';
    var synchi_editor_mode = '<?php echo $editor_mode; ?>/';
    var synchi_path = '<?php echo $theme_url."admin/editor/"; ?>';
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
if($synchi_settings['theme'] != 'default') synchi_echoCSSinclude("functions/libs/editor/codemirror/theme/{$synchi_settings['theme']}");

?>