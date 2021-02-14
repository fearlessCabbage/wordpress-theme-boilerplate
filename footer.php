	<footer>
		<div class="container">

			<nav id="footer-nav">
				<?php wp_nav_menu(array(
					'container' => false,
					'menu' => __( 'Footer Navigation', 'wpTheme' ),
					'theme_location' => 'footer-navigation'
				)); ?>
			</nav>

			<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>
		</div>
	</footer>

	<?php wp_footer(); ?>

</body>
</html>
