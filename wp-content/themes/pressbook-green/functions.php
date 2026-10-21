<?php
/**
 * This is the child theme for PressBook theme.
 *
 * (See https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 *
 * @package PressBook_Green
 */

defined( 'ABSPATH' ) || die();

define( 'PRESSBOOK_GREEN_VERSION', '1.3.1' );

/**
 * Load child theme text domain.
 */
function pressbook_green_setup() {
	load_child_theme_textdomain( 'pressbook-green', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'pressbook_green_setup', 11 );

/**
 * Set child theme services.
 *
 * @param  array $services Parent theme services.
 * @return array
 */
function pressbook_green_services( $services ) {
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-select-multiple.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-cssrules.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-scripts.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-editor.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-siteidentity.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-primarynavbar.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-posts-grid.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-posts-grid-header.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-posts-grid-related.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-block-patterns.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-green-upsell.php';

	foreach ( $services as $key => $service ) {
		if ( 'PressBook\Editor' === $service ) {
			$services[ $key ] = PressBook_Green_Editor::class;
		} elseif ( 'PressBook\Scripts' === $service ) {
			$services[ $key ] = PressBook_Green_Scripts::class;
		} elseif ( 'PressBook\Options\SiteIdentity' === $service ) {
			$services[ $key ] = PressBook_Green_SiteIdentity::class;
		}
	}

	array_push( $services, PressBook_Green_PrimaryNavbar::class );
	array_push( $services, PressBook_Green_Posts_Grid_Header::class );
	array_push( $services, PressBook_Green_Posts_Grid_Related::class );
	array_push( $services, PressBook_Green_Block_Patterns::class );
	array_push( $services, PressBook_Green_Upsell::class );

	return $services;
}
add_filter( 'pressbook_services', 'pressbook_green_services' );

/**
 * Add grid posts section before the header ends.
 */
function pressbook_green_header_posts_grid() {
	PressBook_Green_Posts_Grid_Header::html();
}
add_action( 'pressbook_before_header_end', 'pressbook_green_header_posts_grid', 15 );

/**
 * Change default styles.
 *
 * @param  array $styles Default sttyles.
 * @return array
 */
function pressbook_green_default_styles( $styles ) {
	$styles['top_navbar_bg_color_1']         = '#5bb070';
	$styles['top_navbar_bg_color_2']         = '#3a864d';
	$styles['primary_navbar_bg_color']       = '#429656';
	$styles['primary_navbar_hover_bg_color'] = '#2c643a';
	$styles['button_bg_color_1']             = '#5bb070';
	$styles['button_bg_color_2']             = '#3a864d';
	$styles['footer_bg_color']               = 'rgba(255,255,255,0.9)';
	$styles['footer_credit_link_color']      = '#255430';

	return $styles;
}
add_filter( 'pressbook_default_styles', 'pressbook_green_default_styles' );

/**
 * Change welcome page title.
 *
 * @param  string $page_title Welcome page title.
 * @return string
 */
function pressbook_green_welcome_page_title( $page_title ) {
	return esc_html_x( 'PressBook Green', 'page title', 'pressbook-green' );
}
add_filter( 'pressbook_welcome_page_title', 'pressbook_green_welcome_page_title' );

/**
 * Change welcome menu title.
 *
 * @param  string $menu_title Welcome menu title.
 * @return string
 */
function pressbook_green_welcome_menu_title( $menu_title ) {
	return esc_html_x( 'PressBook Green', 'menu title', 'pressbook-green' );
}
add_filter( 'pressbook_welcome_menu_title', 'pressbook_green_welcome_menu_title' );

/**
 * Recommended plugins.
 */
require get_stylesheet_directory() . '/inc/recommended-plugins.php';

/**
 * Enqueue custom homepage styles for the Bicto portal landing page.
 */
function pressbook_green_bicto_homepage_styles() {
	if ( is_home() || is_front_page() ) {
		wp_enqueue_style( 'pressbook-green-bicto-home', get_stylesheet_directory_uri() . '/assets/css/bicto-home.css', array(), PRESSBOOK_GREEN_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'pressbook_green_bicto_homepage_styles' );