<?php get_header(); ?>


<main class="container">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>">

			<?php // if(get_the_post_thumbnail()): ?>
				
			<?php //else: ?>
				<header>
					<h1><?php the_title(); ?></h1>
				</header>
			<?php //endif; ?>
			
			<?php the_content(); ?>
		
		</article>
		<?php endwhile; ?>

	<?php else: ?>
		<article class="no-posts">
			<div>
				<h1>Oops, no posts have been found.</h1>
				<p><a href="<?php echo get_home_url(); ?>">Go back home</a> or try another link!</p>
				<ul>
					<?php wp_list_pages(); ?>
				</ul>
			</div>
		</article>
	<?php endif; ?>
</main>



<?php get_footer(); ?>
