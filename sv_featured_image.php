<?php
	namespace sv100;

	class sv_featured_image extends init {
		public function init() {
			$this->set_module_title(  __( 'SV Featured Image', 'sv100' ) )
				->set_module_desc( __( 'Set a default thumbnail.', 'sv100' ) )
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->set_section_order(5000)
				->get_root()
				->add_section( $this );
	
			// Action Hooks
			add_filter( 'get_post_metadata', array( $this,'get_post_metadata' ), 10, 4 );
		}
	
		protected function load_settings(): sv_featured_image {
			$this->get_setting( 'fallback_image' )
				 ->set_title( __( 'Default thumbnail', 'sv100' ) )
				 ->set_description( __( 'Image will be used when posts or pages has no thumbnail set.', 'sv100' ) )
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
	
		public function load( $settings = array() ): string {
			$settings								= shortcode_atts(
				array(
					'inline'						=> true,
					'size'							=> 'medium_large'
				),
				$settings,
				$this->get_module_name()
			);
	
			ob_start();
			include( $this->get_path( 'lib/tpl/frontend/default.php' ) );
			$output									= ob_get_clean();

			return $output;
		}
	}