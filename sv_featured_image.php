<?php
namespace sv100;

/**
 * @author			straightvisions GmbH
 * @package			sv100
 * @copyright		2019 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_featured_image extends init {
	public function init() {
		// Module Info
		$this->set_module_title( 'SV Featured Image' );
		$this->set_module_desc( __( 'This module shows a featured image via "[sv_featured_image]" shortcode.', 'sv100' ) );

		// Section Info
		$this->set_section_title( 'Featured Image' );
		$this->set_section_desc( __('Settings for Featured Image', 'sv100') );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Action Hooks
		add_filter( 'get_post_metadata', array( $this,'get_post_metadata' ), 10, 4 );

		$this->load_settings();
	}

	public function load_settings(): sv_featured_image {
		$this->s['fallback_image'] = $this->get_setting()
			->set_ID( 'fallback_image' )
			->set_title( __( 'Fallback image', 'sv100' ) )
			->set_description( __( 'Uploaded image will be used when post has not featured image set.', 'sv100' ) )
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
		if ( $featured_image_id || is_array( $this->get_setting( 'fallback_image' )->run_type()->get_data() ) ) {
			return $featured_image_id;
		}

		return intval( $this->get_setting( 'fallback_image' )->run_type()->get_data() );
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
		include( $this->get_path( 'lib/frontend/tpl/default.php' ) );
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}
}