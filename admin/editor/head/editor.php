<?php 

// =============================================================================
// File: head_editor.php
// Version: 1.0
// 
// Indcludes head files for synchi editor
// =============================================================================

// check access


$css_includes = array(
    // CodeMirror core
    'functions/libs/editor/codemirror/codemirror',
    // CodeMirror util
    'functions/libs/editor/codemirror/util/dialog',
    // Synchi
    'css/admin/editor/synchi',
    'css/admin/editor/synchi_editor',
);

$js_includes = array(
    'js/admin/editor/jquery.synchi',
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
    // Synchi
    'js/admin/editor/synchi_editor',
);

global $theme_url;

?>

<script type="text/javascript">
    $ = jQuery;
    var synchi_settings = <?php echo json_encode($synchi_settings); ?>;
    var synchi_path = '<?php echo $theme_url."admin/editor/"; ?>';
   
</script>

<style type="text/css">
    .CodeMirror {
        height: 400px;
    }
    .CodeMirror-scroll {
        font-size : <?php echo $synchi_settings['fontSize']; ?>px;
        <?php if($theme == 'default') { ?>background-color: #FAFAFA;<?php } ?>
        height: 100%;
    }
</style>

<?php

foreach($css_includes as $css) synchi_echoCSSinclude($css);
foreach($js_includes as $js) synchi_echoJSinclude($js);
synchi_echoCSSinclude("functions/libs/editor/codemirror/theme/{$synchi_settings['theme']}");

?>