	<footer id="footer">
		<div class="container">
			<?php
				$from_year = 2017; 
				$this_year = (int) date('Y'); 
				$date = $from_year . (($from_year != $this_year) ? ' - ' . $this_year : '');
			?>

			<p>Copyright &copy; <?php echo $date; ?> <a href="<?php echo get_home_url(); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved</p>
			<p><a href="https://github.com/kennyalmendral/grayblack" target="_blank" rel="nofollow">Grayblack Theme</a> by <a href="<?php echo get_home_url(); ?>">Kenny Almendral</a></p>
			<p>Powered by WordPress</p>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
