	<div id="footer">
		<div class="rights">
			<p>&copy; <?php echo date('Y'); ?>. All Rights Reserved.</p>
		</div>
	</div>
	<?php
	
		if( $ga_account = get_option('ga_account') ){
			?>
			<script>
				var _gaq=[['_setAccount','<?php echo $ga_account; ?>'],['_trackPageview']];
				(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
				g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
				s.parentNode.insertBefore(g,s)}(document,'script'));
			</script>
			<?php
		}
		
		if( WP_DEBUG ){ echo '<!-- #footer -->'; }
		
		wp_footer();
		
	?>
</body>
</html>