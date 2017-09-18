<?php get_header(); ?>

<div id="main">
	<div class="container clearfix">

		<div class="main-content">
			<?php while (have_posts()) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<div><?php the_content(); ?></div>
			<?php endwhile; ?>
		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
