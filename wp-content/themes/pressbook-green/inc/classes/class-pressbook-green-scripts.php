<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Scripts service.
 *
 * @package PressBook_Green
 */

/**
 * Enqueue theme styles and scripts.
 */
class PressBook_Green_Scripts extends PressBook\Scripts {
	/**
	 * Register service features.
	 */
	public function register() {
		parent::register();

		// Remove parent theme inline stlyes.
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );

		if ( is_admin() && isset( $GLOBALS['pagenow'] ) && in_array( $GLOBALS['pagenow'], array( 'widgets.php', 'nav-menus.php' ), true ) ) {
			add_action( 'wp_print_styles', array( $this, 'remove_dynamic_styles' ) );
		}
	}

	/**
	 * Remove parent theme inline style.
	 */
	public function print_styles() {
		if ( wp_style_is( 'pressbook-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-style', 'after', '' );
		}
	}

	/**
	 * Remove theme inline style.
	 */
	public function remove_dynamic_styles() {
		if ( wp_style_is( 'pressbook-green-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-green-style', 'after', '' );
		}
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		// Enqueue child theme fonts.
		wp_enqueue_style( 'pressbook-green-fonts', static::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		// Enqueue parent theme styles and scripts.
		parent::enqueue_scripts();

		// Dequeue parent theme fonts.
		wp_dequeue_style( 'pressbook-fonts' );

		// Enqueue child theme stylesheet.
		wp_enqueue_style( 'pressbook-green-style', get_stylesheet_directory_uri() . '/style.min.css', array(), PRESSBOOK_GREEN_VERSION );
		wp_style_add_data( 'pressbook-green-style', 'rtl', 'replace' );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-green-style', PressBook_Green_CSSRules::output() );
	}

	/**
	 * Get fonts URL.
	 */
	public static function fonts_url() {
		$fonts_url = '';

		$font_families = array();

		$query_params = array();

		/* translators: If there are characters in your language that are not supported by Roboto Serif, translate this to 'off'. Do not translate into your own language. */
		$roboto_serif = _x( 'on', 'Roboto Serif font: on or off', 'pressbook-green' );
		if ( 'off' !== $roboto_serif ) {
			array_push( $font_families, 'Roboto+Serif:ital,wght@0,400;0,600;1,400;1,600' );
		}

		/* translators: If there are characters in your language that are not supported by Domine, translate this to 'off'. Do not translate into your own language. */
		$domine = _x( 'on', 'Domine font: on or off', 'pressbook-green' );
		if ( 'off' !== $domine ) {
			array_push( $font_families, 'Domine:wght@400;600' );
		}

		if ( count( $font_families ) > 0 ) {
			foreach ( $font_families as $font_family ) {
				array_push( $query_params, ( 'family=' . $font_family ) );
			}

			array_push( $query_params, 'display=swap' );

			$fonts_url = ( 'https://fonts.googleapis.com/css2?' . implode( '&', $query_params ) );
		}

		$fonts_url = apply_filters( 'pressbook_green_fonts_url', $fonts_url );

		$fonts_url = esc_url_raw( $fonts_url );

		if ( function_exists( 'wptt_get_webfont_url' ) ) {
			return wptt_get_webfont_url( $fonts_url );
		}

		return $fonts_url;
	}
}
