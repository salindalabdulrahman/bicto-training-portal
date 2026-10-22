<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Upsell customizer service.
 *
 * @package PressBook_Green
 */

/**
 * Upsell service class.
 */
class PressBook_Green_Upsell extends PressBook\Options {
	/**
	 * Add upsell in the theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->upsell( $wp_customize );
	}

	/**
	 * Section: Upsell.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function upsell( $wp_customize ) {
		$wp_customize->add_control(
			new \PressBook_Upsell_Control(
				$wp_customize,
				'sec_posts_grid_header',
				array(
					'section'     => 'sec_posts_grid_header',
					'type'        => 'pressbook-addon',
					'label'       => esc_html__( 'Learn More', 'pressbook-green' ),
					'description' => esc_html__( 'Premium version also includes header and footer posts carousel with multiple options like autoplay etc. Also, background color, caption color, and many other options are available in our premium version.', 'pressbook-green' ),
					'url'         => ( esc_url( PressBook\Helpers::get_upsell_detail_url() ) ),
					'priority'    => 999,
					'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				)
			)
		);

		$wp_customize->add_control(
			new \PressBook_Upsell_Control(
				$wp_customize,
				'sec_posts_grid_related',
				array(
					'section'     => 'sec_posts_grid_related',
					'type'        => 'pressbook-addon',
					'label'       => esc_html__( 'Learn More', 'pressbook-green' ),
					'description' => esc_html__( 'Premium version also includes related posts carousel along with related posts grid. Also, background color and many other options are available in our premium version.', 'pressbook-green' ),
					'url'         => ( esc_url( PressBook\Helpers::get_upsell_detail_url() ) ),
					'priority'    => 999,
					'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				)
			)
		);
	}
}
