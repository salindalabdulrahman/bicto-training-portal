<?php
/**
 * Homepage layout for the Bicto Digital Training Portal.
 *
 * @package PressBook_Green
 */

$login_url = wp_login_url();
?>
<main class="bicto-home-page" id="primary">
	<header class="bicto-header" aria-label="Main navigation">
		<div class="bicto-header-inner">
			<div class="bicto-brand" aria-label="Bicto Digital Training Portal">
				<span class="bicto-brand-mark">BI</span>
				<div class="bicto-brand-copy">
					<strong>Bicto Digital Training Portal</strong>
					<span>Creating Digitally Empowered Bangsamoro</span>
				</div>
			</div>

			<nav class="bicto-nav" aria-label="Primary navigation">
				<a href="#top">Home</a>
				<a href="#training-courses">Training Courses</a>
				<a href="#training-calendar">Training Calendar</a>
				<a href="#announcements">Announcements</a>
				<a href="#about">About</a>
				<a class="bicto-nav-login" href="<?php echo esc_url( $login_url ); ?>">Student Portal Login</a>
			</nav>
		</div>
	</header>

	<section class="bicto-hero" id="top">
		<div class="bicto-hero-copy">
			<p class="bicto-kicker">Bangsamoro Information and Communications Technology Office</p>
			<h1>Bicto Digital Training Portal</h1>
			<p class="bicto-tagline">Creating Digitally Empowered Bangsamoro</p>
			<p class="bicto-lede">Official ICT Literacy &amp; E-Governance Training Platform under the Bangsamoro Information and Communications Technology Office (BICTO).</p>

			<div class="bicto-actions">
				<a class="bicto-btn bicto-btn-primary" href="#training-courses">Explore Training Courses</a>
				<a class="bicto-btn bicto-btn-secondary" href="<?php echo esc_url( $login_url ); ?>">Student Portal Login</a>
			</div>

			<ul class="bicto-highlights" aria-label="Portal highlights">
				<li>Digital literacy</li>
				<li>ICT governance</li>
				<li>Practical learning</li>
			</ul>
		</div>

		<div class="bicto-hero-visual" aria-label="Digital learning environment and ICT training activities">
			<div class="bicto-visual-pill">Learning for public service</div>
			<div class="bicto-visual-card">
				<span class="label">Portal focus</span>
				<strong>ICT Skills for Government &amp; Communities</strong>
				<p>Training, digital adoption, and public-sector readiness for a connected Bangsamoro.</p>
			</div>
		</div>
	</section>

	<section class="bicto-section" id="training-courses">
		<div class="section-shell">
			<div class="bicto-section-header">
				<p class="eyebrow">Training tracks</p>
				<h2>Key Learning Tracks</h2>
				<p>Practical, role-based learning opportunities that strengthen digital confidence and public service readiness.</p>
			</div>

			<div class="bicto-track-grid">
				<article class="bicto-track">
					<div class="bicto-track-icon">01</div>
					<h3>Basic Digital Literacy</h3>
					<p>Develop essential digital skills, office productivity capabilities, professional email practices, cybersecurity awareness, and safe internet usage.</p>
					<ul>
						<li>Computer fundamentals.</li>
						<li>Word processing and spreadsheets.</li>
						<li>Email and digital communication.</li>
					</ul>
					<a href="#training-calendar">Explore Track</a>
				</article>

				<article class="bicto-track">
					<div class="bicto-track-icon">02</div>
					<h3>Government Digital Workflows</h3>
					<p>Learn how digital tools improve public service delivery, records management, collaboration, and secure administrative operations.</p>
					<ul>
						<li>Digital documentation systems.</li>
						<li>Collaboration and file handling.</li>
						<li>Secure office productivity.</li>
					</ul>
					<a href="#training-calendar">Explore Track</a>
				</article>

				<article class="bicto-track">
					<div class="bicto-track-icon">03</div>
					<h3>ICT for Community Development</h3>
					<p>Build awareness of technology for local governance, digital inclusion, e-services, and responsive community engagement.</p>
					<ul>
						<li>Open data and information access.</li>
						<li>Digital inclusion practices.</li>
						<li>Community-oriented digital services.</li>
					</ul>
					<a href="#training-calendar">Explore Track</a>
				</article>
			</div>
		</div>
	</section>

	<section class="bicto-section" id="training-calendar">
		<div class="section-shell">
			<div class="bicto-section-header">
				<p class="eyebrow">Upcoming learning</p>
				<h2>Upcoming Training &amp; Announcements</h2>
				<p>Official learning opportunities and updates are published here as schedules become available.</p>
			</div>

			<div class="bicto-schedule-grid">
				<article class="bicto-schedule-item">
					<span class="bicto-item-tag">Workshop</span>
					<h3>ICT Literacy Workshop</h3>
					<ul class="bicto-meta">
						<li>Category: Basic digital training</li>
						<li>Date: To be announced</li>
						<li>Delivery: To be confirmed</li>
					</ul>
					<p>Hands-on learning for foundational digital tools, online safety, and everyday productivity.</p>
					<a href="#announcements">View details</a>
				</article>

				<article class="bicto-schedule-item">
					<span class="bicto-item-tag">Webinar</span>
					<h3>ICT Month Webinar Series</h3>
					<ul class="bicto-meta">
						<li>Category: Knowledge sharing</li>
						<li>Date: To be announced</li>
						<li>Delivery: Online</li>
					</ul>
					<p>Digital discussions and practical insights focused on innovation, digital adoption, and public service readiness.</p>
					<a href="#announcements">View details</a>
				</article>

				<article class="bicto-schedule-item">
					<span class="bicto-item-tag">Training</span>
					<h3>WordPress &amp; Government Website Management</h3>
					<ul class="bicto-meta">
						<li>Category: Digital content and web skills</li>
						<li>Date: To be announced</li>
						<li>Delivery: Hybrid or on-site</li>
					</ul>
					<p>Practical learning on website maintenance, publishing workflows, and digital communication best practices.</p>
					<a href="#announcements">View details</a>
				</article>
			</div>
		</div>
	</section>

	<section class="bicto-section" id="announcements">
		<div class="section-shell">
			<div class="bicto-section-header">
				<p class="eyebrow">Latest updates</p>
				<h2>Announcements</h2>
				<p>Important service updates and training notices will be shared here as they are published.</p>
			</div>

			<div class="bicto-announcement-list">
				<article class="bicto-announcement-item">
					<span class="bicto-item-status">Announcement</span>
					<h3>Portal updates and training announcements</h3>
					<p>Published: To be announced</p>
					<p>Official announcements, schedule changes, and learning opportunities will appear here as they are approved.</p>
					<a href="#top">Read Announcement</a>
				</article>

				<article class="bicto-announcement-item">
					<span class="bicto-item-status">Notice</span>
					<h3>Digital skills opportunities for learners and staff</h3>
					<p>Published: To be announced</p>
					<p>Upcoming learning priorities and digital service initiatives will be shared here for access and planning.</p>
					<a href="#top">Read Announcement</a>
				</article>
			</div>
		</div>
	</section>

	<section class="bicto-about" id="about">
		<div class="section-shell">
			<div class="bicto-about-grid">
				<div class="bicto-about-copy">
					<p class="eyebrow">About the portal</p>
					<h2>Training for a digitally empowered Bangsamoro</h2>
					<p>The Bicto Digital Training Portal supports digital literacy, e-governance readiness, and practical ICT capacity building for government employees, learners, and community stakeholders.</p>
					<p>Through structured learning tracks and timely updates, the platform helps connect people with meaningful digital opportunities and stronger public service capabilities.</p>
					<div class="bicto-about-points">
						<div>Digital literacy</div>
						<div>ICT awareness</div>
						<div>Capacity building</div>
						<div>Public service readiness</div>
					</div>
				</div>

				<div class="bicto-about-visual" aria-label="ICT learning and digital capacity building illustration"></div>
			</div>
		</div>
	</section>

	<section class="bicto-cta" aria-label="Final portal call to action">
		<h2>Ready to Strengthen Your Digital Skills?</h2>
		<p>Explore available training opportunities and discover practical ways to build your ICT capabilities.</p>
		<div class="bicto-cta-actions">
			<a class="bicto-btn bicto-btn-primary" href="#training-courses">Explore Training Courses</a>
			<a class="bicto-btn bicto-btn-secondary" href="<?php echo esc_url( $login_url ); ?>">Student Portal Login</a>
		</div>
	</section>
</main>

<footer class="bicto-footer">
	<div class="bicto-footer-grid">
		<div class="bicto-footer-brand">
			<h3>Bicto Digital Training Portal</h3>
			<p>Creating Digitally Empowered Bangsamoro.</p>
			<p>Bangsamoro Information and Communications Technology Office (BICTO).</p>
		</div>

		<div class="bicto-footer-column">
			<h4>Quick Links</h4>
			<a href="#top">Home</a>
			<a href="#training-courses">Training Courses</a>
			<a href="#training-calendar">Training Calendar</a>
			<a href="#about">About</a>
		</div>

		<div class="bicto-footer-column">
			<h4>Portal Access</h4>
			<a href="<?php echo esc_url( $login_url ); ?>">Student Portal Login</a>
			<a href="#top">Privacy Policy</a>
			<a href="#top">Accessibility</a>
		</div>
	</div>

	<div class="bicto-footer-bottom">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Bicto Digital Training Portal. All rights reserved.
	</div>
</footer>