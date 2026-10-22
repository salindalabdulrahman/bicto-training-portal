<?php
/**
 * Bicto Digital Training Portal: modal sign-in and registration.
 *
 * Load from functions.php:
 *     require_once get_stylesheet_directory() . '/inc/bicto-auth.php';
 *
 * What lives here
 *  - Single source of truth for who can register (audiences) and which tracks exist.
 *  - Asset enqueueing (front page only, logged-out visitors only).
 *  - Two AJAX endpoints: bicto_login and bicto_register (nonce, honeypot, throttling).
 *  - Account metadata + a small admin UI to verify government accounts.
 *
 * @package PressBook_Green
 */

defined( 'ABSPATH' ) || die();

/* -------------------------------------------------------------------------
 * Shared data
 * ---------------------------------------------------------------------- */

/**
 * Who the portal is for. Mirrors the "Learning for everyone" panel on the homepage,
 * so the hero list, the registration form and the server-side whitelist never drift apart.
 *
 * access = the access level the person is asking for. 'government' accounts are created
 * as pending until an administrator verifies them.
 *
 * @return array<string,array<string,mixed>>
 */
function bicto_auth_audiences() {
	return apply_filters(
		'bicto_auth_audiences',
		array(
			'student'    => array(
				'label'        => __( 'Students and graduates', 'pressbook-green' ),
				'access'       => 'public',
				'org_label'    => __( 'School or university', 'pressbook-green' ),
				'org_required' => false,
			),
			'government' => array(
				'label'        => __( 'Government employees and ministry personnel', 'pressbook-green' ),
				'access'       => 'government',
				'org_label'    => __( 'Ministry, office, or agency', 'pressbook-green' ),
				'org_required' => true,
			),
			'it'         => array(
				'label'        => __( 'IT professionals and technical support staff', 'pressbook-green' ),
				'access'       => 'public',
				'org_label'    => __( 'Organization', 'pressbook-green' ),
				'org_required' => false,
			),
			'educator'   => array(
				'label'        => __( 'Teachers, trainers, and educators', 'pressbook-green' ),
				'access'       => 'public',
				'org_label'    => __( 'School or institution', 'pressbook-green' ),
				'org_required' => false,
			),
			'jobseeker'  => array(
				'label'        => __( 'Job seekers and private-sector employees', 'pressbook-green' ),
				'access'       => 'public',
				'org_label'    => __( 'Company or organization (if any)', 'pressbook-green' ),
				'org_required' => false,
			),
			'public'     => array(
				'label'        => __( 'Interested members of the public', 'pressbook-green' ),
				'access'       => 'public',
				'org_label'    => '',
				'org_required' => false,
			),
		)
	);
}

/**
 * Training tracks a person can say they are interested in (slug => label).
 * Slugs match the category slugs used by the homepage track cards.
 *
 * @return array<string,string>
 */
function bicto_auth_tracks() {
	return apply_filters(
		'bicto_auth_tracks',
		array(
			'basic-digital-literacy'           => __( 'Basic Digital Literacy', 'pressbook-green' ),
			'web-development-wordpress'        => __( 'Web Development & WordPress', 'pressbook-green' ),
			'it-support-system-administration' => __( 'IT Support & System Administration', 'pressbook-green' ),
		)
	);
}

/**
 * Whether the public may create accounts. Honours Settings > General > Membership.
 */
function bicto_registration_open() {
	return (bool) apply_filters( 'bicto_registration_open', (bool) get_option( 'users_can_register' ) );
}

/* -------------------------------------------------------------------------
 * Assets
 * ---------------------------------------------------------------------- */

function bicto_auth_enqueue() {
	if ( is_user_logged_in() || ! apply_filters( 'bicto_load_auth_assets', is_front_page() || is_home() ) ) {
		return;
	}

	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();
	$ver = static function ( $file ) use ( $dir ) {
		return file_exists( $dir . $file ) ? (string) filemtime( $dir . $file ) : '1.0.0';
	};

	wp_enqueue_style( 'bicto-auth', $uri . '/assets/css/bicto-auth.css', array(), $ver( '/assets/css/bicto-auth.css' ) );
	wp_enqueue_script( 'bicto-auth', $uri . '/assets/js/bicto-auth.js', array(), $ver( '/assets/js/bicto-auth.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );

	wp_localize_script(
		'bicto-auth',
		'bictoAuth',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'nonce'        => wp_create_nonce( 'bicto_auth' ),
			'registerOpen' => bicto_registration_open(),
			'audiences'    => array_map(
				static function ( $a ) {
					return array(
						'orgLabel'    => $a['org_label'],
						'orgRequired' => (bool) $a['org_required'],
						'access'      => $a['access'],
					);
				},
				bicto_auth_audiences()
			),
			'i18n'         => array(
				'required'      => __( 'This field is required.', 'pressbook-green' ),
				'email'         => __( 'Enter a valid email address.', 'pressbook-green' ),
				'passwordShort' => __( 'Use at least 10 characters.', 'pressbook-green' ),
				'passwordMatch' => __( 'The passwords do not match.', 'pressbook-green' ),
				'consent'       => __( 'Please confirm this to continue.', 'pressbook-green' ),
				'network'       => __( 'We could not reach the server. Check your connection and try again.', 'pressbook-green' ),
				'fixErrors'     => __( 'Please correct the highlighted fields.', 'pressbook-green' ),
				'signingIn'     => __( 'Signing in…', 'pressbook-green' ),
				'signedIn'      => __( 'Signed in. Redirecting…', 'pressbook-green' ),
				'registering'   => __( 'Submitting…', 'pressbook-green' ),
				'show'          => __( 'Show password', 'pressbook-green' ),
				'hide'          => __( 'Hide password', 'pressbook-green' ),
				'strength'      => array(
					__( 'Too short', 'pressbook-green' ),
					__( 'Weak', 'pressbook-green' ),
					__( 'Fair', 'pressbook-green' ),
					__( 'Good', 'pressbook-green' ),
					__( 'Strong', 'pressbook-green' ),
				),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bicto_auth_enqueue' );

/* -------------------------------------------------------------------------
 * Request helpers
 * ---------------------------------------------------------------------- */

function bicto_auth_fail( $message, $status = 400, array $fields = array() ) {
	wp_send_json_error(
		array(
			'message' => $message,
			'fields'  => $fields,
		),
		$status
	);
}

function bicto_auth_verify_request() {
	if ( ! check_ajax_referer( 'bicto_auth', 'nonce', false ) ) {
		bicto_auth_fail( __( 'Your session has expired. Please refresh the page and try again.', 'pressbook-green' ), 403 );
	}
}

/**
 * REMOTE_ADDR only: forwarded headers are client-controlled. Behind a trusted proxy,
 * filter this to return the proxy-verified address.
 */
function bicto_auth_client_ip() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	return (string) apply_filters( 'bicto_auth_client_ip', $ip );
}

function bicto_auth_throttle_key( $bucket ) {
	return 'bicto_t_' . $bucket . '_' . md5( bicto_auth_client_ip() );
}

function bicto_auth_throttled( $bucket, $limit ) {
	return (int) get_transient( bicto_auth_throttle_key( $bucket ) ) >= $limit;
}

function bicto_auth_hit( $bucket, $window ) {
	$key = bicto_auth_throttle_key( $bucket );
	set_transient( $key, (int) get_transient( $key ) + 1, $window );
}

function bicto_auth_post( $key ) {
	return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- verified in bicto_auth_verify_request().
}

/* -------------------------------------------------------------------------
 * Sign in
 * ---------------------------------------------------------------------- */

function bicto_ajax_login() {
	bicto_auth_verify_request();

	$redirect = home_url( '/' );
	if ( ! empty( $_POST['redirect_to'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$redirect = wp_validate_redirect( esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ), $redirect ); // phpcs:ignore WordPress.Security.NonceVerification
	}
	$redirect = apply_filters( 'bicto_login_redirect', $redirect );

	if ( is_user_logged_in() ) {
		wp_send_json_success( array( 'redirect' => $redirect ) );
	}

	if ( bicto_auth_throttled( 'login', 8 ) ) {
		bicto_auth_fail( __( 'Too many sign-in attempts. Please wait 15 minutes and try again.', 'pressbook-green' ), 429 );
	}

	$login = bicto_auth_post( 'log' );
	// Passwords are never sanitized: that would silently alter them.
	$pass = isset( $_POST['pwd'] ) ? (string) wp_unslash( $_POST['pwd'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput

	$errors = array();
	if ( '' === $login ) {
		$errors['log'] = __( 'Enter your email address or username.', 'pressbook-green' );
	}
	if ( '' === $pass ) {
		$errors['pwd'] = __( 'Enter your password.', 'pressbook-green' );
	}
	if ( $errors ) {
		bicto_auth_fail( __( 'Please correct the highlighted fields.', 'pressbook-green' ), 422, $errors );
	}

	$user = wp_signon(
		array(
			'user_login'    => $login,
			'user_password' => $pass,
			'remember'      => ! empty( $_POST['rememberme'] ), // phpcs:ignore WordPress.Security.NonceVerification
		),
		is_ssl()
	);

	if ( is_wp_error( $user ) ) {
		bicto_auth_hit( 'login', 15 * MINUTE_IN_SECONDS );

		$generic = array( 'incorrect_password', 'invalid_username', 'invalid_email', 'empty_username', 'empty_password' );
		$message = in_array( $user->get_error_code(), $generic, true )
			? __( 'The email/username or password is incorrect.', 'pressbook-green' )
			: wp_strip_all_tags( $user->get_error_message() ); // Security plugins (lockouts, 2FA) explain themselves.

		bicto_auth_fail( $message, 401 );
	}

	delete_transient( bicto_auth_throttle_key( 'login' ) );
	wp_send_json_success( array( 'redirect' => $redirect ) );
}
add_action( 'wp_ajax_nopriv_bicto_login', 'bicto_ajax_login' );
add_action( 'wp_ajax_bicto_login', 'bicto_ajax_login' );

/* -------------------------------------------------------------------------
 * Registration
 * ---------------------------------------------------------------------- */

function bicto_auth_unique_username( $email ) {
	$base = sanitize_user( strstr( $email, '@', true ), true );
	$base = '' !== $base ? substr( $base, 0, 40 ) : 'learner';
	$name = $base;
	for ( $i = 0; $i < 6 && username_exists( $name ); $i++ ) {
		$name = $base . wp_rand( 100, 9999 );
	}
	return $name;
}

function bicto_ajax_register() {
	bicto_auth_verify_request();

	if ( is_user_logged_in() ) {
		bicto_auth_fail( __( 'You are already signed in.', 'pressbook-green' ), 400 );
	}
	if ( ! bicto_registration_open() ) {
		bicto_auth_fail( __( 'Registration is not open yet. Please check back soon.', 'pressbook-green' ), 403 );
	}
	// Honeypot: real visitors never see or fill this field.
	if ( '' !== bicto_auth_post( 'bicto_website' ) ) {
		bicto_auth_fail( __( 'We could not process this request.', 'pressbook-green' ), 400 );
	}
	if ( bicto_auth_throttled( 'register', 5 ) ) {
		bicto_auth_fail( __( 'Too many registration attempts. Please try again in an hour.', 'pressbook-green' ), 429 );
	}

	$audiences = bicto_auth_audiences();
	$tracks    = bicto_auth_tracks();

	$first    = bicto_auth_post( 'first_name' );
	$last     = bicto_auth_post( 'last_name' );
	$email    = sanitize_email( bicto_auth_post( 'email' ) );
	$phone    = preg_replace( '/[^0-9+\-\s()]/', '', bicto_auth_post( 'phone' ) );
	$audience = bicto_auth_post( 'audience' );
	$org      = bicto_auth_post( 'organization' );
	$pass     = isset( $_POST['pwd'] ) ? (string) wp_unslash( $_POST['pwd'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput
	$pass2    = isset( $_POST['pwd2'] ) ? (string) wp_unslash( $_POST['pwd2'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput

	$picked = isset( $_POST['tracks'] ) ? (array) wp_unslash( $_POST['tracks'] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput
	$picked = array_values( array_intersect( array_map( 'sanitize_key', $picked ), array_keys( $tracks ) ) );

	$e = array();
	if ( '' === $first || mb_strlen( $first ) > 60 ) {
		$e['first_name'] = __( 'Enter your first name.', 'pressbook-green' );
	}
	if ( '' === $last || mb_strlen( $last ) > 60 ) {
		$e['last_name'] = __( 'Enter your last name.', 'pressbook-green' );
	}
	if ( ! is_email( $email ) ) {
		$e['email'] = __( 'Enter a valid email address.', 'pressbook-green' );
	} elseif ( email_exists( $email ) ) {
		$e['email'] = __( 'An account with this email may already exist. Try signing in or resetting your password.', 'pressbook-green' );
	}
	if ( strlen( $phone ) > 20 ) {
		$e['phone'] = __( 'Enter a shorter phone number.', 'pressbook-green' );
	}
	if ( ! isset( $audiences[ $audience ] ) ) {
		$e['audience'] = __( 'Choose the option that describes you best.', 'pressbook-green' );
	} elseif ( $audiences[ $audience ]['org_required'] && '' === $org ) {
		$e['organization'] = __( 'This field is required for your account type.', 'pressbook-green' );
	}
	if ( mb_strlen( $org ) > 120 ) {
		$e['organization'] = __( 'Please shorten this entry.', 'pressbook-green' );
	}
	if ( strlen( $pass ) < 10 ) {
		$e['pwd'] = __( 'Use at least 10 characters.', 'pressbook-green' );
	} elseif ( 0 === strcasecmp( $pass, $email ) ) {
		$e['pwd'] = __( 'Your password cannot be your email address.', 'pressbook-green' );
	}
	if ( ! isset( $e['pwd'] ) && $pass !== $pass2 ) {
		$e['pwd2'] = __( 'The passwords do not match.', 'pressbook-green' );
	}
	if ( empty( $_POST['privacy'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$e['privacy'] = __( 'Please confirm this to continue.', 'pressbook-green' );
	}

	if ( $e ) {
		bicto_auth_fail( __( 'Please correct the highlighted fields.', 'pressbook-green' ), 422, $e );
	}

	bicto_auth_hit( 'register', HOUR_IN_SECONDS );

	$user_id = wp_insert_user(
		array(
			'user_login'   => bicto_auth_unique_username( $email ),
			'user_email'   => $email,
			'user_pass'    => $pass,
			'first_name'   => $first,
			'last_name'    => $last,
			'display_name' => trim( $first . ' ' . $last ),
			'role'         => get_option( 'default_role', 'subscriber' ),
		)
	);

	if ( is_wp_error( $user_id ) ) {
		bicto_auth_fail( __( 'We could not create your account. Please try again or contact the portal administrator.', 'pressbook-green' ), 500 );
	}

	$access    = $audiences[ $audience ]['access'];
	$status    = 'public' === $access ? 'active' : 'pending';
	$reference = sprintf( 'BICTO-%s-%05d', wp_date( 'Y' ), $user_id );

	update_user_meta( $user_id, 'bicto_audience', $audience );
	update_user_meta( $user_id, 'bicto_organization', $org );
	update_user_meta( $user_id, 'bicto_phone', $phone );
	update_user_meta( $user_id, 'bicto_tracks', $picked );
	update_user_meta( $user_id, 'bicto_access_requested', $access );
	update_user_meta( $user_id, 'bicto_access_status', $status );
	update_user_meta( $user_id, 'bicto_reference', $reference );
	// Record consent for the Data Privacy Act paper trail.
	update_user_meta( $user_id, 'bicto_privacy_consent', wp_date( 'c' ) );

	// Notify the site admin only; the learner gets our own message below.
	wp_new_user_notification( $user_id, null, 'admin' );
	bicto_auth_send_welcome( $email, $first, $reference, $status );

	$steps = array(
		/* translators: %s: email address */
		sprintf( __( 'A confirmation message has been sent to %s.', 'pressbook-green' ), $email ),
		__( 'You can sign in right away with your email address and password.', 'pressbook-green' ),
	);
	if ( 'pending' === $status ) {
		$steps[] = __( 'Your government affiliation will be verified by BICTO. Trainings that are restricted to government personnel open once this is done.', 'pressbook-green' );
	} else {
		$steps[] = __( 'Browse the training tracks and calendar, and register for the sessions that fit you.', 'pressbook-green' );
	}

	do_action( 'bicto_user_registered', $user_id, $audience, $status );

	wp_send_json_success(
		array(
			'reference'     => $reference,
			'firstName'     => $first,
			'name'          => trim( $first . ' ' . $last ),
			'email'         => $email,
			'audience'      => $audiences[ $audience ]['label'],
			'tracks'        => array_values( array_map( static function ( $slug ) use ( $tracks ) { return $tracks[ $slug ]; }, $picked ) ),
			'status'        => $status,
			'statusLabel'   => 'pending' === $status ? __( 'Active, verification pending', 'pressbook-green' ) : __( 'Active', 'pressbook-green' ),
			'nextSteps'     => $steps,
		)
	);
}
add_action( 'wp_ajax_nopriv_bicto_register', 'bicto_ajax_register' );
add_action( 'wp_ajax_bicto_register', 'bicto_ajax_register' );

function bicto_auth_send_welcome( $email, $first, $reference, $status ) {
	$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

	/* translators: %s: site name */
	$subject = sprintf( __( '[%s] Your registration is confirmed', 'pressbook-green' ), $site );

	$lines   = array();
	/* translators: %s: first name */
	$lines[] = sprintf( __( 'Hello %s,', 'pressbook-green' ), $first );
	$lines[] = '';
	/* translators: %s: site name */
	$lines[] = sprintf( __( 'Thank you for registering with %s.', 'pressbook-green' ), $site );
	/* translators: %s: reference number */
	$lines[] = sprintf( __( 'Your registration reference: %s', 'pressbook-green' ), $reference );
	$lines[] = '';
	if ( 'pending' === $status ) {
		$lines[] = __( 'Your government affiliation will be verified by BICTO. You can sign in now; trainings restricted to government personnel open once verification is complete.', 'pressbook-green' );
	} else {
		$lines[] = __( 'Your account is active. You can sign in now.', 'pressbook-green' );
	}
	$lines[] = home_url( '/' );

	wp_mail( $email, $subject, implode( "\n", $lines ) );
}

/* -------------------------------------------------------------------------
 * Admin: see and verify who registered
 * ---------------------------------------------------------------------- */

function bicto_auth_user_columns( $cols ) {
	$cols['bicto_audience'] = __( 'Registered as', 'pressbook-green' );
	$cols['bicto_access']   = __( 'Portal access', 'pressbook-green' );
	return $cols;
}
add_filter( 'manage_users_columns', 'bicto_auth_user_columns' );

function bicto_auth_user_column_value( $value, $column, $user_id ) {
	if ( 'bicto_audience' === $column ) {
		$key = get_user_meta( $user_id, 'bicto_audience', true );
		$all = bicto_auth_audiences();
		return isset( $all[ $key ] ) ? esc_html( $all[ $key ]['label'] ) : '&mdash;';
	}
	if ( 'bicto_access' === $column ) {
		$status = get_user_meta( $user_id, 'bicto_access_status', true );
		return $status ? esc_html( ucfirst( $status ) ) : '&mdash;';
	}
	return $value;
}
add_filter( 'manage_users_custom_column', 'bicto_auth_user_column_value', 10, 3 );

function bicto_auth_profile_fields( $user ) {
	if ( ! current_user_can( 'edit_users' ) ) {
		return;
	}
	$status = get_user_meta( $user->ID, 'bicto_access_status', true );
	if ( ! $status ) {
		return;
	}
	$requested = get_user_meta( $user->ID, 'bicto_access_requested', true );
	?>
	<h2><?php esc_html_e( 'Bicto portal registration', 'pressbook-green' ); ?></h2>
	<table class="form-table" role="presentation">
		<tr>
			<th><?php esc_html_e( 'Reference', 'pressbook-green' ); ?></th>
			<td><?php echo esc_html( get_user_meta( $user->ID, 'bicto_reference', true ) ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Organization', 'pressbook-green' ); ?></th>
			<td><?php echo esc_html( get_user_meta( $user->ID, 'bicto_organization', true ) ); ?></td>
		</tr>
		<tr>
			<th><label for="bicto_access_status"><?php esc_html_e( 'Access status', 'pressbook-green' ); ?></label></th>
			<td>
				<?php wp_nonce_field( 'bicto_access_status_' . $user->ID, 'bicto_access_nonce' ); ?>
				<select name="bicto_access_status" id="bicto_access_status">
					<?php foreach ( array( 'active' => __( 'Active', 'pressbook-green' ), 'pending' => __( 'Pending verification', 'pressbook-green' ), 'verified' => __( 'Verified', 'pressbook-green' ), 'rejected' => __( 'Rejected', 'pressbook-green' ) ) as $val => $label ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status, $val ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
				<p class="description">
					<?php
					/* translators: %s: requested access level */
					printf( esc_html__( 'Requested access level: %s', 'pressbook-green' ), esc_html( $requested ) );
					?>
				</p>
			</td>
		</tr>
	</table>
	<?php
}
add_action( 'show_user_profile', 'bicto_auth_profile_fields' );
add_action( 'edit_user_profile', 'bicto_auth_profile_fields' );

function bicto_auth_save_profile_fields( $user_id ) {
	if (
		! current_user_can( 'edit_users' )
		|| ! isset( $_POST['bicto_access_nonce'], $_POST['bicto_access_status'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bicto_access_nonce'] ) ), 'bicto_access_status_' . $user_id )
	) {
		return;
	}
	$status = sanitize_key( wp_unslash( $_POST['bicto_access_status'] ) );
	if ( in_array( $status, array( 'active', 'pending', 'verified', 'rejected' ), true ) ) {
		update_user_meta( $user_id, 'bicto_access_status', $status );
	}
}
add_action( 'personal_options_update', 'bicto_auth_save_profile_fields' );
add_action( 'edit_user_profile_update', 'bicto_auth_save_profile_fields' );
