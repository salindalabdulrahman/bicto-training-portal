<?php
/**
 * Sign-in, registration and registration-confirmation modals.
 * Native <dialog> elements: the browser handles focus trapping, Esc, and inert background.
 * Every trigger keeps a real href (wp-login.php fallback), so the page still works without JS.
 *
 * @package PressBook_Green
 */

defined( 'ABSPATH' ) || die();

if ( is_user_logged_in() ) {
	return;
}

$audiences     = bicto_auth_audiences();
$tracks        = bicto_auth_tracks();
$can_register  = bicto_registration_open();
$privacy_url   = get_privacy_policy_url();
$lost_url      = wp_lostpassword_url();
$fallback_login = wp_login_url();

$close_icon = '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6L6 18"/></svg>';
$eye_icon   = '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
?>

<!-- ===================== Sign in ===================== -->
<dialog class="bicto-modal" id="bicto-modal-login" aria-labelledby="bicto-login-title" data-bicto-dialog="login">
	<div class="bicto-modal-panel">
		<header class="bicto-modal-head">
			<div>
				<p class="bicto-modal-kicker"><?php esc_html_e( 'Welcome back', 'pressbook-green' ); ?></p>
				<h2 id="bicto-login-title"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></h2>
			</div>
			<button type="button" class="bicto-modal-close" data-bicto-close aria-label="<?php esc_attr_e( 'Close sign in', 'pressbook-green' ); ?>"><?php echo $close_icon; // phpcs:ignore WordPress.Security.EscapeOutput -- static trusted SVG. ?></button>
		</header>

		<div class="bicto-modal-body">
			<form class="bicto-form" method="post" action="<?php echo esc_url( $fallback_login ); ?>" novalidate data-bicto-form="login">
				<div class="bicto-form-alert" role="alert" hidden></div>

				<div class="bicto-field">
					<label for="bicto-log"><?php esc_html_e( 'Email address or username', 'pressbook-green' ); ?></label>
					<input type="text" id="bicto-log" name="log" autocomplete="username" autocapitalize="none" spellcheck="false" required autofocus aria-describedby="bicto-log-err">
					<p class="bicto-field-error" id="bicto-log-err" hidden></p>
				</div>

				<div class="bicto-field">
					<label for="bicto-pwd"><?php esc_html_e( 'Password', 'pressbook-green' ); ?></label>
					<div class="bicto-input-wrap">
						<input type="password" id="bicto-pwd" name="pwd" autocomplete="current-password" required aria-describedby="bicto-pwd-err">
						<button type="button" class="bicto-reveal" data-bicto-reveal aria-controls="bicto-pwd" aria-pressed="false" aria-label="<?php esc_attr_e( 'Show password', 'pressbook-green' ); ?>"><?php echo $eye_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
					</div>
					<p class="bicto-field-error" id="bicto-pwd-err" hidden></p>
				</div>

				<div class="bicto-row-between">
					<label class="bicto-check-inline"><input type="checkbox" name="rememberme" value="forever"> <span><?php esc_html_e( 'Keep me signed in', 'pressbook-green' ); ?></span></label>
					<a class="bicto-text-link" href="<?php echo esc_url( $lost_url ); ?>"><?php esc_html_e( 'Forgot password?', 'pressbook-green' ); ?></a>
				</div>

				<button type="submit" class="bicto-btn bicto-btn-primary bicto-btn-block" data-bicto-submit>
					<span class="bicto-btn-label"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></span>
				</button>
			</form>

			<?php if ( $can_register ) : ?>
				<p class="bicto-modal-switch">
					<?php esc_html_e( 'New to the portal?', 'pressbook-green' ); ?>
					<a href="<?php echo esc_url( wp_registration_url() ); ?>" data-bicto-switch="register"><?php esc_html_e( 'Create an account', 'pressbook-green' ); ?></a>
				</p>
			<?php endif; ?>
		</div>
	</div>
</dialog>

<?php if ( $can_register ) : ?>
<!-- ===================== Registration ===================== -->
<dialog class="bicto-modal bicto-modal-wide" id="bicto-modal-register" aria-labelledby="bicto-register-title" data-bicto-dialog="register">
	<div class="bicto-modal-panel">
		<header class="bicto-modal-head">
			<div>
				<p class="bicto-modal-kicker"><?php esc_html_e( 'Bicto Digital Training Portal', 'pressbook-green' ); ?></p>
				<h2 id="bicto-register-title"><?php esc_html_e( 'Create an Account', 'pressbook-green' ); ?></h2>
			</div>
			<button type="button" class="bicto-modal-close" data-bicto-close aria-label="<?php esc_attr_e( 'Close registration', 'pressbook-green' ); ?>"><?php echo $close_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		</header>

		<div class="bicto-modal-body">
			<form class="bicto-form" method="post" action="<?php echo esc_url( wp_registration_url() ); ?>" novalidate data-bicto-form="register">
				<div class="bicto-form-alert" role="alert" hidden></div>
				<p class="bicto-form-note"><?php esc_html_e( 'Fields marked with * are required. Registration is free and takes about two minutes.', 'pressbook-green' ); ?></p>

				<!-- Honeypot: hidden from people, irresistible to bots. -->
				<div class="bicto-hp" aria-hidden="true">
					<label>Website <input type="text" name="bicto_website" tabindex="-1" autocomplete="off"></label>
				</div>

				<fieldset class="bicto-fieldset">
					<legend><span class="bicto-step-no" aria-hidden="true">1</span><?php esc_html_e( 'About you', 'pressbook-green' ); ?></legend>
					<div class="bicto-grid-2">
						<div class="bicto-field">
							<label for="bicto-first"><?php esc_html_e( 'First name', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></label>
							<input type="text" id="bicto-first" name="first_name" autocomplete="given-name" required maxlength="60" aria-describedby="bicto-first-err">
							<p class="bicto-field-error" id="bicto-first-err" hidden></p>
						</div>
						<div class="bicto-field">
							<label for="bicto-last"><?php esc_html_e( 'Last name', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></label>
							<input type="text" id="bicto-last" name="last_name" autocomplete="family-name" required maxlength="60" aria-describedby="bicto-last-err">
							<p class="bicto-field-error" id="bicto-last-err" hidden></p>
						</div>
					</div>
					<div class="bicto-grid-2">
						<div class="bicto-field">
							<label for="bicto-email"><?php esc_html_e( 'Email address', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></label>
							<input type="email" id="bicto-email" name="email" autocomplete="email" autocapitalize="none" spellcheck="false" required aria-describedby="bicto-email-hint bicto-email-err">
							<p class="bicto-field-hint" id="bicto-email-hint"><?php esc_html_e( 'You will sign in with this address.', 'pressbook-green' ); ?></p>
							<p class="bicto-field-error" id="bicto-email-err" hidden></p>
						</div>
						<div class="bicto-field">
							<label for="bicto-phone"><?php esc_html_e( 'Mobile number', 'pressbook-green' ); ?> <span class="bicto-opt"><?php esc_html_e( '(optional)', 'pressbook-green' ); ?></span></label>
							<input type="tel" id="bicto-phone" name="phone" autocomplete="tel" maxlength="20" aria-describedby="bicto-phone-err">
							<p class="bicto-field-error" id="bicto-phone-err" hidden></p>
						</div>
					</div>
				</fieldset>

				<fieldset class="bicto-fieldset" aria-describedby="bicto-audience-err">
					<legend><span class="bicto-step-no" aria-hidden="true">2</span><?php esc_html_e( 'I am registering as', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></legend>
					<div class="bicto-choice-grid">
						<?php foreach ( $audiences as $key => $audience ) : ?>
							<div class="bicto-choice">
								<input type="radio" name="audience" id="bicto-aud-<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" required>
								<label for="bicto-aud-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $audience['label'] ); ?></label>
							</div>
						<?php endforeach; ?>
					</div>
					<p class="bicto-field-error" id="bicto-audience-err" hidden></p>

					<div class="bicto-field bicto-org" data-bicto-org hidden>
						<label for="bicto-org"><span data-bicto-org-label><?php esc_html_e( 'Organization', 'pressbook-green' ); ?></span> <span class="bicto-req" data-bicto-org-req aria-hidden="true" hidden>*</span></label>
						<input type="text" id="bicto-org" name="organization" autocomplete="organization" maxlength="120" aria-describedby="bicto-org-err">
						<p class="bicto-field-error" id="bicto-org-err" hidden></p>
					</div>

					<p class="bicto-callout" data-bicto-gov-note hidden>
						<?php esc_html_e( 'Government accounts are verified by BICTO. You can sign in right away; trainings restricted to government personnel open once your affiliation is confirmed.', 'pressbook-green' ); ?>
					</p>
					<p class="bicto-form-note bicto-eligibility"><?php esc_html_e( 'Some training programs may set their own eligibility requirements, which are shown with each program.', 'pressbook-green' ); ?></p>
				</fieldset>

				<fieldset class="bicto-fieldset">
					<legend><span class="bicto-step-no" aria-hidden="true">3</span><?php esc_html_e( 'Tracks you are interested in', 'pressbook-green' ); ?> <span class="bicto-opt"><?php esc_html_e( '(optional)', 'pressbook-green' ); ?></span></legend>
					<div class="bicto-chip-list">
						<?php foreach ( $tracks as $slug => $label ) : ?>
							<label class="bicto-chip">
								<input type="checkbox" name="tracks[]" value="<?php echo esc_attr( $slug ); ?>">
								<span><?php echo esc_html( $label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<fieldset class="bicto-fieldset">
					<legend><span class="bicto-step-no" aria-hidden="true">4</span><?php esc_html_e( 'Secure your account', 'pressbook-green' ); ?></legend>
					<div class="bicto-grid-2">
						<div class="bicto-field">
							<label for="bicto-reg-pwd"><?php esc_html_e( 'Password', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></label>
							<div class="bicto-input-wrap">
								<input type="password" id="bicto-reg-pwd" name="pwd" autocomplete="new-password" minlength="10" required aria-describedby="bicto-reg-pwd-hint bicto-reg-pwd-err">
								<button type="button" class="bicto-reveal" data-bicto-reveal aria-controls="bicto-reg-pwd" aria-pressed="false" aria-label="<?php esc_attr_e( 'Show password', 'pressbook-green' ); ?>"><?php echo $eye_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
							</div>
							<div class="bicto-meter" aria-hidden="true"><span data-bicto-meter></span></div>
							<p class="bicto-field-hint" id="bicto-reg-pwd-hint"><?php esc_html_e( 'At least 10 characters.', 'pressbook-green' ); ?> <strong data-bicto-strength aria-live="polite"></strong></p>
							<p class="bicto-field-error" id="bicto-reg-pwd-err" hidden></p>
						</div>
						<div class="bicto-field">
							<label for="bicto-reg-pwd2"><?php esc_html_e( 'Confirm password', 'pressbook-green' ); ?> <span class="bicto-req" aria-hidden="true">*</span></label>
							<div class="bicto-input-wrap">
								<input type="password" id="bicto-reg-pwd2" name="pwd2" autocomplete="new-password" required aria-describedby="bicto-reg-pwd2-err">
							</div>
							<p class="bicto-field-error" id="bicto-reg-pwd2-err" hidden></p>
						</div>
					</div>
				</fieldset>

				<div class="bicto-field bicto-consent">
					<label class="bicto-check-inline">
						<input type="checkbox" name="privacy" value="1" required aria-describedby="bicto-privacy-err">
						<span>
							<?php
							if ( $privacy_url ) {
								printf(
									/* translators: %s: link to the privacy policy */
									esc_html__( 'I agree to the collection and use of my information as described in the %s.', 'pressbook-green' ),
									'<a href="' . esc_url( $privacy_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'Privacy Policy', 'pressbook-green' ) . '</a>'
								);
							} else {
								esc_html_e( 'I agree to the collection and use of my information for training registration.', 'pressbook-green' );
							}
							?>
						</span>
					</label>
					<p class="bicto-field-error" id="bicto-privacy-err" hidden></p>
				</div>

				<button type="submit" class="bicto-btn bicto-btn-primary bicto-btn-block" data-bicto-submit>
					<span class="bicto-btn-label"><?php esc_html_e( 'Create My Account', 'pressbook-green' ); ?></span>
				</button>
			</form>

			<p class="bicto-modal-switch">
				<?php esc_html_e( 'Already have an account?', 'pressbook-green' ); ?>
				<a href="<?php echo esc_url( $fallback_login ); ?>" data-bicto-switch="login"><?php esc_html_e( 'Sign In', 'pressbook-green' ); ?></a>
			</p>
		</div>
	</div>
</dialog>

<!-- ===================== Registration confirmation ===================== -->
<dialog class="bicto-modal" id="bicto-modal-confirm" aria-labelledby="bicto-confirm-title" aria-describedby="bicto-confirm-lede" data-bicto-dialog="confirm">
	<div class="bicto-modal-panel bicto-modal-confirm">
		<button type="button" class="bicto-modal-close bicto-modal-close-float" data-bicto-close aria-label="<?php esc_attr_e( 'Close confirmation', 'pressbook-green' ); ?>"><?php echo $close_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></button>

		<div class="bicto-confirm-hero">
			<span class="bicto-check" aria-hidden="true">
				<svg viewBox="0 0 52 52" width="64" height="64" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><circle class="bicto-check-ring" cx="26" cy="26" r="23"/><path class="bicto-check-tick" d="M15 27l8 8 15-17"/></svg>
			</span>
			<p class="bicto-modal-kicker"><?php esc_html_e( 'Registration received', 'pressbook-green' ); ?></p>
			<h2 id="bicto-confirm-title" tabindex="-1"><?php esc_html_e( 'Thank you,', 'pressbook-green' ); ?> <span data-bicto-out="firstName"></span>!</h2>
			<p id="bicto-confirm-lede"><?php esc_html_e( 'Your account has been created. Keep your reference number for any follow-up with BICTO.', 'pressbook-green' ); ?></p>
			<p class="bicto-ref"><?php esc_html_e( 'Reference', 'pressbook-green' ); ?> <strong data-bicto-out="reference"></strong></p>
		</div>

		<div class="bicto-modal-body">
			<dl class="bicto-summary">
				<div><dt><?php esc_html_e( 'Name', 'pressbook-green' ); ?></dt><dd data-bicto-out="name"></dd></div>
				<div><dt><?php esc_html_e( 'Email', 'pressbook-green' ); ?></dt><dd data-bicto-out="email"></dd></div>
				<div><dt><?php esc_html_e( 'Registered as', 'pressbook-green' ); ?></dt><dd data-bicto-out="audience"></dd></div>
				<div data-bicto-tracks-row hidden><dt><?php esc_html_e( 'Interested in', 'pressbook-green' ); ?></dt><dd data-bicto-out="tracks"></dd></div>
				<div><dt><?php esc_html_e( 'Account status', 'pressbook-green' ); ?></dt><dd><span class="bicto-status" data-bicto-out="statusLabel"></span></dd></div>
			</dl>

			<h3 class="bicto-next-title"><?php esc_html_e( 'What happens next', 'pressbook-green' ); ?></h3>
			<ol class="bicto-next" data-bicto-out="nextSteps"></ol>

			<div class="bicto-modal-actions">
				<button type="button" class="bicto-btn bicto-btn-primary" data-bicto-switch="login"><?php esc_html_e( 'Sign In Now', 'pressbook-green' ); ?></button>
				<button type="button" class="bicto-btn bicto-btn-secondary" data-bicto-close><?php esc_html_e( 'Back to Homepage', 'pressbook-green' ); ?></button>
			</div>
		</div>
	</div>
</dialog>
<?php endif; ?>
