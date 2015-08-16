	<footer>
		<div class="container rights">
			<p class="text-muted rights">&copy; <?php echo date('Y'); ?>. All Rights Reserved.</p>
		</div>
	</footer>
	<?php
	
		if( GA_ACCOUNT ){
			?>
			<script>
				var _gaq=[['_setAccount','<?php echo GA_ACCOUNT ?>'],['_trackPageview']];
				(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
				g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
				s.parentNode.insertBefore(g,s)}(document,'script'));
			</script>
			<?php
		}

		wp_enqueue_script('main');
		
		wp_footer();
		
	?>
</body>
</html>