(function () {
	'use strict';
	var t = window.aramI18n || {};
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

	/* Mobile navigation */
	var navBtn = $('.nav-toggle'), nav = $('#primary-nav');
	if (navBtn && nav) {
		navBtn.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			navBtn.setAttribute('aria-expanded', String(open));
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('open')) { nav.classList.remove('open'); navBtn.setAttribute('aria-expanded', 'false'); navBtn.focus(); }
		});
	}

	/* Header search */
	var sBtn = $('.search-toggle'), sBox = $('#header-search');
	if (sBtn && sBox) {
		sBtn.addEventListener('click', function () {
			var show = sBox.hasAttribute('hidden');
			if (show) { sBox.removeAttribute('hidden'); $('input[type=search]', sBox).focus(); } else { sBox.setAttribute('hidden', ''); }
			sBtn.setAttribute('aria-expanded', String(show));
		});
	}

	/* FAQ accordion */
	$$('.faq-item button').forEach(function (b) {
		b.addEventListener('click', function () {
			var open = b.getAttribute('aria-expanded') === 'true';
			b.setAttribute('aria-expanded', String(!open));
			var p = document.getElementById(b.getAttribute('aria-controls'));
			if (p) { p.hidden = open; }
		});
	});

	/* Testimonial slider (scroll-snap with buttons; RTL aware) */
	$$('[data-slider]').forEach(function (s) {
		var track = $('.slider-track', s);
		var step = function (dir) { track.scrollBy({ left: dir * (track.clientWidth * 0.8), behavior: 'smooth' }); };
		// In RTL, scrollLeft is negative and "next" moves toward negative values.
		$('.slider-next', s).addEventListener('click', function () { step(-1); });
		$('.slider-prev', s).addEventListener('click', function () { step(1); });
	});

	/* Contact form validation */
	var form = $('#contact-form');
	if (form) {
		var clear = function (f) { f.classList.remove('invalid'); var e = f.parentNode.querySelector('.field-error'); if (e) { e.remove(); } };
		var fail = function (f, msg) { clear(f); f.classList.add('invalid'); var e = document.createElement('span'); e.className = 'field-error'; e.setAttribute('role', 'alert'); e.textContent = msg; f.parentNode.appendChild(e); return false; };
		form.addEventListener('submit', function (ev) {
			var ok = true, first = null;
			['aram_name', 'aram_email', 'aram_subject', 'aram_message', 'aram_phone'].forEach(function (id) {
				var f = document.getElementById(id); clear(f);
				var v = f.value.trim(), bad = false;
				if (id !== 'aram_phone' && !v) { bad = !fail(f, t.required); }
				else if (id === 'aram_email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { bad = !fail(f, t.email); }
				else if (id === 'aram_message' && v.length < 10) { bad = !fail(f, t.short); }
				else if (id === 'aram_phone' && v && !/^[\d\s+\-()\u06F0-\u06F9]{7,20}$/.test(v)) { bad = !fail(f, t.phone); }
				if (bad) { ok = false; first = first || f; }
			});
			if (!ok) { ev.preventDefault(); first.focus(); return; }
			var b = $('button[type=submit]', form); b.disabled = true; b.textContent = t.sending;
		});
	}

	/* Sticky buy bar: jump to the real WooCommerce add-to-cart form */
	var buy = $('[data-scroll-buy]');
	if (buy) {
		buy.addEventListener('click', function (e) {
			var f = $('form.cart');
			if (f) { e.preventDefault(); f.scrollIntoView({ behavior: 'smooth', block: 'center' }); var btn = $('button[type=submit]', f); if (btn) { btn.focus({ preventScroll: true }); } }
		});
	}
})();
