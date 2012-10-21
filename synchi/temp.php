$theme_url = get_bloginfo('template_url'); // . '/synchi';
$theme_dir = dirname(__FILE__);
$content_dir = ABSPATH . '/wp-content/themes/';
$admin_url = get_admin_url();


echo '$theme_url: ' . $theme_url;
echo "<br>";

echo '$theme_dir: ' . $theme_dir;
echo "<br>";

echo '$content_dir: ' . $content_dir;
echo "<br>";

echo '$admin_url: ' . $admin_url;
echo "<br>";