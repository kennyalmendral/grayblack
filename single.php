<?php get_header(); ?>

<div id="main">
	<div class="container clearfix">

		<div class="main-content">
			<?php while (have_posts()) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php grayblack_post_meta(); ?>

				<div><?php the_content(); ?></div>

				<div class="author-container">
					<h2>About <?php echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'); ?></h2>

					<div class="clearfix">
						<div class="author-img"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><img src="http://localhost/wordpress/wp-content/uploads/2017/09/signature-photo.jpg" alt="<?php the_author(); ?>" title="<?php the_author(); ?>"></a></div>
						<div class="author-info"><p><?php the_author_meta('description'); ?></p></div>
					</div>
				</div>
			<?php endwhile; ?>

			<div class="comments-container">
				<h2>Comments</h2>
				<div><?php comments_template(true); ?></div>
			</div>
		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
