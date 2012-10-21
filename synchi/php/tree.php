<?php 
    
// =============================================================================
// File: tree.php
// Version: 1.0
// 
// File system tree generator.
// =============================================================================

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) return true;
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

function file_size($file) { 
    $bytes = @filesize($file);
    $precision = 2;
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

$_POST['dir'] = urldecode($_POST['dir']);

if(endsWith($_POST['dir'], "/plugins/")) $synchi_mode = "plugins";
else if(endsWith($_POST['dir'], "/themes/")) $synchi_mode = "themes";
else $synchi_mode = "unknown";

if (file_exists($root . $_POST['dir'])) {
    $files = scandir($root . $_POST['dir']);
    natcasesort($files);
    if (count($files) > 2) { /* The 2 accounts for . and .. */
        echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
        // All dirs
        foreach ($files as $file) {
            if (file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file)) {
                echo "<li class=\"directory collapsed\"><a filesize=\"".file_size($root . $_POST['dir'] . $file)."\" href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
            }
        }
        // All files
        if($synchi_mode == "unknown") foreach ($files as $file) {
            if (file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file)) {
                $ext = preg_replace('/^.*\./', '', $file);
                echo "<li class=\"file ext_$ext\"><a filesize=\"".file_size($root . $_POST['dir'] . $file)."\" href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
            }
        }
        echo "</ul>";
    }
}

?>