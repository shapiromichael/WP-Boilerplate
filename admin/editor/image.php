<?php

// =============================================================================
// File: image.php
// Version: 1.0
// 
// Renders image view.
// =============================================================================

// check access
if(!defined('SYNCHI')) exit('Direct access is not allowed...'); 

// determine if scaling is necessary
$width = ($image_info[0] > 500) ? 500 : $image_info[0];

// determine source
$source = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filename);
$source = get_option('siteurl') . '/' . substr($source, strpos($source, 'wp-content/'));

?>

<p>Image preview:</p>
<p>
    <img width="<?php echo $width; ?>" src="<?php echo $source; ?>" />
</p>
<p>Image type: <?php echo $image_info['mime']; ?></p>
<p>Original size: <?php echo "{$image_info[0]} x {$image_info[1]} px"; ?></p>
<p>Original image: <a href="<?php echo $source; ?>" target="_blank"><?php echo $source; ?></a></p>