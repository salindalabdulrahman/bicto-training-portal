<?php
/**
 * Homepage layout for the Bicto Digital Training Portal.
 *
 * @package PressBook_Green
 */

defined( 'ABSPATH' ) || die();

$login_url    = bicto_login_url();
$register_url = bicto_register_url();
$courses_url  = bicto_courses_url();
$home         = home_url( '/' );
$privacy_url  = get_privacy_policy_url();
$email        = get_theme_mod( 'bicto_contact_email', '' );
$phone        = get_theme_mod( 'bicto_contact_phone', '' );
$address      = get_theme_mod( 'bicto_contact_address', '' );
$facebook     = get_theme_mod( 'bicto_social_facebook', '' );
$levels       = bicto_access_levels();

/**
 * Create an Account button. Falls back to a clearly labelled, non-clickable
 * state when registration has not been enabled yet.
 *
 * @param string $url   Registration URL (may be empty).
 * @param string $class Button classes.
 */
$bicto_register_button = static function ( $url, $class ) {
	if ( $url ) {
		printf( '<a class="%1$s" href="%2$s">%3$s</a>', esc_attr( $class ), esc_url( $url ), esc_html__( 'Create an Account', 'pressbook-green' ) );
		return;
	}
	printf(
		'<span class="%1$s is-disabled" role="link" aria-disabled="true">%2$s <small>%3$s</small></span>',
		esc_attr( $class ),
		esc_html__( 'Create an Account', 'pressbook-green' ),
		esc_html__( '(registration not yet open)', 'pressbook-green' )
	);
};

$icons = array(
	'literacy' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/></svg>',
	'web'      => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.2 3 14.8 0 18M12 3c-3 3.2-3 14.8 0 18"/></svg>',
	'support'  => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/></svg>',
	'skills'   => '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 9l9-5 9 5-9 5z"/><path d="M7 11.5V16c2.5 2 7.5 2 10 0v-4.5"/></svg>',
	'gov'      => '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 10l9-6 9 6M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20h18"/></svg>',
	'access'   => '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6M15.5 14.2c2.8-.4 5.5 1.5 5.5 4.8"/></svg>',
);

$tracks = array(
	array(
		'slug'  => 'basic-digital-literacy',
		'icon'  => 'literacy',
		'title' => __( 'Basic Digital Literacy', 'pressbook-green' ),
		'desc'  => __( 'Develop essential digital skills, office productivity capabilities, professional email practices, cybersecurity awareness, and safe internet usage.', 'pressbook-green' ),
		'topics' => array(
			__( 'Computer fundamentals', 'pressbook-green' ),
			__( 'Word processing and spreadsheets', 'pressbook-green' ),
			__( 'Email and digital communication', 'pressbook-green' ),
			__( 'Online safety and data protection', 'pressbook-green' ),
		),
	),
	array(
		'slug'  => 'web-development-wordpress',
		'icon'  => 'web',
		'title' => __( 'Web Development & WordPress', 'pressbook-green' ),
		'desc'  => __( 'Learn how to build, maintain, and manage websites using WordPress and BGOVCMS, where applicable.', 'pressbook-green' ),
		'topics' => array(
			__( 'WordPress fundamentals', 'pressbook-green' ),
			__( 'Content management', 'pressbook-green' ),
			__( 'Website maintenance', 'pressbook-green' ),
			__( 'Basic web development', 'pressbook-green' ),
		),
	),
	array(
		'slug'  => 'it-support-system-administration',
		'icon'  => 'support',
		'title' => __( 'IT Support & System Administration', 'pressbook-green' ),
		'desc'  => __( 'Build practical skills in computer troubleshooting, network configuration, technical support, system maintenance, and approved BGOV support procedures.', 'pressbook-green' ),
		'topics' => array(
			__( 'Windows troubleshooting', 'pressbook-green' ),
			__( 'Computer and peripheral support', 'pressbook-green' ),
			__( 'Basic network configuration', 'pressbook-green' ),
			__( 'Software maintenance and security basics', 'pressbook-green' ),
		),
	),
);

$objectives = array(
	array( 'skills', __( 'Build Digital Competence', 'pressbook-green' ), __( 'Help individuals develop the practical ICT skills needed for everyday digital work, education, professional development, and personal growth.', 'pressbook-green' ) ),
	array( 'gov', __( 'Strengthen Government ICT Capabilities', 'pressbook-green' ), __( 'Support responsible technology adoption, website management, and digital service delivery across participating offices.', 'pressbook-green' ) ),
	array( 'access', __( 'Expand Access to Learning', 'pressbook-green' ), __( 'Promote accessible learning opportunities that support digital inclusion across ministries, offices, and communities.', 'pressbook-green' ) ),
);

$events        = bicto_get_upcoming_events( 6 );
$announcements = bicto_get_announcements( 3 );
?>
<div class="bicto-topbar">
	<div class="bicto-topbar-inner">
		<ul class="bicto-topbar-links">
			<li><a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></a></li>
			<li><?php $bicto_register_button( $register_url, 'bicto-top-link' ); ?></li>
			<?php if ( $privacy_url ) : ?>
				<li><a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'pressbook-green' ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>

<header class="bicto-header" id="bicto-header">
	<a class="bicto-brand" href="<?php echo esc_url( $home ); ?>" aria-label="<?php esc_attr_e( 'Bicto Digital Training Portal, home', 'pressbook-green' ); ?>">
		<?php if ( has_custom_logo() ) : ?>
			<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'bicto-logo', 'alt' => '' ) ); ?>
		<?php else : ?>
			<span class="bicto-brand-mark" aria-hidden="true">BI</span>
		<?php endif; ?>
		<span class="bicto-brand-title">Bicto Digital Training Portal</span>
		<span class="bicto-brand-tagline">Creating Digitally Empowered Bangsamoro</span>
	</a>
</header>

<nav class="bicto-navbar" aria-label="<?php esc_attr_e( 'Primary navigation', 'pressbook-green' ); ?>">
	<div class="bicto-navbar-inner">
		<button class="bicto-nav-toggle" type="button" aria-expanded="false" aria-controls="bicto-nav">
			<span class="bicto-burger" aria-hidden="true"></span>
			<span class="bicto-nav-toggle-label"><?php esc_html_e( 'Menu', 'pressbook-green' ); ?></span>
		</button>
		<div class="bicto-nav" id="bicto-nav">
			<ul class="bicto-nav-links">
				<li><a href="#top" data-spy="top" aria-current="page"><?php esc_html_e( 'Home', 'pressbook-green' ); ?></a></li>
				<li><a href="#training-courses" data-spy="training-courses"><?php esc_html_e( 'Training Courses', 'pressbook-green' ); ?></a></li>
				<li><a href="#training-calendar" data-spy="training-calendar"><?php esc_html_e( 'Training Calendar', 'pressbook-green' ); ?></a></li>
				<li><a href="#announcements" data-spy="announcements"><?php esc_html_e( 'Announcements', 'pressbook-green' ); ?></a></li>
				<li><a href="#about" data-spy="about"><?php esc_html_e( 'About', 'pressbook-green' ); ?></a></li>
			</ul>
		</div>
	</div>
</nav>

<main class="bicto-home-page" id="bicto-main">

	<section class="bicto-hero" id="top" aria-labelledby="bicto-hero-title">
		<div class="section-shell bicto-hero-inner">
			<div class="bicto-hero-copy">
				<p class="bicto-kicker"><?php esc_html_e( 'Bangsamoro Information and Communications Technology Office', 'pressbook-green' ); ?></p>
				<h1 id="bicto-hero-title">Bicto Digital Training Portal</h1>
				<p class="bicto-tagline">Creating Digitally Empowered Bangsamoro</p>
				<p class="bicto-lede">Official ICT Literacy &amp; E-Governance Training Platform under the Bangsamoro Information and Communications Technology Office (BICTO).</p>

				<div class="bicto-actions">
					<a class="bicto-btn bicto-btn-primary" href="<?php echo esc_url( $courses_url ); ?>"><?php esc_html_e( 'Explore Training Courses', 'pressbook-green' ); ?></a>
					<?php $bicto_register_button( $register_url, 'bicto-btn bicto-btn-secondary' ); ?>
				</div>
				<p class="bicto-signin-line">
					<?php esc_html_e( 'Already have an account?', 'pressbook-green' ); ?>
					<a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></a>
				</p>
			</div>

			<aside class="bicto-hero-panel" aria-label="<?php esc_attr_e( 'Who the portal is for', 'pressbook-green' ); ?>">
				<h2><?php esc_html_e( 'Learning for everyone', 'pressbook-green' ); ?></h2>
				<ul>
					<li><?php esc_html_e( 'Students and graduates', 'pressbook-green' ); ?></li>
					<li><?php esc_html_e( 'Government employees and ministry personnel', 'pressbook-green' ); ?></li>
					<li><?php esc_html_e( 'IT professionals and technical support staff', 'pressbook-green' ); ?></li>
					<li><?php esc_html_e( 'Teachers, trainers, and educators', 'pressbook-green' ); ?></li>
					<li><?php esc_html_e( 'Job seekers and private-sector employees', 'pressbook-green' ); ?></li>
					<li><?php esc_html_e( 'Interested members of the public', 'pressbook-green' ); ?></li>
				</ul>
				<p><?php esc_html_e( 'Some training programs may set their own eligibility requirements, which are shown with each program.', 'pressbook-green' ); ?></p>
			</aside>
		</div>
	</section>

	<section class="bicto-section" id="training-courses" aria-labelledby="bicto-tracks-title">
		<div class="section-shell">
			<div class="bicto-section-header">
				<p class="eyebrow"><?php esc_html_e( 'Training tracks', 'pressbook-green' ); ?></p>
				<h2 id="bicto-tracks-title"><?php esc_html_e( 'Key Training Tracks', 'pressbook-green' ); ?></h2>
				<p><?php esc_html_e( 'Browse the main learning areas below. No account is needed to read about a track.', 'pressbook-green' ); ?></p>
			</div>

			<div class="bicto-track-grid">
				<?php
				foreach ( $tracks as $track ) :
					$term       = get_category_by_slug( $track['slug'] );
					$track_link = $term ? get_category_link( $term ) : '#training-calendar';
					?>
					<article class="bicto-track">
						<div class="bicto-track-icon"><?php echo $icons[ $track['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput -- static trusted SVG. ?></div>
						<h3><?php echo esc_html( $track['title'] ); ?></h3>
						<p><?php echo esc_html( $track['desc'] ); ?></p>
						<ul>
							<?php foreach ( $track['topics'] as $topic ) : ?>
								<li><?php echo esc_html( $topic ); ?></li>
							<?php endforeach; ?>
						</ul>
						<a class="bicto-link" href="<?php echo esc_url( $track_link ); ?>">
							<?php esc_html_e( 'Explore Track', 'pressbook-green' ); ?>
							<span class="screen-reader-text"> <?php echo esc_html( $track['title'] ); ?></span>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bicto-section bicto-section-alt" id="about" aria-labelledby="bicto-about-title">
		<div class="section-shell">
			<div class="bicto-section-header bicto-left">
				<p class="eyebrow"><?php esc_html_e( 'About the portal', 'pressbook-green' ); ?></p>
				<h2 id="bicto-about-title"><?php esc_html_e( 'Empowering BARMM Through Digital Skills', 'pressbook-green' ); ?></h2>
				<p><?php esc_html_e( 'The Bicto Digital Training Portal supports digital capacity development by providing accessible ICT learning opportunities for ministries, government offices, personnel, learners, professionals, and communities across BARMM. Through practical training and technology-focused learning, the portal aims to strengthen digital literacy, improve government technology adoption, and support more effective digital public services.', 'pressbook-green' ); ?></p>
			</div>
			<div class="bicto-objectives">
				<?php foreach ( $objectives as $objective ) : ?>
					<article class="bicto-objective">
						<div class="bicto-objective-icon"><?php echo $icons[ $objective[0] ]; // phpcs:ignore WordPress.Security.EscapeOutput -- static trusted SVG. ?></div>
						<h3><?php echo esc_html( $objective[1] ); ?></h3>
						<p><?php echo esc_html( $objective[2] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bicto-section" id="training-calendar" aria-labelledby="bicto-calendar-title">
		<div class="section-shell">
			<div class="bicto-section-header">
				<p class="eyebrow"><?php esc_html_e( 'Calendar and updates', 'pressbook-green' ); ?></p>
				<h2 id="bicto-calendar-title"><?php esc_html_e( 'Upcoming Training & Announcements', 'pressbook-green' ); ?></h2>
				<p><?php esc_html_e( 'Each training lists who may take part. Please check the eligibility shown before registering.', 'pressbook-green' ); ?></p>
			</div>

			<div class="bicto-two-col">
				<div class="bicto-col">
					<h3 class="bicto-col-title"><span class="bicto-dot bicto-dot-green" aria-hidden="true"></span><?php esc_html_e( 'Training Events', 'pressbook-green' ); ?></h3>

					<?php if ( $events->have_posts() ) : ?>
						<ul class="bicto-card-list">
							<?php
							while ( $events->have_posts() ) :
								$events->the_post();
								$pid      = get_the_ID();
								$start    = get_post_meta( $pid, '_bicto_event_start', true );
								$dt       = $start ? date_create_immutable( $start, wp_timezone() ) : false;
								$type     = get_post_meta( $pid, '_bicto_event_type', true );
								$venue    = get_post_meta( $pid, '_bicto_event_venue', true );
								$audience = get_post_meta( $pid, '_bicto_event_audience', true );
								$access   = get_post_meta( $pid, '_bicto_event_access', true );
								$access   = isset( $levels[ $access ] ) ? $access : 'public';
								$reg_link = get_post_meta( $pid, '_bicto_event_link', true );
								?>
								<li class="bicto-card bicto-event">
									<div class="bicto-card-tags">
										<?php if ( $type ) : ?>
											<span class="bicto-tag"><?php echo esc_html( $type ); ?></span>
										<?php endif; ?>
										<span class="bicto-tag bicto-tag-access bicto-access-<?php echo esc_attr( $access ); ?>"><?php echo esc_html( $levels[ $access ] ); ?></span>
									</div>
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<dl class="bicto-meta">
										<?php if ( $dt ) : ?>
											<div><dt><?php esc_html_e( 'When', 'pressbook-green' ); ?></dt><dd><?php echo esc_html( wp_date( get_option( 'date_format' ) . ' · ' . get_option( 'time_format' ), $dt->getTimestamp() ) ); ?></dd></div>
										<?php endif; ?>
										<?php if ( $venue ) : ?>
											<div><dt><?php esc_html_e( 'Where', 'pressbook-green' ); ?></dt><dd><?php echo esc_html( $venue ); ?></dd></div>
										<?php endif; ?>
										<?php if ( $audience ) : ?>
											<div><dt><?php esc_html_e( 'Audience', 'pressbook-green' ); ?></dt><dd><?php echo esc_html( $audience ); ?></dd></div>
										<?php endif; ?>
									</dl>
									<?php if ( has_excerpt() || get_the_content() ) : ?>
										<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
									<?php endif; ?>
									<p class="bicto-card-links">
										<a class="bicto-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details', 'pressbook-green' ); ?><span class="screen-reader-text"> <?php the_title(); ?></span></a>
										<?php if ( $reg_link ) : ?>
											<a class="bicto-link" href="<?php echo esc_url( $reg_link ); ?>" rel="noopener"><?php esc_html_e( 'Register', 'pressbook-green' ); ?><span class="screen-reader-text"> <?php the_title(); ?></span></a>
										<?php endif; ?>
									</p>
								</li>
							<?php endwhile; ?>
						</ul>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<div class="bicto-empty">
							<p><?php esc_html_e( 'No upcoming training sessions have been published yet. Please check back for future announcements.', 'pressbook-green' ); ?></p>
						</div>
					<?php endif; ?>
				</div>

				<div class="bicto-col" id="announcements">
					<h3 class="bicto-col-title"><span class="bicto-dot bicto-dot-gold" aria-hidden="true"></span><?php esc_html_e( 'Announcements', 'pressbook-green' ); ?></h3>

					<?php if ( $announcements->have_posts() ) : ?>
						<ul class="bicto-card-list">
							<?php
							while ( $announcements->have_posts() ) :
								$announcements->the_post();
								?>
								<li class="bicto-card bicto-announcement">
									<time class="bicto-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
									<a class="bicto-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read Announcement', 'pressbook-green' ); ?><span class="screen-reader-text"> <?php the_title(); ?></span></a>
								</li>
							<?php endwhile; ?>
						</ul>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<div class="bicto-empty">
							<p><?php esc_html_e( 'No announcements have been published yet. Please check back soon.', 'pressbook-green' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="bicto-cta" aria-labelledby="bicto-cta-title">
		<div class="bicto-cta-inner">
			<h2 id="bicto-cta-title"><?php esc_html_e( 'Ready to Strengthen Your Digital Skills?', 'pressbook-green' ); ?></h2>
			<p><?php esc_html_e( 'Explore available training opportunities and discover practical ways to build your ICT capabilities, whether you are a student, professional, government employee, or an interested member of the public.', 'pressbook-green' ); ?></p>
			<div class="bicto-actions bicto-actions-center">
				<a class="bicto-btn bicto-btn-primary" href="<?php echo esc_url( $courses_url ); ?>"><?php esc_html_e( 'Explore Training Courses', 'pressbook-green' ); ?></a>
				<?php $bicto_register_button( $register_url, 'bicto-btn bicto-btn-secondary' ); ?>
				<a class="bicto-btn bicto-btn-ghost" href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></a>
			</div>
		</div>
	</section>
</main>

<footer class="bicto-footer" aria-label="<?php esc_attr_e( 'Site footer', 'pressbook-green' ); ?>">
	<div class="bicto-footer-grid">
		<div class="bicto-footer-brand">
			<h2>Bicto Digital Training Portal</h2>
			<p>Creating Digitally Empowered Bangsamoro.</p>
			<p>Bangsamoro Information and Communications Technology Office (BICTO).</p>
		</div>

		<nav class="bicto-footer-column" aria-label="<?php esc_attr_e( 'Footer quick links', 'pressbook-green' ); ?>">
			<h3><?php esc_html_e( 'Quick Links', 'pressbook-green' ); ?></h3>
			<a href="#top"><?php esc_html_e( 'Home', 'pressbook-green' ); ?></a>
			<a href="<?php echo esc_url( $courses_url ); ?>"><?php esc_html_e( 'Training Courses', 'pressbook-green' ); ?></a>
			<a href="#training-calendar"><?php esc_html_e( 'Training Calendar', 'pressbook-green' ); ?></a>
			<a href="#announcements"><?php esc_html_e( 'Announcements', 'pressbook-green' ); ?></a>
			<a href="#about"><?php esc_html_e( 'About', 'pressbook-green' ); ?></a>
		</nav>

		<div class="bicto-footer-column">
			<h3><?php esc_html_e( 'Portal Access', 'pressbook-green' ); ?></h3>
			<?php if ( $register_url ) : ?>
				<a href="<?php echo esc_url( $register_url ); ?>"><?php esc_html_e( 'Create an Account', 'pressbook-green' ); ?></a>
			<?php else : ?>
				<span class="bicto-footer-muted"><?php esc_html_e( 'Create an Account (registration not yet open)', 'pressbook-green' ); ?></span>
			<?php endif; ?>
			<a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></a>
			<?php if ( $privacy_url ) : ?>
				<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'pressbook-green' ); ?></a>
			<?php endif; ?>
		</div>

		<div class="bicto-footer-column">
			<h3><?php esc_html_e( 'Contact', 'pressbook-green' ); ?></h3>
			<?php if ( $email || $phone || $address || $facebook ) : ?>
				<?php if ( $address ) : ?><p><?php echo nl2br( esc_html( $address ) ); ?></p><?php endif; ?>
				<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a><?php endif; ?>
				<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
				<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" rel="noopener"><?php esc_html_e( 'Facebook', 'pressbook-green' ); ?></a><?php endif; ?>
			<?php else : ?>
				<span class="bicto-footer-muted"><?php esc_html_e( 'Official contact details will be published here.', 'pressbook-green' ); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<div class="bicto-footer-bottom">
		&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Bicto Digital Training Portal. All rights reserved.
	</div>
</footer>
