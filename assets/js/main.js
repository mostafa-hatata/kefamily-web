/*!
 * KeFamily — interactions (vanilla, no dependencies).
 * Patterns re-implemented after Magic UI / Animate UI (MIT).
 */
(function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var KF = window.KF || {};
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(pointer: fine)').matches;
	var $ = function (s, c) { return (c || doc).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };
	var rtl = root.getAttribute('dir') === 'rtl';

	/* ---------- Nav ---------- */
	var nav = $('[data-nav]');
	var dock = $('[data-dock]');
	var onScroll = function () {
		var y = window.scrollY;
		if (nav) nav.classList.toggle('is-scrolled', y > 8);
		if (dock) dock.classList.toggle('show', y > 420);
	};
	onScroll();
	window.addEventListener('scroll', onScroll, { passive: true });

	var burger = $('[data-burger]');
	var mmenu = $('[data-mmenu]');
	function setMenu(open) {
		if (!burger || !mmenu) return;
		burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		mmenu.hidden = !open;
		if (nav) nav.classList.toggle('is-open', open);
		doc.body.style.overflow = open ? 'hidden' : '';
	}
	if (burger) {
		burger.addEventListener('click', function () { setMenu(burger.getAttribute('aria-expanded') !== 'true'); });
		$$('a', mmenu).forEach(function (a) { a.addEventListener('click', function () { setMenu(false); }); });
		doc.addEventListener('keydown', function (e) { if (e.key === 'Escape') setMenu(false); });
	}

	/* ---------- Light / dark toggle ---------- */
	$$('[data-theme-toggle]').forEach(function (b) {
		b.addEventListener('click', function () {
			var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('kf-theme', next); } catch (e) {}
			doc.dispatchEvent(new CustomEvent('kf:theme'));
		});
	});

	/* ---------- Nav dropdowns (hover on desktop, click/keyboard everywhere) ---------- */
	$$('[data-dd]').forEach(function (dd) {
		var btn = $('button', dd), t;
		var set = function (o) { dd.classList.toggle('open', o); btn.setAttribute('aria-expanded', o ? 'true' : 'false'); };
		btn.addEventListener('click', function (e) { e.stopPropagation(); set(!dd.classList.contains('open')); });
		if (finePointer) {
			dd.addEventListener('mouseenter', function () { clearTimeout(t); set(true); });
			dd.addEventListener('mouseleave', function () { t = setTimeout(function () { set(false); }, 160); });
		}
		dd.addEventListener('keydown', function (e) { if (e.key === 'Escape') { set(false); btn.focus(); } });
		dd.addEventListener('focusout', function (e) { if (!dd.contains(e.relatedTarget)) set(false); });
	});
	doc.addEventListener('click', function () { $$('[data-dd].open').forEach(function (d) { d.classList.remove('open'); $('button', d).setAttribute('aria-expanded', 'false'); }); });

	/* ---------- Reveal on scroll ---------- */
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (en) {
			if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
		});
	}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
	$$('.reveal, .timeline li').forEach(function (el) { io.observe(el); });

	/* ---------- Word rotator (slide, brand colour per word) ---------- */
	var rot = $('[data-rotator-word]');
	var words = Array.isArray(KF.rotate) ? KF.rotate : [];
	var wstyles = Array.isArray(KF.rotateStyles) ? KF.rotateStyles : [];
	/* Reserve the tallest word's height so the page never jumps. */
	var rotLine = rot && rot.closest('.hero__line--rot');
	var sizeRot = function () {
		if (!rotLine || !words.length) return;
		var probe = rot.cloneNode(false), max = 0;
		probe.removeAttribute('data-rotator-word');
		probe.style.cssText = 'position:absolute;visibility:hidden;inset-inline-start:0;width:' + rotLine.clientWidth + 'px;display:block';
		rotLine.appendChild(probe);
		words.forEach(function (w) { probe.textContent = w; max = Math.max(max, probe.offsetHeight); });
		rotLine.removeChild(probe);
		rotLine.style.setProperty('--rot-h', max + 'px');
	};
	if (rotLine) {
		rotLine.style.position = 'relative';
		sizeRot();
		window.addEventListener('resize', sizeRot);
		if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(sizeRot);
	}
	if (rot && words.length > 1 && !reduce) {
		var wi = 0;
		setInterval(function () {
			if (doc.hidden) return;
			rot.classList.add('is-out');
			setTimeout(function () {
				wi = (wi + 1) % words.length;
				rot.textContent = words[wi];
				if (wstyles[wi]) rot.setAttribute('style', wstyles[wi]);
				rot.classList.remove('is-out');
				rot.classList.add('is-in');
				void rot.offsetWidth;
				rot.classList.remove('is-in');
			}, 320);
		}, 2600);
	}

	/* ---------- Number ticker ---------- */
	var tickIO = new IntersectionObserver(function (entries) {
		entries.forEach(function (en) {
			if (!en.isIntersecting) return;
			var el = en.target, to = parseInt(el.getAttribute('data-count'), 10) || 0;
			tickIO.unobserve(el);
			if (reduce) { el.textContent = to; return; }
			el.textContent = '0';
			var start = null, dur = 900 + to * 30;
			var step = function (t) {
				if (!start) start = t;
				var k = Math.min(1, (t - start) / dur);
				var e = 1 - Math.pow(1 - k, 4);
				el.textContent = Math.round(to * e);
				if (k < 1) requestAnimationFrame(step);
			};
			requestAnimationFrame(step);
		});
	}, { threshold: 0.6 });
	$$('[data-count]').forEach(function (el) { tickIO.observe(el); });

	/* ---------- Timeline fill ---------- */
	var tl = $('[data-timeline]');
	if (tl) {
		var fill = $('[data-timeline-fill]', tl);
		var tlUpdate = function () {
			var r = tl.getBoundingClientRect();
			var vh = window.innerHeight;
			var p = Math.min(1, Math.max(0, (vh * 0.7 - r.top) / r.height));
			fill.style.setProperty('--p', (p * 100) + '%');
		};
		tlUpdate();
		window.addEventListener('scroll', tlUpdate, { passive: true });
	}

	/* ---------- Animated beams ---------- */
	var beams = $('[data-beams]');
	if (beams) {
		var svg = $('.beams__svg', beams);
		var hub = $('[data-beam-hub]', beams);
		var nodes = $$('[data-beam-node]', beams);
		var NS = 'http://www.w3.org/2000/svg';
		var build = function () {
			var b = beams.getBoundingClientRect();
			var h = hub.getBoundingClientRect();
			var hx = h.left - b.left + h.width / 2, hy = h.top - b.top + h.height / 2;
			svg.setAttribute('viewBox', '0 0 ' + b.width + ' ' + b.height);
			while (svg.lastChild) svg.removeChild(svg.lastChild);
			var defs = doc.createElementNS(NS, 'defs');
			svg.appendChild(defs);
			nodes.forEach(function (n, i) {
				var r = n.getBoundingClientRect();
				var nx = r.left - b.left + r.width / 2, ny = r.top - b.top + r.height / 2;
				var color = getComputedStyle(n).getPropertyValue('--c').trim() || '#a78bfa';
				var curve = (i % 2 ? -1 : 1) * 40;
				var mx = (nx + hx) / 2, my = (ny + hy) / 2 - curve;
				var d = 'M' + nx + ',' + ny + ' Q' + mx + ',' + my + ' ' + hx + ',' + hy;
				var id = 'kfb' + i;
				var lg = doc.createElementNS(NS, 'linearGradient');
				lg.setAttribute('id', id);
				lg.setAttribute('gradientUnits', 'userSpaceOnUse');
				lg.setAttribute('x1', nx); lg.setAttribute('y1', ny); lg.setAttribute('x2', hx); lg.setAttribute('y2', hy);
				var fam = getComputedStyle(root).getPropertyValue('--fam').trim() || '#ffffff';
				lg.innerHTML = '<stop offset="0" stop-color="' + color + '"/><stop offset="1" stop-color="' + fam + '"/>';
				defs.appendChild(lg);
				var base = doc.createElementNS(NS, 'path');
				base.setAttribute('d', d); base.setAttribute('class', 'beam-base');
				svg.appendChild(base);
				var glow = doc.createElementNS(NS, 'path');
				glow.setAttribute('d', d); glow.setAttribute('class', 'beam-glow');
				glow.setAttribute('stroke', 'url(#' + id + ')');
				glow.style.color = color;
				glow.style.animationDelay = (i * 0.8) + 's';
				svg.appendChild(glow);
			});
		};
		build();
		if ('ResizeObserver' in window) new ResizeObserver(build).observe(beams);
		else window.addEventListener('resize', build);
		if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(build);
		doc.addEventListener('kf:theme', build);
	}

	/* ---------- Contact form ---------- */
	var form = $('[data-contact-form]');
	if (form) {
		var status = $('[data-status]', form);
		var label = $('[data-label]', form);
		var btn = $('button[type="submit"]', form);
		var i18n = KF.i18n || {};
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var name = form.elements.name, email = form.elements.email, phone = form.elements.phone;
			[name, email, phone].forEach(function (f) { f.removeAttribute('aria-invalid'); });
			status.className = 'form__status';
			if (!name.value.trim() || (!email.value.trim() && !phone.value.trim())) {
				if (!name.value.trim()) name.setAttribute('aria-invalid', 'true');
				if (!email.value.trim() && !phone.value.trim()) { email.setAttribute('aria-invalid', 'true'); phone.setAttribute('aria-invalid', 'true'); }
				status.textContent = i18n.required || '';
				status.classList.add('err');
				return;
			}
			btn.disabled = true;
			label.textContent = i18n.sending || '…';
			fetch(KF.ajax + '?action=kf_nonce', { credentials: 'same-origin', cache: 'no-store' })
				.then(function (r) { return r.json(); })
				.then(function (n) { if (n && n.success) form.elements.kf_nonce.value = n.data.nonce; })
				.catch(function () {})
				.then(function () { return fetch(KF.ajax, { method: 'POST', body: new FormData(form), credentials: 'same-origin' }); })
				.then(function (r) { return r.json().catch(function () { return { success: false }; }); })
				.then(function (res) {
					if (res && res.success) {
						form.reset();
						status.textContent = i18n.ok || 'OK';
						status.classList.add('ok');
						if (window.dataLayer) window.dataLayer.push({ event: 'generate_lead', form: 'kefamily_contact' });
					} else {
						status.textContent = (res && res.data && res.data.code === 'required') ? i18n.required : i18n.err;
						status.classList.add('err');
					}
				})
				.catch(function () { status.textContent = i18n.err || 'Error'; status.classList.add('err'); })
				.then(function () { btn.disabled = false; label.textContent = i18n.send || 'Send'; });
		});
	}

	/* ---------- Contact dock (WhatsApp panel) ---------- */
	var waBtn = $('[data-wa-toggle]'), waPanel = $('[data-wa-panel]');
	if (waBtn && waPanel) {
		var setWa = function (o) {
			waPanel.hidden = !o;
			waBtn.setAttribute('aria-expanded', o ? 'true' : 'false');
			if (dock) dock.classList.toggle('is-open', o);
			if (o) { var f = $('.dock__topics a', waPanel); if (f) f.focus(); }
		};
		waBtn.addEventListener('click', function (e) { e.stopPropagation(); setWa(waPanel.hidden); });
		$('[data-wa-close]', waPanel).addEventListener('click', function () { setWa(false); waBtn.focus(); });
		waPanel.addEventListener('click', function (e) { e.stopPropagation(); });
		doc.addEventListener('click', function () { if (!waPanel.hidden) setWa(false); });
		doc.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !waPanel.hidden) { setWa(false); waBtn.focus(); } });
		$$('a', waPanel).forEach(function (a) {
			a.addEventListener('click', function () { if (window.dataLayer) window.dataLayer.push({ event: 'whatsapp_click', source: 'dock' }); });
		});
	}

	/* ---------- Meeting booking (Google Apps Script endpoint, same as kemarq.net) ---------- */
	var bookForm = $('[data-book-form]');
	if (bookForm && KF.book && KF.book.endpoint) {
		var B = KF.book, T = B.i18n || {};
		var daysEl = $('[data-days]', bookForm), timesEl = $('[data-times]', bookForm);
		var bStatus = $('[data-book-status]', bookForm), bBtn = $('[data-book-submit]', bookForm), bLabel = $('[data-label]', bBtn);
		var sumWhen = $('[data-sum-when]'), sumType = $('[data-sum-type]');
		var loc = { ar: 'ar-EG', ru: 'ru-RU', de: 'de-DE' }[KF.lang] || 'en-GB';
		var sel = { date: '', hour: null };
		var pad = function (n) { return (n < 10 ? '0' : '') + n; };
		var setStatus = function (cls, text, link) {
			bStatus.className = 'form__status' + (cls ? ' ' + cls : '');
			bStatus.textContent = text || '';
			if (link) {
				bStatus.appendChild(doc.createTextNode(' '));
				var a = doc.createElement('a'); a.href = B.wa; a.target = '_blank'; a.rel = 'noopener'; a.textContent = 'WhatsApp';
				bStatus.appendChild(a);
			}
		};
		/* "Today" in Riyadh time, then the next 10 working days (Sun–Thu). */
		var today = new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Riyadh', year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date()).split('-');
		var base = Date.UTC(+today[0], +today[1] - 1, +today[2]);
		var fmt = function (o) { o.timeZone = 'UTC'; return new Intl.DateTimeFormat(loc, o); };
		var fDay = fmt({ weekday: 'short' }), fNum = fmt({ day: 'numeric' }), fMon = fmt({ month: 'short' }), fLong = fmt({ weekday: 'long', day: 'numeric', month: 'long' });
		for (var d = 1, made = 0; made < 10 && d < 21; d++) {
			var dt = new Date(base + d * 864e5), wd = dt.getUTCDay();
			if (wd === 5 || wd === 6) continue;
			var iso = dt.getUTCFullYear() + '-' + pad(dt.getUTCMonth() + 1) + '-' + pad(dt.getUTCDate());
			var b = doc.createElement('button');
			b.type = 'button'; b.className = 'day'; b.setAttribute('role', 'radio'); b.setAttribute('aria-checked', 'false');
			b.tabIndex = made ? -1 : 0;
			b.dataset.date = iso; b.dataset.long = fLong.format(dt);
			['small', 'b', 'small'].forEach(function (tag, k) {
				var el = doc.createElement(tag);
				el.textContent = [fDay, fNum, fMon][k].format(dt);
				b.appendChild(el);
			});
			daysEl.appendChild(b);
			made++;
		}
		var updateSum = function () {
			var day = $('.day[aria-checked="true"]', daysEl);
			sumWhen.textContent = day ? day.dataset.long + (sel.hour !== null ? ' · ' + pad(sel.hour) + ':00' : '') : '—';
			var t = $('input[name="meeting"]:checked', bookForm);
			if (t && sumType) sumType.textContent = $('b', t.parentNode).textContent;
		};
		$$('input[name="meeting"]', bookForm).forEach(function (r) { r.addEventListener('change', updateSum); });
		var msg = function (text) { timesEl.innerHTML = ''; var p = doc.createElement('p'); p.className = 'muted'; p.textContent = text; timesEl.appendChild(p); };
		var loadSlots = function (date) {
			msg(T.loading || '…');
			timesEl.setAttribute('aria-busy', 'true');
			fetch(B.endpoint + '?action=slots&date=' + encodeURIComponent(date), { cache: 'no-store' })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (date !== sel.date) return;
					var slots = (res && res.ok && Array.isArray(res.slots)) ? res.slots : [];
					if (!slots.length) { msg(T.none || ''); return; }
					timesEl.innerHTML = '';
					slots.forEach(function (h, k) {
						var tb = doc.createElement('button');
						tb.type = 'button'; tb.className = 'slot'; tb.setAttribute('role', 'radio'); tb.setAttribute('aria-checked', 'false');
						tb.tabIndex = k ? -1 : 0;
						tb.dataset.hour = h; tb.textContent = pad(+h) + ':00'; tb.dir = 'ltr';
						timesEl.appendChild(tb);
					});
				})
				.catch(function () { msg(T.err || ''); })
				.then(function () { timesEl.removeAttribute('aria-busy'); });
		};
		var pick = function (group, btn) {
			$$('button', group).forEach(function (x) { var on = x === btn; x.setAttribute('aria-checked', on ? 'true' : 'false'); x.tabIndex = on ? 0 : -1; });
		};
		daysEl.addEventListener('click', function (e) {
			var b = e.target.closest('.day'); if (!b) return;
			pick(daysEl, b);
			sel.date = b.dataset.date; sel.hour = null; updateSum(); loadSlots(sel.date);
		});
		timesEl.addEventListener('click', function (e) {
			var b = e.target.closest('.slot'); if (!b) return;
			pick(timesEl, b);
			sel.hour = +b.dataset.hour; updateSum();
		});
		[daysEl, timesEl].forEach(function (g) {
			g.addEventListener('keydown', function (e) {
				var items = $$('button', g), i = items.indexOf(doc.activeElement);
				if (i < 0) return;
				var dir = { ArrowRight: rtl ? -1 : 1, ArrowLeft: rtl ? 1 : -1, ArrowDown: 1, ArrowUp: -1 }[e.key];
				if (dir) { e.preventDefault(); var n = items[(i + dir + items.length) % items.length]; n.tabIndex = 0; n.focus(); }
			});
		});
		bookForm.addEventListener('submit', function (e) {
			e.preventDefault();
			var f = bookForm.elements;
			[f.name, f.email].forEach(function (x) { x.removeAttribute('aria-invalid'); });
			var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email.value.trim());
			if (!sel.date || sel.hour === null || !f.name.value.trim() || !emailOk) {
				if (!f.name.value.trim()) f.name.setAttribute('aria-invalid', 'true');
				if (!emailOk) f.email.setAttribute('aria-invalid', 'true');
				setStatus('err', T.required);
				return;
			}
			var meeting = $('input[name="meeting"]:checked', bookForm).value;
			var payload = {
				type: 'book', date: sel.date, hour: sel.hour,
				name: f.name.value.trim(), email: f.email.value.trim(), phone: f.phone.value.trim(),
				company: f.company.value.trim(), service: f.service.value, topic: f.topic.value.trim(),
				meeting: meeting, lang: KF.lang, source: 'kefamily', website_hp: f.website_hp.value
			};
			bBtn.disabled = true; bLabel.textContent = T.sending || '…'; setStatus('', '');
			fetch(B.endpoint, { method: 'POST', headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: JSON.stringify(payload) })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (!res || !res.ok) throw new Error('book');
					var fd = new FormData();
					fd.append('action', 'kf_book_log'); fd.append('nonce', B.nonce);
					Object.keys(payload).forEach(function (k) { if (k !== 'website_hp' && k !== 'type') fd.append(k, payload[k]); });
					fetch(KF.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).catch(function () {});
					setStatus('ok', T.ok);
					if (window.dataLayer) window.dataLayer.push({ event: 'book_meeting', meeting: meeting });
					sel.hour = null; updateSum(); loadSlots(sel.date);
				})
				.catch(function () { setStatus('err', T.err, true); })
				.then(function () { bBtn.disabled = false; bLabel.textContent = T.confirm || 'Book'; });
		});
	}

	/* RTL marker for any script that needs it */
	if (rtl) root.classList.add('is-rtl');
})();
