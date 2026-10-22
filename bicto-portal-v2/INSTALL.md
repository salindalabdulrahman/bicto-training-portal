# Bicto portal v2: sign-in, registration and confirmation modals

## 1. Copy the files
Drop `wp-content/` over your site (it mirrors your theme structure). **New:**
`inc/bicto-auth.php`, `template-parts/bicto-auth-modals.php`, `assets/css/bicto-auth.css`, `assets/js/bicto-auth.js`.
**Changed:** `template-parts/bicto-portal-home.php`, `assets/css/bicto-home.css`.

## 2. One line in functions.php (required)
```php
require_once get_stylesheet_directory() . '/inc/bicto-auth.php';
```
The AJAX handlers must load on every request, not just on the homepage, so this cannot live in the template.

## 3. WordPress settings
- **Settings > General > Anyone can register** must be ticked, or the Create an Account buttons show the existing "registration not yet open" state.
- Set a **Privacy Policy page** (Settings > Privacy). The registration form links to it and records consent time on the user.
- Make sure outgoing email works (use an SMTP plugin). Confirmation and admin notices use `wp_mail()`.

## 3b. If you use a page-cache plugin
The AJAX nonce is printed into the page. Keep cache lifetime under 12 hours, or exclude the homepage from caching.

## What it does
- **Sign in modal**: email or username + password, show/hide password, keep me signed in, forgot password. Generic error message (no account enumeration), 8 failed attempts per 15 min per IP.
- **Registration modal**: built from the page's own content. The six "Learning for everyone" audiences (now generated from one list in `bicto_auth_audiences()`, so hero, form and server validation cannot drift), the three training tracks as optional interests, a conditional Ministry/Office field for government staff, and the eligibility note.
- **Confirmation modal**: reference number (BICTO-YYYY-00042), summary, status, and "what happens next". Sign In Now prefills the email.
- **Government accounts** are created as `pending`. Admins verify them under Users > edit user > "Bicto portal registration". The Users list gains "Registered as" and "Portal access" columns. Gate restricted content on the `bicto_access_status` user meta (`verified` or `active`).
- Signed-in visitors see their name, My Profile and Sign Out instead of the register/sign-in buttons.
- Deep links: `/#sign-in`, `/#register`, or `?auth=login` / `?auth=register`.

## Hooks
`bicto_auth_audiences`, `bicto_auth_tracks`, `bicto_registration_open`, `bicto_login_redirect`, `bicto_load_auth_assets`, `bicto_auth_client_ip` (filters); `bicto_user_registered` (action, args: user id, audience, status).

## Try it without WordPress
Open `preview/index.html` in a browser. It uses a mocked backend: sign in with any email and password `demo-password`; register with `taken@example.com` to see a server-side error.

## Requirements
WordPress 6.3+ (script `strategy`), PHP 7.4+, a browser with native `<dialog>` (all current ones). Without JS or on older browsers, every button falls back to the normal wp-login.php pages.
