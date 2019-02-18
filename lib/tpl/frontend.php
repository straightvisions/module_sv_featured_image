<div class="<?php echo $this->get_module_name(); ?>" style="background-image: url( <?php
	echo ( get_the_post_thumbnail()
	? get_the_post_thumbnail_url(false, 'large')
	: wp_get_attachment_image_src($this->s['fallback_image']->run_type()->get_data(), 'large' )[0]); ?> )">
	<div class="text-wrapper">
		<h4><?php the_title(); ?></h4>
		<h2><?php the_excerpt(); ?></h2>
	</div>
</div>