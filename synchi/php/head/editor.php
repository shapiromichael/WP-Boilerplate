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
    'lib/codemirror/codemirror',
    // CodeMirror util
    'lib/codemirror/util/dialog',
    // Synchi
    'css/synchi',
    'css/synchi_editor',
);

$js_includes = array(
    'js/jquery.synchi',
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
    // Synchi
    'js/synchi_editor',
);

global $synchi_url;
?>

<script type="text/javascript">
    $ = jQuery;
    var synchi_settings = <?php echo json_encode($synchi_settings); ?>;
    var synchi_path = '<?php echo $synchi_url; ?>';
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
synchi_echoCSSinclude("lib/codemirror/theme/{$synchi_settings['theme']}");

?>