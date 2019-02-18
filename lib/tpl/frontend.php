<div class="<?php echo $this->get_module_name(); ?>" style="background-image: url( <?php echo get_the_post_thumbnail_url(false, 'large'); ?> )">
	<div class="text-wrapper">
		<h4><?php the_title(); ?></h4>
		<h2><?php the_excerpt(); ?></h2>
	</div>
</div>