<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer header posts grid service.
 *
 * @package PressBook_Green
 */

/**
 * Header posts grid service class.
 */
class PressBook_Green_Posts_Grid_Header extends PressBook_Green_Posts_Grid {
	/**
	 * Register service features.
	 */
	public function register() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_scripts' ) );
	}

	/**
	 * Add header posts grid options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->pan_posts_grid( $wp_customize );

		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( PressBook_Green_Select_Multiple::class );
		}

		$this->sec_posts_grid_header( $wp_customize );

		$this->set_header_posts_grid_enable( $wp_customize );
		$this->set_header_posts_grid_show( $wp_customize );
		$this->set_header_posts_grid_source( $wp_customize );
		$this->set_header_posts_grid_categories( $wp_customize );
		$this->set_header_posts_grid_tags( $wp_customize );
		$this->set_header_posts_grid_order( $wp_customize );
		$this->set_header_posts_grid_orderby( $wp_customize );
		$this->set_header_posts_grid_taxonomy( $wp_customize );
		$this->set_header_posts_grid_max( $wp_customize );
		$this->set_header_posts_grid_hide_if_less( $wp_customize );
		$this->set_header_posts_grid_hover_effect( $wp_customize );
	}

	/**
	 * Contextual controls scripts.
	 */
	public function customize_controls_scripts() {
		wp_enqueue_script( 'pressbook-green-customizer-contextual', get_stylesheet_directory_uri() . '/assets/js/customizer-contextual.js', array( 'customize-controls' ), PRESSBOOK_GREEN_VERSION, true );
	}

	/**
	 * Panel: Posts Grid.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function pan_posts_grid( $wp_customize ) {
		$wp_customize->add_panel(
			'pan_posts_grid',
			array(
				'title'       => esc_html__( 'Posts Grid', 'pressbook-green' ),
				'description' => esc_html__( 'You can customize the posts grid options in here.', 'pressbook-green' ),
				'priority'    => 160,
			)
		);
	}

	/**
	 * Section: Header Posts Grid.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function sec_posts_grid_header( $wp_customize ) {
		$wp_customize->add_section(
			'sec_posts_grid_header',
			array(
				'panel'       => 'pan_posts_grid',
				'title'       => esc_html__( 'Header Posts Grid', 'pressbook-green' ),
				'description' => esc_html__( 'You can customize the header posts grid options in here.', 'pressbook-green' ),
				'priority'    => 165,
			)
		);
	}

	/**
	 * Add setting: Enable Header Posts Grid.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_enable( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[enable]',
			array(
				'default'           => static::get_header_posts_grid_default( 'enable' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[enable]',
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable Header Posts Grid', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Source.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_source( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[source]',
			array(
				'default'           => static::get_header_posts_grid_default( 'source' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[source]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'select',
				'choices'     => $this->source(),
				'label'       => esc_html__( 'Header Posts Grid Source', 'pressbook-green' ),
				'description' => esc_html__( 'Default: All Posts', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Categories.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_categories( $wp_customize ) {
		$set_id = 'set_header_posts_grid[categories]';

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_header_posts_grid_default( 'categories' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( $this, 'sanitize_array' ),
			)
		);

		$control_args = array(
			'section'         => 'sec_posts_grid_header',
			'type'            => 'pressbook-select-multiple',
			'choices'         => $this->categories(),
			'label'           => esc_html__( 'Header Posts Grid Categories', 'pressbook-green' ),
			'description'     => esc_html__( 'Select the categories for the posts grid in the header. You can select multiple categories by holding the CTRL key.', 'pressbook-green' ),
			'settings'        => ( isset( $wp_customize->selective_refresh ) ) ? array( $set_id ) : $set_id,
			'active_callback' => function () {
				$header_posts_grid = static::get_header_posts_grid();
				if ( 'categories' === $header_posts_grid['source'] ) {
					return true;
				}

				return false;
			},
		);

		$wp_customize->add_control(
			new PressBook_Green_Select_Multiple(
				$wp_customize,
				$set_id,
				$control_args
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Tags.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_tags( $wp_customize ) {
		$set_id = 'set_header_posts_grid[tags]';

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_header_posts_grid_default( 'tags' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( $this, 'sanitize_array' ),
			)
		);

		$control_args = array(
			'section'         => 'sec_posts_grid_header',
			'type'            => 'pressbook-select-multiple',
			'choices'         => $this->tags(),
			'label'           => esc_html__( 'Header Posts Grid Tags', 'pressbook-green' ),
			'description'     => esc_html__( 'Select the tags for the posts grid in the header. You can select multiple tags by holding the CTRL key.', 'pressbook-green' ),
			'settings'        => ( isset( $wp_customize->selective_refresh ) ) ? array( $set_id ) : $set_id,
			'active_callback' => function () {
				$header_posts_grid = static::get_header_posts_grid();
				if ( 'tags' === $header_posts_grid['source'] ) {
					return true;
				}

				return false;
			},
		);

		$wp_customize->add_control(
			new PressBook_Green_Select_Multiple(
				$wp_customize,
				$set_id,
				$control_args
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Order.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_order( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[order]',
			array(
				'default'           => static::get_header_posts_grid_default( 'order' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[order]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'select',
				'choices'     => $this->order(),
				'label'       => esc_html__( 'Header Posts Grid Order', 'pressbook-green' ),
				'description' => esc_html__( 'Designates the ascending or descending order. Default: Latest First', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Order By.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_orderby( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[orderby]',
			array(
				'default'           => static::get_header_posts_grid_default( 'orderby' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[orderby]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'select',
				'choices'     => $this->orderby(),
				'label'       => esc_html__( 'Header Posts Grid Order By', 'pressbook-green' ),
				'description' => esc_html__( 'Sort retrieved related posts by parameter. Default: Random Order', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Show Taxonomy on Hover.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_taxonomy( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[taxonomy]',
			array(
				'default'           => static::get_header_posts_grid_default( 'taxonomy' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[taxonomy]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Show Taxonomy On Hover', 'pressbook-green' ),
				'description' => esc_html__( 'Whether to show the post category or tag on hover.', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Maximum Number Of Posts.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_max( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[max]',
			array(
				'default'           => static::get_header_posts_grid_default( 'max' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[max]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'select',
				'choices'     => array(
					'1' => esc_html_x( '1', 'Maximum Number Of Posts (Grid Layout)', 'pressbook-green' ),
					'2' => esc_html_x( '2', 'Maximum Number Of Posts (Grid Layout)', 'pressbook-green' ),
					'3' => esc_html_x( '3', 'Maximum Number Of Posts (Grid Layout)', 'pressbook-green' ),
					'4' => esc_html_x( '4', 'Maximum Number Of Posts (Grid Layout)', 'pressbook-green' ),
					'5' => esc_html_x( '5', 'Maximum Number Of Posts (Grid Layout)', 'pressbook-green' ),
				),
				'label'       => esc_html__( 'Maximum Number Of Posts', 'pressbook-green' ),
				'description' => esc_html__( 'You can limit number of posts to be shown. If the number of posts found is less than the maximum limit, then the posts grid layout will adjust automatically in the best possible manner. Default: 4', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Hide Posts Grid If Less Than or Equal To.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_hide_if_less( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[hide_if_less]',
			array(
				'default'           => static::get_header_posts_grid_default( 'hide_if_less' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[hide_if_less]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'select',
				'choices'     => array(
					'0' => esc_html_x( '0', 'Hide Posts Grid If Less Than or Equal To (Grid Layout)', 'pressbook-green' ),
					'1' => esc_html_x( '1', 'Hide Posts Grid If Less Than or Equal To (Grid Layout)', 'pressbook-green' ),
					'2' => esc_html_x( '2', 'Hide Posts Grid If Less Than or Equal To (Grid Layout)', 'pressbook-green' ),
				),
				'label'       => esc_html__( 'Hide Posts Grid If Less Than or Equal To', 'pressbook-green' ),
				'description' => esc_html__( 'Hide the header posts grid if number of posts found is less than or equal to this number. Default: 1', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Zoom On Hover Effect.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_hover_effect( $wp_customize ) {
		$wp_customize->add_setting(
			'set_header_posts_grid[hover_effect]',
			array(
				'default'           => static::get_header_posts_grid_default( 'hover_effect' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_header_posts_grid[hover_effect]',
			array(
				'section'     => 'sec_posts_grid_header',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Zoom On Hover Effect', 'pressbook-green' ),
				'description' => esc_html__( 'You can enable or disable the zoom effect on hover over the image.', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Add setting: Header Posts Grid Show.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_header_posts_grid_show( $wp_customize ) {
		$default_show = static::get_header_posts_grid_default( 'show' );

		$set_id = 'set_header_posts_grid[show]';

		$set_in_front = ( $set_id . '[in_front]' );

		$wp_customize->add_setting(
			$set_in_front,
			array(
				'type'              => 'theme_mod',
				'default'           => $default_show['in_front'],
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_front,
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Front Page', 'pressbook-green' ),
			)
		);

		$set_in_blog = ( $set_id . '[in_blog]' );

		$wp_customize->add_setting(
			$set_in_blog,
			array(
				'type'              => 'theme_mod',
				'default'           => $default_show['in_blog'],
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_blog,
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Blog Page', 'pressbook-green' ),
			)
		);

		$set_in_archive = ( $set_id . '[in_archive]' );

		$wp_customize->add_setting(
			$set_in_archive,
			array(
				'type'              => 'theme_mod',
				'default'           => $default_show['in_archive'],
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_archive,
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Archive Pages', 'pressbook-green' ),
			)
		);

		$set_in_post = ( $set_id . '[in_post]' );

		$wp_customize->add_setting(
			$set_in_post,
			array(
				'type'              => 'theme_mod',
				'default'           => $default_show['in_post'],
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_post,
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Posts', 'pressbook-green' ),
			)
		);

		$set_in_page = ( $set_id . '[in_page]' );

		$wp_customize->add_setting(
			$set_in_page,
			array(
				'type'              => 'theme_mod',
				'default'           => $default_show['in_page'],
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_page,
			array(
				'section' => 'sec_posts_grid_header',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Pages', 'pressbook-green' ),
			)
		);
	}

	/**
	 * Get setting: Header Posts Grid.
	 *
	 * @return array
	 */
	public static function get_header_posts_grid() {
		return wp_parse_args(
			get_theme_mod( 'set_header_posts_grid', array() ),
			static::get_header_posts_grid_default()
		);
	}

	/**
	 * Get default setting: Header Posts Grid.
	 *
	 * @param string $key Setting key.
	 * @return mixed|array
	 */
	public static function get_header_posts_grid_default( $key = '' ) {
		$default = apply_filters(
			'pressbook_default_header_posts_grid',
			array(
				'enable'       => true,
				'source'       => '',
				'categories'   => array(),
				'tags'         => array(),
				'order'        => 'desc',
				'orderby'      => 'rand',
				'taxonomy'     => true,
				'max'          => 4,
				'hide_if_less' => 1,
				'hover_effect' => true,
				'show'         => array(
					'in_front'   => true,
					'in_blog'    => true,
					'in_archive' => false,
					'in_post'    => false,
					'in_page'    => false,
				),
			)
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Get header posts options and query.
	 *
	 * @return array|bool
	 */
	public static function options_query() {
		$options = static::get_header_posts_grid();

		if ( ! $options['enable'] ) {
			return false;
		}

		$grid_show = wp_parse_args(
			$options['show'],
			static::get_header_posts_grid_default()['show']
		);

		if ( ( is_front_page() && ! $grid_show['in_front'] ) ||
			( is_home() && ! $grid_show['in_blog'] ) ||
			( is_archive() && ! $grid_show['in_archive'] ) ||
			( is_404() ) ||
			( is_search() && ! $grid_show['in_archive'] ) ||
			( is_single() && ! $grid_show['in_post'] ) ||
			( ( ! is_front_page() && is_page() ) && ! $grid_show['in_page'] ) ) {
			return false;
		}

		$query_args = array(
			'post_type'           => array( 'post' ),
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $options['max'] ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'order'               => strtoupper( $options['order'] ),
			'orderby'             => $options['orderby'],
		);

		if ( is_singular( 'post' ) ) {
			$query_args['post__not_in'] = array( get_the_ID() );
		}

		if ( 'categories' === $options['source'] ) {
			if ( is_array( $options['categories'] ) && ! empty( $options['categories'] ) ) {
				$query_args['category__in'] = $options['categories'];
			} else {
				return false;
			}
		} elseif ( 'tags' === $options['source'] ) {
			if ( is_array( $options['tags'] ) && ! empty( $options['tags'] ) ) {
				$query_args['tag__in'] = $options['tags'];
			} else {
				return false;
			}
		}

		return array(
			'options' => $options,
			'query'   => ( new \WP_Query( $query_args ) ),
		);
	}

	/**
	 * Get header posts grid HTML.
	 */
	public static function html() {
		$pressbook_posts = static::options_query();
		if ( ! $pressbook_posts ) {
			return;
		}

		$pressbook_query = $pressbook_posts['query'];
		if ( ! $pressbook_query->have_posts() ) {
			return;
		}

		$pressbook_count = absint( $pressbook_query->post_count );
		$pb_hide_if_less = absint( $pressbook_posts['options']['hide_if_less'] );

		if ( $pressbook_count <= $pb_hide_if_less ) {
			return;
		}

		$pb_class = '';
		if ( $pressbook_posts['options']['hover_effect'] ) {
			$pb_class .= ' pb-featured-zoom';
		}
		?>
		<div class="u-wrapper pb-header-posts-grid pb-featured-grid-<?php echo esc_attr( $pressbook_count . $pb_class ); ?>">
			<div class="pb-row header-posts-grid">
				<?php
				while ( $pressbook_query->have_posts() ) {
					$pressbook_query->the_post();

					if ( 5 === $pressbook_count ) {
						?>
						<div class="pb-col-md-6 pb-col-lg-6">
						<?php
						if ( 1 === $pressbook_query->current_post ) {
							?>
							<div class="pb-row">
								<div class="pb-col-md-6 pb-col-lg-6">
							<?php
						}

						static::output_featured_post( $pressbook_posts );
						?>

						</div>
						<?php
						if ( 4 === $pressbook_query->current_post ) {
							?>
								</div>
							</div>
							<?php
						}
						?>
						<?php
					} elseif ( 4 === $pressbook_count ) {
						?>
						<div class="pb-col-sm-6 pb-col-md-6 pb-col-lg-3">
							<?php static::output_featured_post( $pressbook_posts ); ?>
						</div>
						<?php
					} elseif ( 3 === $pressbook_count ) {
						?>
						<div class="pb-col-sm-6 pb-col-md-4 pb-col-lg-4">
							<?php static::output_featured_post( $pressbook_posts ); ?>
						</div>
						<?php
					} elseif ( 2 === $pressbook_count ) {
						?>
						<div class="pb-col-sm-6 pb-col-md-6 pb-col-lg-6">
							<?php static::output_featured_post( $pressbook_posts ); ?>
						</div>
						<?php
					} else {
						?>
						<div class="pb-col-sm-12 pb-col-md-12 pb-col-lg-12">
							<?php static::output_featured_post( $pressbook_posts ); ?>
						</div>
						<?php
					}
				}

				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the HTML of featured post in the grid.
	 *
	 * @param array $pressbook_posts Options and query loop.
	 */
	public static function output_featured_post( $pressbook_posts ) {
		$pressbook_query      = $pressbook_posts['query'];
		$pressbook_categories = get_the_category( get_the_ID() );
		?>
		<div class="pb-featured-post pb-featured-post-<?php echo esc_attr( $pressbook_query->current_post ); ?>">
			<a href="<?php the_permalink(); ?>" class="pb-featured-link">
				<?php
				if ( has_post_thumbnail() ) {
					?>
					<?php
					the_post_thumbnail(
						'post-thumbnail',
						array( 'class' => 'pb-featured-image' )
					);
					?>
					<?php
				}

				if ( '' !== get_the_title() ) {
					?>
					<span class="pb-featured-title"><?php the_title(); ?></span>
					<?php
				}

				if ( $pressbook_posts['options']['taxonomy'] ) {
					if ( ! empty( $pressbook_categories ) ) {
						$pressbook_category = $pressbook_categories[0];
						?>
						<span class="pb-featured-taxonomy"><?php echo esc_html( $pressbook_category->name ); ?></span>
						<?php
					} else {
						$pressbook_tags = get_the_tags( get_the_ID() );
						if ( ! empty( $pressbook_tags ) ) {
							$pressbook_tag = $pressbook_tags[0];
							?>
						<span class="pb-featured-taxonomy"><?php echo esc_html( $pressbook_tag->name ); ?></span>
							<?php
						}
					}
				}
				?>
			</a>
		</div>
		<?php
	}

	/**
	 * Post Categories.
	 *
	 * @return array
	 */
	public function categories() {
		$data       = array();
		$categories = get_categories(
			array(
				'orderby'    => 'count',
				'hide_empty' => false,
			)
		);

		foreach ( $categories as $category ) {
			$data[ $category->term_id ] = $category->name;
		}

		return $data;
	}

	/**
	 * Post Tags.
	 *
	 * @return array
	 */
	public function tags() {
		$data = array();
		$tags = get_tags(
			array(
				'orderby'    => 'count',
				'hide_empty' => false,
			)
		);

		foreach ( $tags as $tag ) {
			$data[ $tag->term_id ] = $tag->name;
		}

		return $data;
	}

	/**
	 * Sanitize controls that returns array.
	 *
	 * @param mixed $input The input from the setting.
	 * @return array
	 */
	public function sanitize_array( $input ) {
		$output = $input;

		if ( ! is_array( $input ) ) {
			$output = explode( ',', $input );
		}

		if ( ! empty( $output ) ) {
			return array_map( 'sanitize_text_field', $output );
		}

		return array();
	}
}
