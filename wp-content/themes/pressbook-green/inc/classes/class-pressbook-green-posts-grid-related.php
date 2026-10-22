<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer related posts grid service.
 *
 * @package PressBook_Green
 */

/**
 * Related posts grid service class.
 */
class PressBook_Green_Posts_Grid_Related extends PressBook_Green_Posts_Grid {
	/**
	 * Add related posts grid options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->sec_posts_grid_related( $wp_customize );

		$this->set_related_posts_grid_enable( $wp_customize );
		$this->set_related_posts_grid_title( $wp_customize );
		$this->set_related_posts_grid_source( $wp_customize );
		$this->set_related_posts_grid_count( $wp_customize );
		$this->set_related_posts_grid_order( $wp_customize );
		$this->set_related_posts_grid_orderby( $wp_customize );
		$this->set_related_posts_grid_taxonomy( $wp_customize );
	}

	/**
	 * Section: Related Posts Grid.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function sec_posts_grid_related( $wp_customize ) {
		$wp_customize->add_section(
			'sec_posts_grid_related',
			array(
				'panel'       => 'pan_posts_grid',
				'title'       => esc_html__( 'Related Posts Grid', 'pressbook-green' ),
				'description' => esc_html__( 'You can customize the related posts grid options in here.', 'pressbook-green' ),
				'priority'    => 170,
			)
		);
	}

	/**
	 * Add setting: Enable Related Posts Grid.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_enable( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[enable]',
			array(
				'default'           => static::get_related_posts_grid_default( 'enable' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[enable]',
			array(
				'section' => 'sec_posts_grid_related',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable Related Posts Grid', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Title.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_title( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[title]',
			array(
				'default'           => static::get_related_posts_grid_default( 'title' ),
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[title]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'text',
				'label'       => esc_html__( 'Related Posts Title', 'pressbook-green' ),
				'description' => esc_html__( 'You can change the heading of the related posts grid that is shown below the single post content.', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Based On.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_source( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[source]',
			array(
				'default'           => static::get_related_posts_grid_default( 'source' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[source]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'select',
				'choices'     => array(
					'categories' => esc_html__( 'Categories', 'pressbook-green' ),
					'tags'       => esc_html__( 'Tags', 'pressbook-green' ),
				),
				'label'       => esc_html__( 'Related Posts Based On', 'pressbook-green' ),
				'description' => esc_html__( 'Select the source for related posts to display. Default: Categories', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Count.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_count( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[count]',
			array(
				'default'           => static::get_related_posts_grid_default( 'count' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[count]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'select',
				'choices'     => $this->count(),
				'label'       => esc_html__( 'Related Posts Count', 'pressbook-green' ),
				'description' => esc_html__( 'Set the number of related posts. Default: 6', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Order.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_order( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[order]',
			array(
				'default'           => static::get_related_posts_grid_default( 'order' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[order]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'select',
				'choices'     => $this->order(),
				'label'       => esc_html__( 'Related Posts Order', 'pressbook-green' ),
				'description' => esc_html__( 'Designates the ascending or descending order. Default: Latest First', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Order By.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_orderby( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[orderby]',
			array(
				'default'           => static::get_related_posts_grid_default( 'orderby' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[orderby]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'select',
				'choices'     => $this->orderby(),
				'label'       => esc_html__( 'Related Posts Order By', 'pressbook-green' ),
				'description' => esc_html__( 'Sort retrieved related posts by parameter. Default: Random Order', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Show Taxonomy on Hover.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_grid_taxonomy( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_grid[taxonomy]',
			array(
				'default'           => static::get_related_posts_grid_default( 'taxonomy' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_grid[taxonomy]',
			array(
				'section'     => 'sec_posts_grid_related',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show Taxonomy On Hover', 'pressbook-green' ),
				'description' => esc_html__( 'Whether to show the post category or tag on hover.', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Get setting: Related Posts Grid.
	 *
	 * @return array
	 */
	public static function get_related_posts_grid() {
		return wp_parse_args(
			get_theme_mod( 'set_related_posts_grid', array() ),
			static::get_related_posts_grid_default()
		);
	}

	/**
	 * Get default setting: Related Posts Grid.
	 *
	 * @param string $key Setting key.
	 * @return mixed|array
	 */
	public static function get_related_posts_grid_default( $key = '' ) {
		$default = apply_filters(
			'pressbook_default_related_posts_grid',
			array(
				'enable'   => true,
				'title'    => esc_html__( 'More Related Articles', 'pressbook-green' ),
				'source'   => 'categories',
				'count'    => 6,
				'order'    => 'desc',
				'orderby'  => 'rand',
				'taxonomy' => true,
			)
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Get related posts options and query.
	 *
	 * @return array|bool
	 */
	public static function options_query() {
		$options = static::get_related_posts_grid();

		if ( ! $options['enable'] ) {
			return false;
		}

		$query_args = array(
			'post_type'           => array( 'post' ),
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $options['count'] ),
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'order'               => strtoupper( $options['order'] ),
			'orderby'             => $options['orderby'],
		);

		if ( 'tags' === $options['source'] ) {
			$tags_id = wp_get_post_tags( get_the_ID(), array( 'fields' => 'ids' ) );
			if ( ! is_wp_error( $tags_id ) && ! empty( $tags_id ) ) {
				$query_args['tag__in'] = $tags_id;
			} else {
				return false;
			}
		} else {
			$categories_id = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );
			if ( ! is_wp_error( $categories_id ) && ! empty( $categories_id ) ) {
				$query_args['category__in'] = $categories_id;
			} else {
				return false;
			}
		}

		return array(
			'options' => $options,
			'query'   => ( new \WP_Query( $query_args ) ),
		);
	}
}
