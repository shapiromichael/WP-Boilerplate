<?php

// check if uninstall valid
if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) die;
 
// delete global options
delete_option('synchi_option_flag_plugins', 1);
delete_option('synchi_option_flag_themes', 1);
delete_option('synchi_option_flag_articles', 1);

// delete editing options
delete_option('synchi_option_serializedTabs_plugins');
delete_option('synchi_option_serializedTabs_themes');
delete_option('synchi_option_theme');
delete_option('synchi_option_lineNumbers');
delete_option('synchi_option_matchBrackets');
delete_option('synchi_option_fontSize');
delete_option('synchi_option_tabSize');
delete_option('synchi_option_indentWithTabs');

?>