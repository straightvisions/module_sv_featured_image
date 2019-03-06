<?php
namespace sv_100;

/**
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2019 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_featured_image extends init {
	public function __construct() {

	}

	public function init() {
		// Module Info
		$this->set_module_title( 'SV Featured Image' );
		$this->set_module_desc( __( 'This module shows a featured image via "[sv_featured_image]" shortcode.', $this->get_module_name() ) );

		// Section Info
		$this->set_section_title( __('Featured Image', $this->get_module_name()) );
		$this->set_section_desc( __('Settings for Featured Image', $this->get_module_name()) );
		$this->set_section_type( 'settings' );

		$this->get_root()->add_section( $this );
		$this->load_settings();

		add_filter('get_post_metadata', array($this,'get_post_metadata'), 10, 4);

		// Shortcodes
		add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );
	}
	public function load_settings() {
		$this->s['fallback_image'] = static::$settings->create( $this )
			->set_ID( 'fallback_image' )
			->set_title( 'Fallback Image' )
			->set_description( __( 'Uploaded Image will be used when post has not featured image set.', $this->get_module_name() ) )
			->load_type( 'upload' );
	}
	public function get_post_metadata($value, $post_id, $meta_key, $single){
		if ( '_thumbnail_id' !== $meta_key ) {
			return $value;
		}

		if ( is_admin() ) {
			return $value;
		}

		remove_filter( 'get_post_metadata', array($this,'get_post_metadata'), 10, 4 );

		$featured_image_id = get_post_thumbnail_id( $post_id );

		add_filter( 'get_post_metadata', array($this,'get_post_metadata'), 10, 4 );

		// The post has a featured image.
		if ( $featured_image_id ) {
			return $featured_image_id;
		}

		return intval($this->s['fallback_image']->run_type()->get_data());
	}
	public function shortcode( $settings, $content = '' ) {
		$settings								= shortcode_atts(
			array(
				'inline'						=> true
			),
			$settings,
			$this->get_module_name()
		);

		// Load Styles
		static::$scripts->create( $this )
			->set_path( 'lib/css/frontend.css' )
			->set_inline($settings['inline']);

		ob_start();
		include( $this->get_path( 'lib/tpl/frontend.php' ) );
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}
}