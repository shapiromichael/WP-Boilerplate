
<?php
	function shifnet_header()
		{ ?>

			<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/highlight/css-shcore.css" type="text/css" />
			<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/highlight/css-shdefault.css" type="text/css" />

		<?php }
	add_action('wp_head','shifnet_header');

	/* -- :[Inject Code To Footer]: -- */
	function shifnet_footer()
		{

			if(is_single()) { /* Load script only in Single page */ ?>

			<!-- Load Brush Files -->
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shCore.js"></script>
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shBrushPhp.js"></script>
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shBrushJScript.js"></script>
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shBrushXml.js"></script>
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shBrushCss.js"></script>
			<script class="javascript" src="<?php bloginfo('template_directory'); ?>/js/highlight/shBrushPlain.js"></script>

			<script type="text/javascript">
				SyntaxHighlighter.all()
			</script>

			<?php }

		}
	add_action('wp_footer', 'shifnet_footer');
