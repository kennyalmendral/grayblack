<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" href="<?php echo ROOT; ?>apple-touch-icon.png">
	<link rel="icon" type="image/png" href="<?php echo ROOT; ?>favicon.png">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 8]><p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

	<div id="top-bar">
		<div class="container clearfix">
			<?php 
				wp_nav_menu(array(
					'theme_location' => 'top-bar-left',
					'container' => '',
					'container_class' => '',
					'menu_class' => 'top-bar-left clearfix'
				)); 
			?>

			<?php 
				wp_nav_menu(array(
					'theme_location' => 'top-bar-right',
					'container' => '',
					'container_class' => '',
					'menu_class' => 'top-bar-right clearfix'
				)); 
			?>
		</div>
	</div>

	<header id="header">
		<div class="container clearfix">
			<div class="logo"><a href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo IMAGES; ?>logo.png" title="<?php bloginfo('name'); ?>"></a></div>

			<?php 
				wp_nav_menu(array(
					'theme_location' => 'cat-nav',
					'container' => '',
					'container_class' => '',
					'menu_class' => 'cat-nav clearfix'
				)); 
			?>
		</div>
	</header>
