<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Block patterns service.
 *
 * @package PressBook_Green
 */

/**
 * Register block patterns.
 */
class PressBook_Green_Block_Patterns implements PressBook\Serviceable {
	/**
	 * Register service features.
	 */
	public function register() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Register block patterns and category.
	 */
	public function init() {
		/**
		 * Register block pattern category.
		 */
		if ( function_exists( 'register_block_pattern_category' ) ) {
			register_block_pattern_category(
				'pressbook-green',
				array( 'label' => esc_html__( 'PressBook', 'pressbook-green' ) )
			);
		}

		/**
		 * Register block patterns.
		 */
		if ( function_exists( 'register_block_pattern' ) ) {
			$this->block_pattern_four_columns_main_heading_no_gap();
			$this->block_pattern_four_columns_main_heading();
			$this->block_pattern_three_columns_stack_no_gap();
			$this->block_pattern_three_columns_stack();
			$this->block_pattern_banner_green();
		}
	}

	/**
	 * Block pattern: 4-Columns (No Gap) with Main Heading.
	 */
	public function block_pattern_four_columns_main_heading_no_gap() {
		register_block_pattern(
			'pressbook/four-columns-main-heading-no-gap',
			array(
				'title'         => esc_html__( '4-Columns (No Gap) with Main Heading', 'pressbook-green' ),
				'categories'    => array( 'pressbook-green' ),
				'viewportWidth' => 1440,
				'content'       => ( '<!-- wp:group {"backgroundColor":"white","className":"pb-group-pattern","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-group-pattern has-white-background-color has-background"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"1.9em"},"color":{"text":"#404040"}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#404040;font-size:1.9em">' . esc_html__( 'PEOPLE WORKING WITH US', 'pressbook-green' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#404040"},"typography":{"fontSize":"1em"}}} -->
<p class="has-text-align-center has-text-color" style="color:#404040;font-size:1em">' . esc_html__( 'Lorem ipsum dolor sit amet. Praesent dapibus, cursus faucibus, eu vulputate magna eros eu erat. Aliquam erat volutpat.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"pb-pattern-cols pb-no-gap"} -->
<div class="wp-block-columns pb-pattern-cols pb-no-gap"><!-- wp:column {"width":"","style":{"color":{"background":"#429656"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#429656;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#3b874d"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#3b874d;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#357845"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#357845;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#2e693c"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#2e693c;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->' ),
			)
		);
	}

	/**
	 * Block pattern: 4-Columns with Main Heading.
	 */
	public function block_pattern_four_columns_main_heading() {
		register_block_pattern(
			'pressbook/four-columns-main-heading',
			array(
				'title'         => esc_html__( '4-Columns with Main Heading', 'pressbook-green' ),
				'categories'    => array( 'pressbook-green' ),
				'viewportWidth' => 1440,
				'content'       => ( '<!-- wp:group {"backgroundColor":"white","className":"pb-group-pattern","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-group-pattern has-white-background-color has-background"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"1.9em"},"color":{"text":"#404040"}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#404040;font-size:1.9em">' . esc_html__( 'PEOPLE WORKING WITH US', 'pressbook-green' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#404040"},"typography":{"fontSize":"1em"}}} -->
<p class="has-text-align-center has-text-color" style="color:#404040;font-size:1em">' . esc_html__( 'Lorem ipsum dolor sit amet. Praesent dapibus, cursus faucibus, eu vulputate magna eros eu erat. Aliquam erat volutpat.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"pb-pattern-cols"} -->
<div class="wp-block-columns pb-pattern-cols"><!-- wp:column {"width":"","style":{"color":{"background":"#429656"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#429656;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#3b874d"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#3b874d;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#357845"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#357845;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"color":{"background":"#2e693c"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-column has-background" style="background-color:#2e693c;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.1em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:1.1em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.8em"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:0.8em">' . esc_html__( 'Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, diam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->' ),
			)
		);
	}

	/**
	 * Block pattern: 3-Columns (No Gap) Stack.
	 */
	public function block_pattern_three_columns_stack_no_gap() {
		register_block_pattern(
			'pressbook/three-columns-stack-no-gap',
			array(
				'title'         => esc_html__( '3-Columns (No Gap) Stack', 'pressbook-green' ),
				'categories'    => array( 'pressbook-green' ),
				'viewportWidth' => 1440,
				'content'       => ( '<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}},"className":"pb-group-pattern","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-group-pattern" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"color":{"background":"#429656"}},"className":"pb-no-b-margin pb-no-t-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-no-b-margin pb-no-t-margin has-background" style="background-color:#429656"><!-- wp:heading {"textAlign":"left","level":3,"style":{"typography":{"fontSize":"1.2em","textTransform":"uppercase"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-left has-white-color has-text-color" style="font-size:1.2em;text-transform:uppercase">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#3b874d"}},"className":"pb-no-b-margin pb-no-t-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-no-b-margin pb-no-t-margin has-background" style="background-color:#3b874d"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.2em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.2em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#357845"}},"className":"pb-no-b-margin pb-no-t-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-no-b-margin pb-no-t-margin has-background" style="background-color:#357845"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.2em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.2em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->' ),
			)
		);
	}

	/**
	 * Block pattern: 3-Columns Stack.
	 */
	public function block_pattern_three_columns_stack() {
		register_block_pattern(
			'pressbook/three-columns-stack',
			array(
				'title'         => esc_html__( '3-Columns Stack', 'pressbook-green' ),
				'categories'    => array( 'pressbook-green' ),
				'viewportWidth' => 1440,
				'content'       => ( '<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}},"className":"pb-group-pattern","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-group-pattern" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"color":{"background":"#429656"}},"className":"pb-b-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-b-margin has-background" style="background-color:#429656"><!-- wp:heading {"textAlign":"left","level":3,"style":{"typography":{"fontSize":"1.2em","textTransform":"uppercase"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-text-align-left has-white-color has-text-color" style="font-size:1.2em;text-transform:uppercase">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#3b874d"}},"className":"pb-b-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-b-margin has-background" style="background-color:#3b874d"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.2em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.2em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"color":{"background":"#357845"}},"className":"pb-b-margin","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-b-margin has-background" style="background-color:#357845"><!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.2em"}},"textColor":"white"} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.2em">' . esc_html__( 'RECYCLING', 'pressbook-green' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9em"}},"textColor":"white"} -->
<p class="has-white-color has-text-color" style="font-size:0.9em">' . esc_html__( 'Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->' ),
			)
		);
	}

	/**
	 * Block pattern: Banner Green with Title.
	 */
	public function block_pattern_banner_green() {
		register_block_pattern(
			'pressbook/banner-green',
			array(
				'title'         => esc_html__( 'Banner Green with Title', 'pressbook-green' ),
				'categories'    => array( 'pressbook-green' ),
				'viewportWidth' => 1440,
				'content'       => ( '<!-- wp:group {"style":{"color":{"background":"#429656"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"className":"pb-group-pattern","layout":{"type":"constrained"}} -->
<div class="wp-block-group pb-group-pattern has-background" style="background-color:#429656;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.2em","lineHeight":"2.1"}},"textColor":"white","className":"pb-no-t-margin pb-no-b-margin"} -->
<p class="has-text-align-center pb-no-t-margin pb-no-b-margin has-white-color has-text-color" style="font-size:1.2em;line-height:2.1">' . esc_html__( 'NEED URGENT DONATION FOR', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.8em","lineHeight":"1.7"}},"textColor":"white","className":"pb-no-t-margin pb-no-b-margin"} -->
<p class="has-text-align-center pb-no-t-margin pb-no-b-margin has-white-color has-text-color" style="font-size:1.8em;line-height:1.7"><strong>' . esc_html__( 'PROTECT &amp; CARE OUR ENVIRONMENT', 'pressbook-green' ) . '</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.85em","lineHeight":"2.1"}},"textColor":"white","className":"pb-no-t-margin pb-no-b-margin"} -->
<p class="has-text-align-center pb-no-t-margin pb-no-b-margin has-white-color has-text-color" style="font-size:0.85em;line-height:2.1">' . esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'pressbook-green' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->' ),
			)
		);
	}
}
