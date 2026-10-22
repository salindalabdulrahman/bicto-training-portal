<?php
/**
 * Bicto Digital Training Portal: homepage helpers.
 *
 * Training events and announcements are ordinary WordPress posts:
 *   - Category slug "training-events": shown under Upcoming Training.
 *   - Category slug "announcements":   shown under Announcements.
 * Event details are entered in the "Training Event Details" box on the post edit screen.
 *
 * @package PressBook_Green
 */

defined( 'ABSPATH' ) || die();

/**
 * Sign In URL. Uses the existing WordPress authentication screen.
 * Override with the 'bicto_login_url' filter if an LMS login page is used.
 *
 * @return string
 */
function bicto_login_url() {
	return (string) apply_filters( 'bicto_login_url', wp_login_url() );
}

/**
 * Create an Account URL.
 *
 * Returns an empty string when registration is not enabled, so the template can show a
 * clearly labelled "not yet available" state instead of a dead link. Enable it in
 * Settings > General > "Anyone can register", or return a URL via 'bicto_register_url'
 * (for example the registration page of an LMS plugin).
 *
 * @return string
 */
function bicto_register_url() {
	$url = get_option( 'users_can_register' ) ? wp_registration_url() : '';
	return (string) apply_filters( 'bicto_register_url', $url );
}

/**
 * Access levels available for training events.
 *
 * @return array<string,string>
 */
function bicto_access_levels() {
	return array(
		'public'     => __( 'Open to the public', 'pressbook-green' ),
		'registered' => __( 'Registered users only', 'pressbook-green' ),
		'government' => __( 'Government employees / designated offices', 'pressbook-green' ),
		'approved'   => __( 'Approved participants only', 'pressbook-green' ),
	);
}

/**
 * Meta box for event details.
 */
function bicto_add_event_meta_box() {
	add_meta_box( 'bicto-event-details', __( 'Training Event Details', 'pressbook-green' ), 'bicto_render_event_meta_box', 'post', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'bicto_add_event_meta_box' );

/**
 * Render the event meta box.
 *
 * @param WP_Post $post Current post.
 */
function bicto_render_event_meta_box( $post ) {
	wp_nonce_field( 'bicto_event_meta', 'bicto_event_nonce' );

	$start    = get_post_meta( $post->ID, '_bicto_event_start', true );
	$start_in = $start ? str_replace( ' ', 'T', substr( $start, 0, 16 ) ) : '';
	$venue    = get_post_meta( $post->ID, '_bicto_event_venue', true );
	$audience = get_post_meta( $post->ID, '_bicto_event_audience', true );
	$access   = get_post_meta( $post->ID, '_bicto_event_access', true );
	$link     = get_post_meta( $post->ID, '_bicto_event_link', true );
	$type     = get_post_meta( $post->ID, '_bicto_event_type', true );
	?>
	<p class="description">
		<?php esc_html_e( 'Only used when this post is in the "Training Events" category (slug: training-events). Posts are public: do not paste private meeting links or participant lists here.', 'pressbook-green' ); ?>
	</p>
	<table class="form-table" role="presentation">
		<tr>
			<th><label for="bicto_event_start"><?php esc_html_e( 'Date and time', 'pressbook-green' ); ?></label></th>
			<td><input type="datetime-local" id="bicto_event_start" name="bicto_event_start" value="<?php echo esc_attr( $start_in ); ?>"> <span class="description"><?php esc_html_e( 'Site timezone. Events without a date are not listed.', 'pressbook-green' ); ?></span></td>
		</tr>
		<tr>
			<th><label for="bicto_event_type"><?php esc_html_e( 'Category label', 'pressbook-green' ); ?></label></th>
			<td><input type="text" class="regular-text" id="bicto_event_type" name="bicto_event_type" value="<?php echo esc_attr( $type ); ?>" placeholder="<?php esc_attr_e( 'Workshop, Webinar, Training…', 'pressbook-green' ); ?>"></td>
		</tr>
		<tr>
			<th><label for="bicto_event_venue"><?php esc_html_e( 'Venue or online delivery', 'pressbook-green' ); ?></label></th>
			<td><input type="text" class="large-text" id="bicto_event_venue" name="bicto_event_venue" value="<?php echo esc_attr( $venue ); ?>"></td>
		</tr>
		<tr>
			<th><label for="bicto_event_access"><?php esc_html_e( 'Who may join', 'pressbook-green' ); ?></label></th>
			<td>
				<select id="bicto_event_access" name="bicto_event_access">
					<?php foreach ( bicto_access_levels() as $key => $label ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $access ? $access : 'public', $key ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="bicto_event_audience"><?php esc_html_e( 'Audience / eligibility notes', 'pressbook-green' ); ?></label></th>
			<td><input type="text" class="large-text" id="bicto_event_audience" name="bicto_event_audience" value="<?php echo esc_attr( $audience ); ?>"></td>
		</tr>
		<tr>
			<th><label for="bicto_event_link"><?php esc_html_e( 'Registration link (optional)', 'pressbook-green' ); ?></label></th>
			<td><input type="url" class="large-text" id="bicto_event_link" name="bicto_event_link" value="<?php echo esc_attr( $link ); ?>"></td>
		</tr>
	</table>
	<?php
}

/**
 * Save event meta.
 *
 * @param int $post_id Post ID.
 */
function bicto_save_event_meta( $post_id ) {
	if ( ! isset( $_POST['bicto_event_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bicto_event_nonce'] ) ), 'bicto_event_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$start = isset( $_POST['bicto_event_start'] ) ? sanitize_text_field( wp_unslash( $_POST['bicto_event_start'] ) ) : '';
	$dt    = $start ? date_create_immutable_from_format( 'Y-m-d\TH:i', $start, wp_timezone() ) : false;
	if ( $dt ) {
		update_post_meta( $post_id, '_bicto_event_start', $dt->format( 'Y-m-d H:i:00' ) );
	} else {
		delete_post_meta( $post_id, '_bicto_event_start' );
	}

	$access = isset( $_POST['bicto_event_access'] ) ? sanitize_key( wp_unslash( $_POST['bicto_event_access'] ) ) : 'public';
	if ( ! array_key_exists( $access, bicto_access_levels() ) ) {
		$access = 'public';
	}
	update_post_meta( $post_id, '_bicto_event_access', $access );

	foreach ( array( 'venue', 'audience', 'type' ) as $field ) {
		$value = isset( $_POST[ 'bicto_event_' . $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'bicto_event_' . $field ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_bicto_event_' . $field );
		} else {
			update_post_meta( $post_id, '_bicto_event_' . $field, $value );
		}
	}

	$link = isset( $_POST['bicto_event_link'] ) ? esc_url_raw( wp_unslash( $_POST['bicto_event_link'] ) ) : '';
	if ( $link ) {
		update_post_meta( $post_id, '_bicto_event_link', $link );
	} else {
		delete_post_meta( $post_id, '_bicto_event_link' );
	}
}
add_action( 'save_post_post', 'bicto_save_event_meta' );

/**
 * Upcoming published training events (soonest first).
 *
 * @param int $limit Number of events.
 * @return WP_Query
 */
function bicto_get_upcoming_events( $limit = 6 ) {
	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'category_name'       => 'training-events',
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'meta_key'            => '_bicto_event_start', // phpcs:ignore WordPress.DB.SlowDBQuery
			'orderby'             => 'meta_value',
			'order'               => 'ASC',
			'meta_type'           => 'DATETIME',
			'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'key'     => '_bicto_event_start',
					'value'   => current_time( 'Y-m-d H:i:s' ),
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
		)
	);
}

/**
 * Latest published announcements.
 *
 * @param int $limit Number of posts.
 * @return WP_Query
 */
function bicto_get_announcements( $limit = 3 ) {
	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'category_name'       => 'announcements',
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
}

/**
 * Customizer: official contact details (nothing is shown unless entered).
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function bicto_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'bicto_contact',
		array(
			'title'       => __( 'Portal Contact Details', 'pressbook-green' ),
			'description' => __( 'Shown in the homepage footer. Leave blank to hide.', 'pressbook-green' ),
			'priority'    => 160,
		)
	);

	$fields = array(
		'bicto_contact_email'   => array( __( 'Official email', 'pressbook-green' ), 'sanitize_email', 'email' ),
		'bicto_contact_phone'   => array( __( 'Official phone', 'pressbook-green' ), 'sanitize_text_field', 'text' ),
		'bicto_contact_address' => array( __( 'Office address', 'pressbook-green' ), 'sanitize_textarea_field', 'textarea' ),
		'bicto_social_facebook' => array( __( 'Official Facebook page URL', 'pressbook-green' ), 'esc_url_raw', 'url' ),
		'bicto_courses_url'     => array( __( 'Public course listing URL (optional)', 'pressbook-green' ), 'esc_url_raw', 'url' ),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => $field[1],
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field[0],
				'section' => 'bicto_contact',
				'type'    => $field[2],
			)
		);
	}
}
add_action( 'customize_register', 'bicto_customize_register' );

/**
 * Courses URL: defaults to the on-page course section.
 *
 * @return string
 */
function bicto_courses_url() {
	$url = get_theme_mod( 'bicto_courses_url', '' );
	return $url ? $url : home_url( '/#training-courses' );
}

/**
 * Homepage title and meta description (skipped if an SEO plugin is active).
 */
function bicto_front_page_title( $title ) {
	if ( is_front_page() ) {
		$title['title']   = 'Bicto Digital Training Portal';
		$title['tagline'] = 'Creating Digitally Empowered Bangsamoro';
	}
	return $title;
}
add_filter( 'document_title_parts', 'bicto_front_page_title' );

function bicto_front_page_meta_description() {
	if ( ! is_front_page() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( 'Official ICT Literacy & E-Governance Training Platform under the Bangsamoro Information and Communications Technology Office (BICTO). Explore training courses open to learners, professionals, government employees, and the public.' ) . '">' . "\n";
}
add_action( 'wp_head', 'bicto_front_page_meta_description', 1 );

/**
 * Admin bar clearance and body class helper for the sticky header.
 */
function bicto_enqueue_homepage_assets() {
	if ( ! is_front_page() && ! is_home() ) {
		return;
	}
	wp_enqueue_style( 'pressbook-green-bicto-home', get_stylesheet_directory_uri() . '/assets/css/bicto-home.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/bicto-home.css' ) );
	wp_enqueue_script( 'pressbook-green-bicto-home', get_stylesheet_directory_uri() . '/assets/js/bicto-home.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/bicto-home.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'bicto_enqueue_homepage_assets' );
