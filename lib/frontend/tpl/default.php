<?php
	if (
		! is_single()
		&& ! is_page()
		&& get_the_post_thumbnail( null, $settings['size'], array( 'class' => $this->get_prefix() ) )
	) {
		echo '<a href="' . get_the_permalink() . '">';
	}
	
	echo get_the_post_thumbnail( null, $settings['size'], array( 'class' => $this->get_prefix() ) );
	
	if (
		! is_single()
		&& ! is_page()
		&& get_the_post_thumbnail( null, $settings['size'], array( 'class' => $this->get_prefix() ) )
	) {
		echo '</a>';
	}