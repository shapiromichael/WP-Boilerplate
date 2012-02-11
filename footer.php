	<div id="footer">
		<div class="rights">
			<p>&copy; <?php echo date('Y'); ?>. All Rights Reserved.</p>
		</div>
	</div>
 	<?php
		
		if( WP_DEBUG ){ echo '<!-- #footer -->'; }
		
		wp_footer();
		
	?>
</body>
</html>