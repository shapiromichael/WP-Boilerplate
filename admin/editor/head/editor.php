<?php 

// =============================================================================
// File: head_editor.php
// Version: 1.0
// 
// Indcludes head files for editor_highlight editor
// =============================================================================

// check access


$css_includes = array(
    // CodeMirror core
    'functions/libs/editor/codemirror/codemirror',
    // CodeMirror util
    'functions/libs/editor/codemirror/util/dialog',
    // editor_highlight
    'css/admin/editor/editor_highlight.all.min',
);

$js_includes = array(
    'js/admin/editor/jquery.editor_highlight',
    // CodeMirror core
    'functions/libs/editor/codemirror/codemirror',
    // CodeMirror modes
    'functions/libs/editor/codemirror/mode/clike',
    'functions/libs/editor/codemirror/mode/css',
    'functions/libs/editor/codemirror/mode/htmlmixed',
    'functions/libs/editor/codemirror/mode/javascript',
    'functions/libs/editor/codemirror/mode/mysql',
    'functions/libs/editor/codemirror/mode/php',
    'functions/libs/editor/codemirror/mode/xml',
    // CodeMirror utils
    'functions/libs/editor/codemirror/util/dialog',
    'functions/libs/editor/codemirror/util/formatting',
    'functions/libs/editor/codemirror/util/search',
    'functions/libs/editor/codemirror/util/searchcursor',
    // Keyboard Shortcuts
    'functions/libs/editor/shortcut/shortcut',
    // editor_highlight
    'js/admin/editor/editor_highlight_editor',
);

global $theme_url;

?>

<script type="text/javascript">
    $ = jQuery;
    var editor_highlight_settings = <?php echo json_encode($editor_highlight_settings); ?>;
    var editor_highlight_path = '<?php echo $theme_url."admin/editor/"; ?>';
   
</script>

<style type="text/css">
    .CodeMirror {
        height: 400px;
    }
    .CodeMirror-scroll {
        font-size : <?php echo $editor_highlight_settings['fontSize']; ?>px;
        <?php if($theme == 'default') { ?>background-color: #FAFAFA;<?php } ?>
        height: 100%;
    }
</style>

<?php

foreach($css_includes as $css) editor_highlight_echoCSSinclude($css);
foreach($js_includes as $js) editor_highlight_echoJSinclude($js);
editor_highlight_echoCSSinclude("functions/libs/editor/codemirror/theme/{$editor_highlight_settings['theme']}");

?>