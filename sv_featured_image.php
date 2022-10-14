<?php
	namespace sv100_companion;

	class sv_featured_image extends init {
		public function init() {
			$this->set_section_title(  __( 'SV Featured Image', 'sv100_companion' ) )
				->set_section_desc( __( 'Set a default thumbnail.', 'sv100_companion' ) )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section($this);
	
			// Action Hooks
			add_filter( 'get_post_metadata', array( $this,'get_post_metadata' ), 10, 4 );
		}
	
		protected function load_settings(): sv_featured_image {
			$this->get_setting( 'fallback_image' )
				 ->set_title( __( 'Default thumbnail', 'sv100_companion' ) )
				 ->set_description( __( 'Image will be used when posts or pages has no thumbnail set.', 'sv100_companion' ) )
				 ->load_type( 'upload' );
	
			return $this;
		}
	
		public function get_post_metadata( $value, $post_id, $meta_key, $single ) {
			if ( '_thumbnail_id' !== $meta_key ) {
				return $value;
			}
	
			if ( is_admin() ) {
				return $value;
			}
	
			remove_filter( 'get_post_metadata', array( $this,'get_post_metadata' ), 10, 4 );
	
			$featured_image_id = get_post_thumbnail_id( $post_id );
	
			add_filter( 'get_post_metadata', array( $this,'get_post_metadata' ), 10, 4 );
			
			// The post has a featured image.
			if ( $featured_image_id || is_array( $this->get_setting( 'fallback_image' )->get_data() ) ) {
				return $featured_image_id;
			}
	
			return intval( $this->get_setting( 'fallback_image' )->get_data() );
		}
	}