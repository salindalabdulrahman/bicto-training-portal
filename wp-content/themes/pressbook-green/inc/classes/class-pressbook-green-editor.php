<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Editor service.
 *
 * @package PressBook_Green
 */

/**
 * Editor setup.
 */
class PressBook_Green_Editor extends PressBook\Editor {
	/**
	 * Register service features.
	 */
	public function register() {
		add_action( 'after_setup_theme', array( $this, 'support_editor_styles' ) );

		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
	}

	/**
	 * Enqueue block assets.
	 */
	public function enqueue_block_assets() {
		if ( $this->is_block_screen() ) {
			$this->enqueue_assets();
		}
	}

	/**
	 * Enqueue assets.
	 */
	public function enqueue_assets() {
		// Enqueue fonts.
		wp_enqueue_style( 'pressbook-green-editor-fonts', PressBook_Green_Scripts::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		// Add inline style for fonts in the block editor.
		$this->load_editor_fonts_css();

		// Enqueue the block editor stylesheet.
		wp_enqueue_style( 'pressbook-green-block-editor-style', get_theme_file_uri( 'assets/css/block-editor.css' ), array(), PRESSBOOK_GREEN_VERSION );
		wp_style_add_data( 'pressbook-green-block-editor-style', 'rtl', 'replace' );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-green-block-editor-style', PressBook_Green_CSSRules::output_editor() );
	}

	/**
	 * Check if block editor screen, but not widgets or nav-menus screen.
	 *
	 * @return bool
	 */
	public function is_block_screen() {
		if ( function_exists( '\get_current_screen' ) ) {
			$current_screen = get_current_screen();
			if ( $current_screen ) {
				if ( \in_array( $current_screen->id, array( 'widgets', 'nav-menus' ), true ) ) {
					return false;
				}

				if ( \method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Add inline style for fonts in the block editor.
	 */
	public function load_editor_fonts_css() {
		$fonts_css = '';

		/* translators: If there are characters in your language that are not supported by Roboto Serif, translate this to 'off'. Do not translate into your own language. */
		$roboto_serif = _x( 'on', 'Roboto Serif font (in the editor): on or off', 'pressbook-green' );
		if ( 'off' !== $roboto_serif ) {
			$fonts_css .= ( '.editor-styles-wrapper.editor-styles-wrapper{font-family:\'Roboto Serif\', sans-serif;}' );
		}

		/* translators: If there are characters in your language that are not supported by Domine, translate this to 'off'. Do not translate into your own language. */
		$domine = _x( 'on', 'Domine font (in the editor): on or off', 'pressbook-green' );
		if ( 'off' !== $domine ) {
			$fonts_css .= ( '.editor-styles-wrapper .editor-post-title__input,.editor-styles-wrapper .editor-post-title .editor-post-title__input,.editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{font-family:\'Domine\', sans-serif;}' );
		}

		if ( '' !== $fonts_css ) {
			wp_add_inline_style( 'pressbook-green-editor-fonts', $fonts_css );
		}
	}
}
