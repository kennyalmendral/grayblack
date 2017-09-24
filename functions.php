<?php 

define('ROOT', get_stylesheet_directory_uri() . '/');
define('VENDORS', ROOT . 'vendors/');
define('IMAGES', ROOT . 'images/');

if ( ! function_exists('grayblack_setup')) {/*{{{*/
	function grayblack_setup() {
		add_theme_support('automatic-feed-links');

		register_nav_menus(array(
			'top-bar-left' => 'Top Bar Left',
			'top-bar-right' => 'Top Bar Right',
			'cat-nav' => 'Category Navigation'
		));
	}

	add_action('after_setup_theme', 'grayblack_setup');
}/*}}}*/

if ( ! function_exists('grayblack_widget_init')) {/*{{{*/
	function grayblack_widget_init() {
		if (function_exists('register_sidebar')) {
			register_sidebar(array(
				'name' => 'Sidebar Widgets',
				'id' => 'sidebar-widgets',
				'description' => '',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h2>',
				'after_title' => '</h2>'
			));
		}
	}

	add_action('widgets_init', 'grayblack_widget_init');
}/*}}}*/

if ( ! function_exists('grayblack_css_js')) {/*{{{*/
	function grayblack_css_js() {
		wp_enqueue_style('noto-serif', 'https://fonts.googleapis.com/css?family=Noto+Serif:700');
		wp_enqueue_style('noto-sans', 'https://fonts.googleapis.com/css?family=Noto+Sans:400,700');
		wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
		wp_enqueue_style('normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css');
		wp_enqueue_style('base', ROOT . 'base.css');
		wp_enqueue_style('style', ROOT . 'style.css');

		wp_enqueue_script('script', ROOT . 'script.js', array('jquery'), false, true);
	}

	add_action('wp_enqueue_scripts', 'grayblack_css_js');
}/*}}}*/

if ( ! function_exists('grayblack_post_meta')) {/*{{{*/
	function grayblack_post_meta() {
		echo '<div class="post-meta">';

		if (get_post_type() === 'post') {
			$categories = get_the_category_list(', ');
			$tags = get_the_tag_list('', ', ');

			if ($tags)
				echo '<div class="post-meta-date"><i class="fa fa-calendar" aria-hidden="true"></i> ' . grayblack_published_link() . '</div><div class="post-meta-author"><i class="fa fa-user" aria-hidden="true"></i> <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author() . '</a></div><div class="post-meta-cats"><i class="fa fa-folder-open" aria-hidden="true"></i> ' . $categories . '</div><div class="post-meta-tags"><i class="fa fa-tags" aria-hidden="true"></i> ' . $tags . '</div>';
			else
				echo '<div class="post-meta-date"><i class="fa fa-calendar" aria-hidden="true"></i> ' . grayblack_published_link() . '</div><div class="post-meta-author"><i class="fa fa-user" aria-hidden="true"></i> <a href="' . get_author_posts_url(get_the_author_meta('ID'))  . '">' . get_the_author() . '</a></div><div class="post-meta-cats"><i class="fa fa-folder-open" aria-hidden="true"></i> ' . $categories . '</div>';
		}

		echo '</div>';
	}
}/*}}}*/

if ( ! function_exists('grayblack_published_link')) {/*{{{*/
	function grayblack_published_link() {
		$year = get_the_time('Y');
		$month = get_the_time('m');
		$day = get_the_time('d');

		$out = '';

		$out .= '<a href="' . get_month_link($year, $month) . '" title="Archive for ' . esc_attr(get_the_time('F Y')) . '">' . get_the_time('F') . '</a>';
		$out .= ' <a href="' . get_day_link($year, $month, $day) . '" title="Archive for ' . esc_attr(get_the_time('F d, Y')) . '">' . $day . '</a>';
		$out .= ', <a href="' . get_year_link($year) . '" title="Archive for ' . esc_attr($year) . '">' . $year . '</a>';

		return $out;
	}
}/*}}}*/

if ( ! function_exists('grayblack_paging_nav')) {/*{{{*/
	function grayblack_paging_nav() { ?>
		<ul class="paging clearfix">
			<?php if (get_previous_posts_link()) : ?>
				<li class="previous"><?php previous_posts_link('&larr; Previous'); ?></li>
			<?php endif; ?>

			<?php if (get_next_posts_link()) : ?>
				<li class="next"><?php next_posts_link('Next &rarr;'); ?></li>
			<?php endif; ?>
		</ul><?php
	}
}/*}}}*/

if ( ! function_exists('grayblack_numeric_posts_nav')) {/*{{{*/
	function grayblack_numeric_posts_nav() {
		if (is_singular())
			return;

		global $wp_query;

		if ($wp_query->max_num_pages <= 1)
			return;

		$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

		$max = intval($wp_query->max_num_pages);

		if ($paged >= 1)
			$links[] = $paged;

		if ($paged >= 3) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if (($paged + 2) <= $max) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="paging"><ul>' . PHP_EOL;

		if (get_previous_posts_link())
			printf('<li>%s</li>' . PHP_EOL, get_previous_posts_link('Previous'));

		if ( ! in_array(1, $links)) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf('<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url(get_pagenum_link(1)), '1');

			if ( ! in_array(2, $links))
				echo '<li>&hellip;</li>';
		}

		sort($links);

		foreach ((array) $links as $link) {
			$class = $paged == $link ? ' class="active"' : '';

			printf('<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url(get_pagenum_link($link)), $link);
		}

		if ( ! in_array($max, $links)) {
			if ( ! in_array($max - 1, $links))
				echo '<li>&hellip;</li>' . PHP_EOL;

			$class = $paged == $max ? ' class="active"' : '';

			printf('<li%s><a href="%s">%s</a></li>' . PHP_EOL, $class, esc_url(get_pagenum_link($max)), $max);
		}

		if (get_next_posts_link())
			printf('<li>%s</li>' . PHP_EOL, get_next_posts_link('Next'));

		echo '</ul></div>' . PHP_EOL;
	}
}/*}}}*/

if ( ! function_exists('custom_excerpt_more')) {/*{{{*/
	function custom_excerpt_more($more) {
		return '&hellip;';
	}

	add_filter('excerpt_more', 'custom_excerpt_more');
}/*}}}*/

if ( ! function_exists('custom_excerpt_length')) {/*{{{*/
	function custom_excerpt_length($length) {
		return 40;
	}

	add_filter('excerpt_length', 'custom_excerpt_length', 999);
}/*}}}*/

if ( ! function_exists('add_related_posts_to_content')) {/*{{{*/
	function add_related_posts_to_content($content) {
		if (is_singular() && get_post_type() == 'post') {
			$terms = get_the_terms(get_the_ID(), 'category');
			$cats = array();
			
			foreach ( $terms as $term ) {
				$cats[] = $term->term_id;
			}
			
			$loop = new WP_Query(array(
				'category__in' => $cats,
				'posts_per_page' => 4,
				'post__not_in' => array(get_the_ID()),
				'orderby' => 'date',
				'order' => 'DESC',
				'order_by' => 'rand'
			));

			if ($loop->have_posts()) {
				$content .= '<div class="related-posts">';
				$content .= '<h2>Related Posts</h2>';
				$content .= '<ul>';
				
				while ( $loop->have_posts() ) {
					$loop->the_post();
					
					$content .= the_title(
						'<li><a href="' . get_permalink() . '">',
						'</a></li>',
						false
					);
				}
				
				$content .= '</ul>';
				$content .= '</div>';
				
				wp_reset_query();
			}
			
			return $content;
		} else {
			return $content;
		}
	}

	add_filter('the_content', 'add_related_posts_to_content');
}/*}}}*/

if ( ! function_exists('remove_width_and_height_attribute')) {/*{{{*/
	add_filter('get_image_tag', 'remove_width_and_height_attribute', 10);
	add_filter('post_thumbnail_html', 'remove_width_and_height_attribute', 10);
	add_filter('image_send_to_editor', 'remove_width_and_height_attribute', 10);

	function remove_width_and_height_attribute($html) {
	   return preg_replace('/(height|width)="\d*"\s/', "", $html);
	}
}/*}}}*/

if ( ! function_exists('remove_empty_p')) {/*{{{*/
	add_filter('the_content', 'remove_empty_p', 20, 1);

	function remove_empty_p($content) {
		$content = force_balance_tags($content);

		return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
	}
}/*}}}*/

if ( ! function_exists('remove_css_js_version')) {/*{{{*/
	add_filter('style_loader_src', 'remove_css_js_version', 1000);
	add_filter('script_loader_src', 'remove_css_js_version', 1000);

	function remove_css_js_version($src) {
		if (strpos($src, '?ver=')) {
			$src = remove_query_arg('ver', $src);
		}
			
		return $src;
	}
}/*}}}*/

add_filter('the_generator', '__return_null');

$the_query = new WP_Query(array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'orderby' => 'date',
	'order' => 'DESC'
));

if ($the_query->have_posts()) {
	echo '<ul>';

	while ($the_query->have_posts()) {
		$the_query->the_post();

		echo '<li>' . get_the_title() . '</li>';
	}
	echo '</ul>';

	wp_reset_postdata();
}

?>
