<?php get_header(); ?>

	<article class="four-zero-four">
		<header>
			<h1><?php _e( '404 - Page Not Found', 'cabbageTheme' ); ?></h1>
		</header>

		<p>The page you are looking for does not exist. <a href="<?php echo get_home_url(); ?>">Go back to home</a> or try another link!</p>
		<ul>
			<?php wp_list_pages(); ?>
		</ul>
	</article>

<?php get_footer(); ?>
