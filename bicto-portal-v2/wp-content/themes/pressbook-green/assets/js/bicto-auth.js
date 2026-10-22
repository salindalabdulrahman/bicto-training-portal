/**
 * Bicto Digital Training Portal: sign-in / registration / confirmation modals.
 * Vanilla JS, no dependencies. Uses native <dialog>; triggers keep real hrefs as a no-JS fallback.
 */
(function () {
	'use strict';

	var cfg = window.bictoAuth;
	if (!cfg || typeof HTMLDialogElement === 'undefined' || typeof window.fetch !== 'function') {
		return; // Links fall through to wp-login.php.
	}

	var t = cfg.i18n;
	var dialogs = {};
	document.querySelectorAll('[data-bicto-dialog]').forEach(function (d) {
		dialogs[d.getAttribute('data-bicto-dialog')] = d;
	});

	/* ---------------------------------------------------------------- open / close */

	var scrollLocks = 0;
	function lockScroll() {
		if (scrollLocks++ === 0) {
			var gap = window.innerWidth - document.documentElement.clientWidth;
			document.documentElement.classList.add('bicto-modal-open');
			if (gap > 0) { document.documentElement.style.setProperty('--bicto-scrollbar', gap + 'px'); }
		}
	}
	function unlockScroll() {
		if (--scrollLocks <= 0) {
			scrollLocks = 0;
			document.documentElement.classList.remove('bicto-modal-open');
			document.documentElement.style.removeProperty('--bicto-scrollbar');
		}
	}

	function openModal(name, opener) {
		var d = dialogs[name];
		if (!d) { return false; }
		Object.keys(dialogs).forEach(function (k) {
			if (k !== name && dialogs[k].open) { dialogs[k].close(); }
		});
		if (!d.open) {
			if (opener && !d._opener) { d._opener = opener; }
			d.showModal();
			lockScroll();
			d.scrollTop = 0;
			var scroller = d.querySelector('.bicto-modal-panel');
			if (scroller) { scroller.scrollTop = 0; }
		}
		return true;
	}

	function closeModal(d) { if (d && d.open) { d.close(); } }

	Object.keys(dialogs).forEach(function (name) {
		var d = dialogs[name];

		d.addEventListener('close', function () {
			unlockScroll();
			// Return focus to whatever opened the first modal in a chain.
			var anyOpen = Object.keys(dialogs).some(function (k) { return dialogs[k].open; });
			if (!anyOpen && d._opener && document.contains(d._opener)) { d._opener.focus(); }
			if (!anyOpen) { Object.keys(dialogs).forEach(function (k) { dialogs[k]._opener = null; }); }
		});

		// Backdrop click closes, but only if the press also started on the backdrop
		// (so selecting text and releasing outside the panel does not dismiss the form).
		var downOnBackdrop = false;
		d.addEventListener('mousedown', function (e) { downOnBackdrop = (e.target === d); });
		d.addEventListener('click', function (e) {
			if (e.target === d && downOnBackdrop) { d.close(); }
			downOnBackdrop = false;
		});
	});

	// Triggers: any [data-bicto-modal], any [data-bicto-switch], any [data-bicto-close].
	document.addEventListener('click', function (e) {
		var closeBtn = e.target.closest('[data-bicto-close]');
		if (closeBtn) {
			closeModal(closeBtn.closest('dialog'));
			return;
		}

		var sw = e.target.closest('[data-bicto-switch]');
		if (sw && dialogs[sw.getAttribute('data-bicto-switch')]) {
			e.preventDefault();
			var from = sw.closest('dialog');
			var opener = from && from._opener;
			var target = sw.getAttribute('data-bicto-switch');
			if (target === 'login' && from && from.getAttribute('data-bicto-dialog') === 'confirm') {
				var email = from._email || '';
				var log = dialogs.login.querySelector('[name="log"]');
				if (log && email) { log.value = email; }
			}
			openModal(target, opener);
			focusFirst(dialogs[target], target === 'login' && from && from._email ? '[name="pwd"]' : null);
			return;
		}

		var trigger = e.target.closest('[data-bicto-modal]');
		if (trigger && dialogs[trigger.getAttribute('data-bicto-modal')]) {
			// Let ctrl/cmd/shift/middle-click use the real link.
			if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) { return; }
			e.preventDefault();
			openModal(trigger.getAttribute('data-bicto-modal'), trigger);
		}
	});

	function focusFirst(d, selector) {
		var el = selector ? d.querySelector(selector) : null;
		if (!el) { el = d.querySelector('[autofocus]'); }
		if (el) { setTimeout(function () { el.focus(); }, 30); }
	}

	// Deep links: #sign-in, #register, or ?auth=login|register (handy for "please sign in" redirects).
	function routeFromUrl() {
		var h = (location.hash || '').replace('#', '');
		var q = new URLSearchParams(location.search).get('auth');
		var want = h === 'sign-in' || q === 'login' ? 'login' : (h === 'register' || q === 'register' ? 'register' : '');
		if (want && dialogs[want]) { openModal(want); }
	}
	window.addEventListener('hashchange', routeFromUrl);
	routeFromUrl();

	/* ---------------------------------------------------------------- field helpers */

	// The error <p> lives in the same .bicto-field (or .bicto-fieldset for radio groups).
	function errEl(input) {
		var field = input.closest('.bicto-field, .bicto-fieldset');
		return field ? field.querySelector('.bicto-field-error') : null;
	}

	function setError(input, msg) {
		if (!input) { return; }
		var el = errEl(input);
		input.setAttribute('aria-invalid', 'true');
		if (input.type === 'radio') {
			input.closest('.bicto-choice-grid').classList.add('has-error');
		}
		if (el) { el.textContent = msg; el.hidden = false; }
	}

	function clearError(input) {
		input.removeAttribute('aria-invalid');
		if (input.type === 'radio') {
			var g = input.closest('.bicto-choice-grid');
			if (g) { g.classList.remove('has-error'); }
		}
		var el = errEl(input);
		if (el) { el.hidden = true; el.textContent = ''; }
	}

	function clearAll(form) {
		form.querySelectorAll('[aria-invalid]').forEach(clearError);
		form.querySelectorAll('.bicto-field-error').forEach(function (el) { el.hidden = true; el.textContent = ''; });
		form.querySelectorAll('.has-error').forEach(function (el) { el.classList.remove('has-error'); });
		showAlert(form, '');
	}

	function showAlert(form, msg) {
		var a = form.querySelector('.bicto-form-alert');
		if (!a) { return; }
		a.textContent = msg;
		a.hidden = !msg;
		if (msg) { a.scrollIntoView({ block: 'nearest', behavior: 'smooth' }); }
	}

	function fieldByName(form, name) {
		return form.querySelector('[name="' + name + '"]');
	}

	function applyServerErrors(form, data) {
		var first = null;
		var fields = (data && data.fields) || {};
		Object.keys(fields).forEach(function (name) {
			var input = fieldByName(form, name);
			if (input) { setError(input, fields[name]); first = first || input; }
		});
		showAlert(form, (data && data.message) || t.network);
		if (first) { first.focus(); }
	}

	// Clear an error as soon as the person edits that field.
	document.addEventListener('input', function (e) {
		if (e.target.matches && e.target.matches('.bicto-form [aria-invalid]')) { clearError(e.target); }
	});
	document.addEventListener('change', function (e) {
		if (e.target.matches && e.target.matches('.bicto-form input[type="radio"], .bicto-form input[type="checkbox"]')) { clearError(e.target); }
	});

	// Show / hide password.
	document.addEventListener('click', function (e) {
		var b = e.target.closest('[data-bicto-reveal]');
		if (!b) { return; }
		var input = document.getElementById(b.getAttribute('aria-controls'));
		var show = input.type === 'password';
		input.type = show ? 'text' : 'password';
		b.setAttribute('aria-pressed', show ? 'true' : 'false');
		b.setAttribute('aria-label', show ? t.hide : t.show);
		b.classList.toggle('is-on', show);
	});

	/* ---------------------------------------------------------------- submit plumbing */

	function setBusy(form, busy, label) {
		var btn = form.querySelector('[data-bicto-submit]');
		var span = btn.querySelector('.bicto-btn-label');
		if (busy) {
			btn._label = span.textContent;
			span.textContent = label;
		} else if (btn._label) {
			span.textContent = btn._label;
		}
		btn.disabled = busy;
		btn.classList.toggle('is-busy', busy);
		form.setAttribute('aria-busy', busy ? 'true' : 'false');
	}

	function post(form, action) {
		var body = new FormData(form);
		body.append('action', action);
		body.append('nonce', cfg.nonce);
		return fetch(cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' })
			.then(function (r) {
				return r.json().catch(function () { return { success: false, data: { message: t.network } }; });
			});
	}

	/* ---------------------------------------------------------------- sign in */

	var loginForm = document.querySelector('[data-bicto-form="login"]');
	if (loginForm) {
		loginForm.addEventListener('submit', function (e) {
			e.preventDefault();
			clearAll(loginForm);

			var log = loginForm.elements.log, pwd = loginForm.elements.pwd, bad = null;
			if (!log.value.trim()) { setError(log, t.required); bad = bad || log; }
			if (!pwd.value) { setError(pwd, t.required); bad = bad || pwd; }
			if (bad) { bad.focus(); return; }

			setBusy(loginForm, true, t.signingIn);
			post(loginForm, 'bicto_login')
				.then(function (res) {
					if (res.success) {
						setBusy(loginForm, true, t.signedIn);
						window.location.assign(res.data.redirect || window.location.href);
						return;
					}
					setBusy(loginForm, false);
					applyServerErrors(loginForm, res.data);
					if (!(res.data && res.data.fields && Object.keys(res.data.fields).length)) { pwd.select(); }
				})
				.catch(function () {
					setBusy(loginForm, false);
					showAlert(loginForm, t.network);
				});
		});
		// Preserve the current page as the post-login destination.
		var redirect = document.createElement('input');
		redirect.type = 'hidden'; redirect.name = 'redirect_to'; redirect.value = window.location.href.split('#')[0];
		loginForm.appendChild(redirect);
	}

	/* ---------------------------------------------------------------- registration */

	var regForm = document.querySelector('[data-bicto-form="register"]');
	if (regForm) {
		var orgWrap = regForm.querySelector('[data-bicto-org]');
		var orgInput = orgWrap.querySelector('input');
		var orgLabel = orgWrap.querySelector('[data-bicto-org-label]');
		var orgReq = orgWrap.querySelector('[data-bicto-org-req]');
		var govNote = regForm.querySelector('[data-bicto-gov-note]');

		// Audience drives the organization field and the government verification note.
		regForm.addEventListener('change', function (e) {
			if (e.target.name !== 'audience') { return; }
			var a = cfg.audiences[e.target.value] || {};
			var hasOrg = !!a.orgLabel;
			orgWrap.hidden = !hasOrg;
			orgLabel.textContent = a.orgLabel || '';
			orgReq.hidden = !a.orgRequired;
			orgInput.required = !!a.orgRequired;
			if (!hasOrg) { orgInput.value = ''; clearError(orgInput); }
			govNote.hidden = a.access !== 'government';
		});

		// Password strength: length first, then variety. Advisory only; the server enforces the minimum.
		var pwd = regForm.elements.pwd, pwd2 = regForm.elements.pwd2;
		var meter = regForm.querySelector('[data-bicto-meter]');
		var strengthText = regForm.querySelector('[data-bicto-strength]');
		function score(v) {
			if (!v) { return -1; }
			if (v.length < 10) { return 0; }
			var s = 1;
			if (/[a-z]/.test(v) && /[A-Z]/.test(v)) { s++; }
			if (/\d/.test(v)) { s++; }
			if (/[^A-Za-z0-9]/.test(v) || v.length >= 16) { s++; }
			return Math.min(s, 4);
		}
		pwd.addEventListener('input', function () {
			var s = score(pwd.value);
			meter.parentNode.setAttribute('data-level', s < 0 ? '' : String(s));
			meter.style.width = s < 0 ? '0%' : ((s + 1) * 20) + '%';
			strengthText.textContent = s < 0 ? '' : t.strength[s];
		});

		regForm.addEventListener('submit', function (e) {
			e.preventDefault();
			clearAll(regForm);

			var el = regForm.elements, bad = [];
			function need(input, ok, msg) { if (!ok) { setError(input, msg); bad.push(input); } }

			need(el.first_name, el.first_name.value.trim(), t.required);
			need(el.last_name, el.last_name.value.trim(), t.required);
			if (!el.email.value.trim()) { need(el.email, false, t.required); }
			else { need(el.email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.email.value.trim()), t.email); }

			var picked = regForm.querySelector('input[name="audience"]:checked');
			need(regForm.querySelector('input[name="audience"]'), !!picked, t.required);
			if (picked && (cfg.audiences[picked.value] || {}).orgRequired) {
				need(orgInput, orgInput.value.trim(), t.required);
			}

			need(pwd, pwd.value.length >= 10, t.passwordShort);
			if (pwd.value.length >= 10) { need(pwd2, pwd2.value === pwd.value, t.passwordMatch); }
			need(el.privacy, el.privacy.checked, t.consent);

			if (bad.length) {
				showAlert(regForm, t.fixErrors);
				bad[0].focus();
				return;
			}

			setBusy(regForm, true, t.registering);
			post(regForm, 'bicto_register')
				.then(function (res) {
					setBusy(regForm, false);
					if (res.success) { showConfirmation(res.data); return; }
					applyServerErrors(regForm, res.data);
				})
				.catch(function () {
					setBusy(regForm, false);
					showAlert(regForm, t.network);
				});
		});

		// Reset form state after a successful registration.
		window.__bictoResetRegister = function () {
			regForm.reset();
			clearAll(regForm);
			orgWrap.hidden = true; govNote.hidden = true; orgReq.hidden = true; orgInput.required = false;
			meter.style.width = '0%'; meter.parentNode.setAttribute('data-level', ''); strengthText.textContent = '';
			regForm.querySelectorAll('[data-bicto-reveal]').forEach(function (b) {
				var i = document.getElementById(b.getAttribute('aria-controls'));
				i.type = 'password'; b.setAttribute('aria-pressed', 'false'); b.setAttribute('aria-label', t.show); b.classList.remove('is-on');
			});
		};
	}

	/* ---------------------------------------------------------------- confirmation */

	function showConfirmation(data) {
		var d = dialogs.confirm;
		if (!d) { return; }

		function out(key) { return d.querySelector('[data-bicto-out="' + key + '"]'); }
		['firstName', 'reference', 'name', 'email', 'audience', 'statusLabel'].forEach(function (k) {
			var node = out(k);
			if (node) { node.textContent = data[k] || ''; }
		});

		var tracksRow = d.querySelector('[data-bicto-tracks-row]');
		var hasTracks = data.tracks && data.tracks.length;
		tracksRow.hidden = !hasTracks;
		if (hasTracks) { out('tracks').textContent = data.tracks.join(', '); }

		var status = out('statusLabel');
		status.classList.toggle('is-pending', data.status === 'pending');

		var list = out('nextSteps');
		list.textContent = '';
		(data.nextSteps || []).forEach(function (s) {
			var li = document.createElement('li');
			li.textContent = s; // textContent: server strings are never parsed as HTML.
			list.appendChild(li);
		});

		d._email = data.email;
		var opener = dialogs.register && dialogs.register._opener;
		openModal('confirm', opener);

		var title = d.querySelector('#bicto-confirm-title');
		if (title) { setTimeout(function () { title.focus(); }, 30); }

		if (window.__bictoResetRegister) { window.__bictoResetRegister(); }
	}
})();
