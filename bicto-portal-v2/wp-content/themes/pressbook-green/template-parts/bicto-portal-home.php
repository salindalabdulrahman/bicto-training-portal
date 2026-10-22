<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'home' ); ?>>
<?php wp_body_open(); ?>

<div class="bicto-topbar">
	<div class="bicto-topbar-inner">
		<ul class="bicto-topbar-links">
			<?php if ( function_exists( 'bicto_registration_open' ) && bicto_registration_open() && ! is_user_logged_in() ) : ?>
				<li><a class="bicto-top-link bicto-top-cta" href="<?php echo esc_url( wp_registration_url() ); ?>" data-bicto-modal="register"><?php esc_html_e( 'Create an Account', 'pressbook-green' ); ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'pressbook-green' ); ?></a></li>
		</ul>
	</div>
</div>

<header class="bicto-header">
	<a class="bicto-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="bicto-brand-mark" aria-hidden="true">BI</span>
		<span class="bicto-brand-title"><?php bloginfo( 'name' ); ?></span>
		<span class="bicto-brand-tagline"><?php bloginfo( 'description' ); ?></span>
	</a>
</header>

<nav class="bicto-navbar">
	<div class="bicto-navbar-inner">
		<div class="bicto-nav">
			<ul class="bicto-nav-links">
				<li><a href="#top" aria-current="page"><?php esc_html_e( 'Home', 'pressbook-green' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/courses/' ) ); ?>"><?php esc_html_e( 'Training Courses', 'pressbook-green' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/calendar/' ) ); ?>"><?php esc_html_e( 'Training Calendar', 'pressbook-green' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/announcements/' ) ); ?>"><?php esc_html_e( 'Announcements', 'pressbook-green' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'pressbook-green' ); ?></a></li>
			</ul>
		</div>
	</div>
</nav>

<main class="bicto-home-page">
	<section class="bicto-hero" id="top">
		<div class="section-shell bicto-hero-inner">
			<div class="bicto-hero-copy">
				<p class="bicto-kicker"><?php esc_html_e( 'Bangsamoro Information and Communications Technology Office', 'pressbook-green' ); ?></p>
				<h1><?php esc_html_e( 'Bicto Digital Training Portal', 'pressbook-green' ); ?></h1>
				<p class="bicto-tagline"><?php esc_html_e( 'Creating Digitally Empowered Bangsamoro', 'pressbook-green' ); ?></p>
				<p class="bicto-lede"><?php esc_html_e( 'Official ICT Literacy & E-Governance Training Platform under the Bangsamoro Information and Communications Technology Office (BICTO).', 'pressbook-green' ); ?></p>
				
				<div class="bicto-actions">
					<a class="bicto-btn bicto-btn-primary" href="<?php echo esc_url( home_url( '/courses/' ) ); ?>"><?php esc_html_e( 'Explore Training Courses', 'pressbook-green' ); ?></a>
					<?php if ( function_exists( 'bicto_registration_open' ) && bicto_registration_open() && ! is_user_logged_in() ) : ?>
						<a class="bicto-btn bicto-btn-secondary" href="<?php echo esc_url( wp_registration_url() ); ?>" data-bicto-modal="register"><?php esc_html_e( 'Create an Account', 'pressbook-green' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="bicto-hero-side">
				<figure class="bicto-hero-image">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/sample-hero-learning.svg" width="640" height="400" alt="">
				</figure>
				<aside class="bicto-hero-panel">
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
		</div>
	</section>
</main>

<?php
// Load authentication/registration modals template if available
if ( file_exists( get_stylesheet_directory() . '/inc/bicto-auth-modal.php' ) ) {
    include get_stylesheet_directory() . '/inc/bicto-auth-modal.php';
}

wp_footer(); 
?>
</body>
</html>