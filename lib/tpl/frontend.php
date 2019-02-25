<?php
if ( ! is_single() && ! is_page() ) {
	echo '<a href="' . get_the_permalink() . '">';
}

echo get_the_post_thumbnail( null, 'medium_large', array( 'class' => $this->get_prefix() ) );

if ( ! is_single() && ! is_page() ) {
	echo '</a>';
}