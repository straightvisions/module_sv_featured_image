<?php
	if (
		! is_single()
		&& ! is_page()
		&& wp_get_attachment_image( get_post_thumbnail_id(), $settings['size'] )
	) {
		echo '<a href="' . get_the_permalink() . '">';
	}

	echo wp_get_attachment_image( get_post_thumbnail_id(), $settings['size'] );

	if (
		! is_single()
		&& ! is_page()
		&& wp_get_attachment_image( get_post_thumbnail_id(), $settings['size'] )
	) {
		echo '</a>';
	}