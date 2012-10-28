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
    'lib/codemirror/codemirror',
    // CodeMirror util
    'lib/codemirror/util/dialog',
    // editor_highlight
    'css/editor_highlight',
    'css/editor_highlight_editor',
);

$js_includes = array(
    'js/jquery.editor_highlight',
    // CodeMirror core
    'lib/codemirror/codemirror',
    // CodeMirror modes
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
    'lib/codemirror/util/search',
    'lib/codemirror/util/searchcursor',
    // Keyboard Shortcuts
    'lib/shortcut/shortcut',
    // editor_highlight
    'js/editor_highlight_editor',
);

global $editor_highlight_url;
?>

<script type="text/javascript">
    $ = jQuery;
    var editor_highlight_settings = <?php echo json_encode($editor_highlight_settings); ?>;
    var editor_highlight_path = '<?php echo $editor_highlight_url; ?>';
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
editor_highlight_echoCSSinclude("lib/codemirror/theme/{$editor_highlight_settings['theme']}");

?>