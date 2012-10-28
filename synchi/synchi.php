<?php

// =============================================================================
// editor_highlight
// 
// Released under the GNU General Public Licence v2
// http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
//
// CodeMirror library is released under a MIT-style license
// http://codemirror.net/LICENSE
// 
// Please refer all questions/requests to: mdjekic@gmail.com
//
// This is an add-on for WordPress
// http://wordpress.org/
// =============================================================================

// =============================================================================
// This piece of software is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY, without even the implied warranty of MERCHANTABILITY or
// FITNESS FOR A PARTICULAR PURPOSE.
// =============================================================================

/*
  Plugin Name: editor_highlight
  Plugin URI: http://projects.djekic.net/editor_highlight
  Description: A full IDE inside your Wordpress! Syntax highlighting and powerfull IDE features in WP plugin editor, themes editor and article HTML editor.
  Version: 4.4
  Author: Miloš Đekić
  Author URI: http://milos.djekic.net
 */
$editor_highlight_url = get_bloginfo('template_url') . '/editor_highlight/'; //1)this is instead the $editor_highlight_url
$editor_highlight_dir = dirname(__FILE__); //2) this is instead the $editor_highlight_dir
$theme_dir = WP_CONTENT_DIR . '/themes';
$admin_url=get_bloginfo('wpurl') . '/wp-admin';

// check if direct access attempted
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access not alowed.'); 
}


// define paths
// if(!defined('$editor_highlight_url')) define('$editor_highlight_url', $editor_highlight_url);             
// if(!defined('$editor_highlight_dir')) define('$editor_highlight_dir', $editor_highlight_dir);            
// if(!defined('$theme_dir')) define('$theme_dir', $theme_dir);               
// if(!defined('$admin_url')) define('$admin_url', $admin_url);       
define("editor_highlight",'4.4');
// define settings page unique name
define("editor_highlight_SETTINGS_PAGE",'editor_highlight-settings');

// define themes
$editor_highlight_themes = array('default','ambiance','blackboard','cobalt','eclipse','elegant','erlang-dark','monokai','neat','night','rubyblue','xq-dark');

// define supported modes
$editor_highlight_modes = array('plugin-editor','theme-editor','post','post-new');

// define supported extensions
$editor_highlight_extensions = array("php","js","css","sql","html","htm","txt","xml");

// define supported image extensions
$editor_highlight_image_extensions = array('gif','jpg','png','bmp');

// define bad filename characters
$editor_highlight_bad_chars = array('[',']','/','\\','=','+','<','>',':',';','"',',','*');

// ===================================================== Utility Functions =====

/**
 * Clears $_GET and $_POST
 */
function sychi_clearRequest() {
    $_GET = array();
    $_POST = array();
}

/**
 * Echoes a CSS include with versioning
 * 
 * @param string $filepath
 */
function editor_highlight_echoCSSinclude($filepath) {
    global $editor_highlight_url;
    ?>
    <link rel="stylesheet" href="<?php echo $editor_highlight_url . $filepath; ?>.css?version=<?php echo editor_highlight; ?>" />
<?php }

/**
 * Echoes a JS include with versioning
 * 
 * @param string $filepath
 */
function editor_highlight_echoJSinclude($filepath) { 
    global $editor_highlight_url;
    ?>
    <script src="<?php echo $editor_highlight_url . $filepath; ?>.js?version=<?php echo editor_highlight; ?>"></script>
<?php }

/**
 * Returns the name of the script currently accessed
 * 
 * @return string $script_name
 */
function editor_highlight_get_script() {
    $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
    return end($script_name);
}

/**
 * Echos an ajax response
 * 
 * @param mixed $result 
 */
function editor_highlight_ajax_response($result) {
    $response = new stdClass();
    $response->status = 1;
    $response->result = $result;
    header('Content-type: application/json');
    echo json_encode($response);
    die;
}

/**
 * Echos an ajax error
 * 
 * @param string $error error description
 */
function editor_highlight_ajax_error($error) {
    $response = new stdClass();
    $response->status = 0;
    $response->error = $error;
    header('Content-type: application/json');
    echo json_encode($response);
    die;
}

/**
 * Deletes a directory with all files inside
 * 
 * @param string $dirname
 * @return bool true if delete is success 
 */
function editor_highlight_delete_directory($dirname) {
    if (is_dir($dirname)) $dir_handle = opendir($dirname);
    if (!$dir_handle) return false;
    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file)) unlink($dirname . "/" . $file);
            else editor_highlight_delete_directory($dirname . '/' . $file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

/**
 * Ensure that the string ends with the specified character
 *
 * @param string $string
 * @return string
 */
function synhci_includeTrailingCharacter($string, $character) {
    if (strlen($string) > 0) {
        if (substr($string, -1) !== $character) return $string . $character;
        else return $string;
    } else return $character;
}

/**
 * Copies files or directories with entire structure
 * 
 * @param string $source
 * @param string $target 
 */
function editor_highlight_full_copy($source, $target) {
    if (is_dir($source)) {
        @mkdir($target);
        $d = dir($source);
        while (($entry = $d->read()) !== false) {
            if ($entry == '.' || $entry == '..') continue;
            $Entry = synhci_includeTrailingCharacter($source,'/') . $entry;
            if($Entry == $target) continue;
            if (is_dir($Entry)) {
                editor_highlight_full_copy($Entry, $target . '/' . $entry);
                continue;
                
            }
            copy($Entry, $target . '/' . $entry);
        }
        $d->close();
    } else copy($source, $target);
}

/**
 * Calculates and returns file size
 * 
 * @param string $file file path
 * 
 * @return string 
 */
function editor_highlight_file_size($file) { 
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

// ====================================================== Action Functions =====

/**
 * Renders editor controls
 */
function editor_highlight_action_get_editor_controls() {
    ob_start();
    include($theme_dir . 'admin/editor/editor_controls.php'); 
    $html = ob_get_contents();
    ob_clean();
    editor_highlight_ajax_response($html);
}

/**
 * Updates editor_highlight settings
 * 
 * @global $editor_highlight_themes
 */
function editor_highlight_action_update_settings() {
    global $editor_highlight_themes;
    
    /* Global Settings */
    
    // handle flag:plugins
    if (!isset($_POST['editor_highlight_option_flag_plugins'])) return;
    $flag_plugins = $_POST['editor_highlight_option_flag_plugins'];
    if ($flag_plugins == 0 || $flag_plugins == 1) update_option('editor_highlight_option_flag_plugins', $flag_plugins);
    
    // handle flag:themes
    if (!isset($_POST['editor_highlight_option_flag_themes'])) return;
    $flag_themes = $_POST['editor_highlight_option_flag_themes'];
    if ($flag_themes == 0 || $flag_themes == 1) update_option('editor_highlight_option_flag_themes', $flag_themes);
    
    // handle flag:articles
    if (!isset($_POST['editor_highlight_option_flag_articles'])) return;
    $flag_articles = $_POST['editor_highlight_option_flag_articles'];
    if ($flag_articles == 0 || $flag_articles == 1) update_option('editor_highlight_option_flag_articles', $flag_articles);
    
    /* Editing Settings */
    
    // handle theme
    if (!isset($_POST['editor_highlight_option_theme'])) return;
    $theme = $_POST['editor_highlight_option_theme'];
    if (!isset($theme) || empty($theme) || !in_array($theme, $editor_highlight_themes)) $theme = 'default';
    update_option('editor_highlight_option_theme', $theme);

    // handle line numbers
    if (!isset($_POST['editor_highlight_option_lineNumbers'])) return;
    $lineNumbers = $_POST['editor_highlight_option_lineNumbers'];
    if ($lineNumbers == 0 || $lineNumbers == 1) update_option('editor_highlight_option_lineNumbers', $lineNumbers);

    // handle match brackets
    if (!isset($_POST['editor_highlight_option_matchBrackets'])) return;
    $matchBrackets = $_POST['editor_highlight_option_matchBrackets'];
    if ($matchBrackets == 0 || $matchBrackets == 1) update_option('editor_highlight_option_matchBrackets', $matchBrackets);

    // handle font size
    if (!isset($_POST['editor_highlight_option_fontSize'])) return;
    $fontSize = $_POST['editor_highlight_option_fontSize'];
    if ($fontSize >= 10 && $fontSize <= 16) update_option('editor_highlight_option_fontSize', $fontSize);

    // handle tab size
    if (!isset($_POST['editor_highlight_option_tabSize'])) return;
    $tabSize = $_POST['editor_highlight_option_tabSize'];
    if ($tabSize >= 2 && $tabSize <= 5) update_option('editor_highlight_option_tabSize', $tabSize);
    
    // handle indent with tabs
    if (!isset($_POST['editor_highlight_option_indentWithTabs'])) return;
    $indentWithTabs = $_POST['editor_highlight_option_indentWithTabs'];
    if ($indentWithTabs == 0 || $indentWithTabs == 1) update_option('editor_highlight_option_indentWithTabs', $indentWithTabs);
    
    // redirect to settings page
    header('Location: ' . $admin_url . '/options-general.php?page=' . editor_highlight_SETTINGS_PAGE . '&updated=true');
    die;
}

/**
 * Fetches file contents
 * 
 * @global $editor_highlight_extensions
 */
function editor_highlight_action_get_file_contents() {
    global $editor_highlight_extensions;
    global $editor_highlight_image_extensions;
    
    // get filename
    $filename = $_REQUEST['file'];
    $filename = str_replace("\\\\", "/", $filename);
    
    // check if file exists
    if(!file_exists($filename)) editor_highlight_ajax_error("File not found!");
    
    // file is image flag
    $file_is_image = false;
    
    // check if extension is supported
    $clean_filename = end(explode('/',$filename));
    $extension = end(explode('.',$clean_filename));
    if(!in_array($extension, $editor_highlight_extensions)) {
        // check if file is image
        if(!in_array($extension, $editor_highlight_image_extensions)) editor_highlight_ajax_error("File not supported!");
        else $file_is_image = true;
    }

    // get contents
    if($file_is_image) {
        $image_info = getimagesize($filename);
        ob_start();
        include($editor_highlight_dir . '/editor_highlight/php/image.php'); 
        $contents = ob_get_clean();
    }
    else {
        $contents = @file_get_contents($filename);
        if($contents == "") $contents = " ";
    }
    
    // form result
    $result = new stdClass();
    $result->contents = $contents;
    $result->file_is_image = $file_is_image;
    
    // respond
    editor_highlight_ajax_response($result);
}

/**
 * Renders and returns IDE HTML in result
 */
function editor_highlight_action_get_ide() {
    ob_start();
    $editor_mode = isset($_REQUEST['editor_mode']) ? substr($_REQUEST['editor_mode'],0,-1) : 'Files';
    include($editor_highlight_dir . '/php/editor_highlight_ide.php'); 
    $html = ob_get_contents();
    ob_clean();
    editor_highlight_ajax_response($html);
}

/**
 * Saves last opened tabs
 */
function editor_highlight_action_serialize_tabs() {
    $files = $_REQUEST['files'];
    if(!is_array($files)) editor_highlight_ajax_response(false);
    $mode = str_replace('/', '', $_REQUEST['mode']);
    $serialized_files = array();
    foreach ($files as $filename) $serialized_files[] = str_replace("\\\\", "/", $filename);
    update_option('editor_highlight_option_serializedTabs_' . $mode, $serialized_files);
    editor_highlight_ajax_response(true);
}

/**
 * Saves a file
 */
function editor_highlight_action_save_file() {
    // get filename
    $filename = $_REQUEST['file'];
    $filename = str_replace("\\\\", "/", $filename);
    
    // check if file exists
    if(!file_exists($filename)) editor_highlight_ajax_error("File not found!");
    
    // get contents
    $contents = $_REQUEST['contents'];
    $contents = stripslashes($contents);
    
    // save contents
    @file_put_contents($filename, $contents);
    editor_highlight_ajax_response(true);
}

/**
 * Creates a file
 * 
 * global $editor_highlight_bad_chars
 */
function editor_highlight_action_create_file() {
    global $editor_highlight_bad_chars;
    
    // get filename
    $filename = $_REQUEST['filename'];
    
    // check filename
    foreach($editor_highlight_bad_chars as $bad_char) {
        if(strpos($filename, $bad_char) !== false) 
                editor_highlight_ajax_error("File name can not contain: " . implode(' ',$editor_highlight_bad_chars));
    }
    if(strlen($filename) > 32) editor_highlight_ajax_error("Name must fit in 32 characters.");
    
    $extension = end(explode(".",$filename));
    
    // get parent
    $dir = $_REQUEST['file'];
    if(!is_dir($dir)) $dir = dirname($dir);
    
    $path = "$dir/$filename";
    if(file_exists($path)) editor_highlight_ajax_error("File already exists!");
    
    // create file
    $handle = fopen($path, 'w') or editor_highlight_ajax_error("Unable to create file!");
    fclose($handle);
    editor_highlight_ajax_response(true);
}

/**
 * Creates a folder
 * 
 * @global $editor_highlight_bad_chars
 */
function editor_highlight_action_create_folder() {
    global $editor_highlight_bad_chars;
    
    // get dirname
    $dirname = $_REQUEST['dirname'];
    
    // check dirname
    foreach($editor_highlight_bad_chars as $bad_char) {
        if(strpos($dirname, $bad_char) !== false) 
                editor_highlight_ajax_error("Folder name can not contain: " . implode(' ',$editor_highlight_bad_chars));
    }
    if(strlen($filename) > 32) editor_highlight_ajax_error("Name must fit in 32 characters.");
    
    // get parent
    $dir = $_REQUEST['file'];
    if(!is_dir($dir)) $dir = dirname($dir);
    
    $path = "$dir/$dirname";
    if(file_exists($path)) editor_highlight_ajax_error("Foler already exists!");
    
    // create directory
    mkdir($path) or editor_highlight_ajax_error("Unable to create folder!");
    editor_highlight_ajax_response(true);
}

/**
 * Delete a file
 */
function editor_highlight_action_delete_file() {
    // get filename
    $filename = $_REQUEST['filename'];
    
    if(is_dir($filename)) $success = editor_highlight_delete_directory($filename);
    else $success = unlink($filename);
    
    if($success) editor_highlight_ajax_response(true);
    else editor_highlight_ajax_error("Unable to delete file/folder!");
}

/**
 * Performs copy/paste and cut/paste
 */
function editor_highlight_action_paste_file() {    
    // get data
    $source = $_REQUEST['source'];
    $mode = $_REQUEST['mode'];
    $file = $_REQUEST['file'];
    
    // get parent
    $dir = $file;
    if(!is_dir($dir)) $dir = dirname($dir);
    
    if(is_dir($source)) {
        // get dirname
        $parts = explode('/',$source);
        $dirname = $parts[count($parts)-1];
        if($dirname == "") $dirname = $parts[count($parts)-2];
        // make sure dirname is unique
        $i = 0;
        $path = "{$dir}{$dirname}";        
        while(file_exists($path)) {
            $path = "{$dir}{$dirname}_" . (++$i);
        }
        // copy
        editor_highlight_full_copy($source, $path);
        // if cut delete
        if($mode == "cut") editor_highlight_delete_directory($source);
        editor_highlight_ajax_response($path);
    }
    else {
        // get filename
        $parts = explode('/',$source);
        $filename = $parts[count($parts)-1];
        // make sure filename is unique
        $i = 0;
        $path = "{$dir}/{$filename}";        
        $parts = explode('.',$filename);
        $extension = $parts[count($parts)-1];
        unset($parts[count($parts)-1]);
        $name = implode('.',$parts);
        while(file_exists($path)) {
            $path = "{$dir}/{$name}_" . (++$i) . ".$extension";
        }
        // copy
        editor_highlight_full_copy($source, $path);
        // if cut delete
        if($mode == "cut") unlink($source);
        editor_highlight_ajax_response($path);
    }    
}

/**
 * Fetches file tree for filetree script. Added by request from Eduardo Alberto
 * as a workaround for problems with server settings concerning direct access to 
 * scripts other than WP entry points.
 */
function editor_highlight_action_file_tree() {
    ob_start();
    include($editor_highlight_dir . '\php\tree.php');

    $html = ob_get_contents();
    ob_clean();
    editor_highlight_ajax_response($html);
}

// ====================================================== Plugin Functions =====

/**
 * Request handler intercepts requests to admin.php and checks if editor_highlight should 
 * perform any actions ('editor_highlight_action' parameter is in the request array)
 */
function editor_highlight_request_handler() {
    // check if editor_highlight action is to be performed
    if(empty($_REQUEST['editor_highlight_action'])) return;
    // check if user is admin
    if(!is_admin()) return;
    // perform action
    switch($_REQUEST['editor_highlight_action']) {
        case 'update_settings': editor_highlight_action_update_settings(); break;
        case 'get_editor_controls': editor_highlight_action_get_editor_controls(); break;
        case 'get_ide': editor_highlight_action_get_ide(); break;
        case 'get_file_contents' : editor_highlight_action_get_file_contents(); break;
        case 'serialize_tabs' : editor_highlight_action_serialize_tabs(); break;
        case 'save_file' : editor_highlight_action_save_file(); break;
        case 'create_file' : editor_highlight_action_create_file(); break;
        case 'create_folder' : editor_highlight_action_create_folder(); break;
        case 'delete_file' : editor_highlight_action_delete_file(); break;
        case 'paste_file' : editor_highlight_action_paste_file(); break;
        case 'file_tree': editor_highlight_action_file_tree(); break;
        default: return;
    }
}

/**
 * Returns editor_highlight settings in an array
 * 
 * @return array $settings
 * @global $editor_highlight_themes
 */
function editor_highlight_get_settings() {
    global $editor_highlight_themes;
    $theme = get_option('editor_highlight_option_theme');
    if(!isset($theme) || empty($theme) || !in_array($theme, $editor_highlight_themes)) $theme = 'default';
    return array(
        'flag_plugins' => get_option('editor_highlight_option_flag_plugins') == 1,
        'flag_themes' => get_option('editor_highlight_option_flag_themes') == 1,
        'flag_articles' => get_option('editor_highlight_option_flag_articles') == 1,
        'theme' => $theme,
        'lineWrapping' => true,
        'lineNumbers' => get_option('editor_highlight_option_lineNumbers') == 1,
        'matchBrackets' => get_option('editor_highlight_option_matchBrackets') == 1,
        'fontSize' => get_option('editor_highlight_option_fontSize'),
        'tabSize' => get_option('editor_highlight_option_tabSize'),
        'indentWithTabs' => get_option('editor_highlight_option_indentWithTabs') == 1,
    );
}

/**
 * Initializes editor_highlight plugin by adding JavaScript 
 * and CSS file includes to admin head
 * 
 * @global $editor_highlight_modes
 */
function editor_highlight_init() {
    global $editor_highlight_modes;
    
    // determine mode
    $editor_highlight_mode = str_replace(".php", "", editor_highlight_get_script());
    
    // do nothing for unsupported modes
    if(!in_array($editor_highlight_mode, $editor_highlight_modes)) return;
    
    // init settings
    $editor_highlight_settings = editor_highlight_get_settings();
    
    // determine editor root
    include($editor_highlight_dir . 'php/head/editor.php'); 
    
}

// ================================================= Plugin Initialization =====

// register request handler
add_action('init', 'editor_highlight_request_handler', 9999);

// register action handles
add_action('admin_head','editor_highlight_init');

// register global options
add_option('editor_highlight_option_flag_plugins', 1);
add_option('editor_highlight_option_flag_themes', 1);
add_option('editor_highlight_option_flag_articles', 0);

// register editing options
add_option('editor_highlight_option_serializedTabs_plugins',array());
add_option('editor_highlight_option_serializedTabs_themes',array());
add_option('editor_highlight_option_theme', 'default');
add_option('editor_highlight_option_lineNumbers', 1);
add_option('editor_highlight_option_matchBrackets', 1);
add_option('editor_highlight_option_fontSize', 12);
add_option('editor_highlight_option_tabSize', 2);
add_option('editor_highlight_option_indentWithTabs', 0);

// register menu item
add_action('admin_menu', 'editor_highlight_menu');



// include('php/tree.php');