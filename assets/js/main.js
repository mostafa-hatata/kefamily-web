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
	var dockHide = false;
	/* Keep the floating dock off the closing CTA and the footer (they have the same buttons). */
	if (dock && 'IntersectionObserver' in window) {
		var seen = new Set();
		var dio = new IntersectionObserver(function (en) {
			en.forEach(function (e) { if (e.isIntersecting) seen.add(e.target); else seen.delete(e.target); });
			dockHide = seen.size > 0 && !dock.classList.contains('is-open');
			dock.classList.toggle('show', window.scrollY > 480 && !dockHide);
		}, { threshold: 0.15 });
		document.querySelectorAll('.cta, .footer').forEach(function (el) { dio.observe(el); });
	}
	var bar = $('[data-progress]');
	var heroVis = $('.hero__visual');
	var onScroll = function () {
		var y = window.scrollY;
		if (nav) nav.classList.toggle('is-scrolled', y > 24);
		if (dock) dock.classList.toggle('show', y > 480 && !dockHide);
		if (bar) { var max = doc.documentElement.scrollHeight - window.innerHeight; bar.style.setProperty('--p', max > 0 ? Math.min(1, y / max) : 0); }
		if (heroVis && !reduce && y < window.innerHeight * 1.2) heroVis.style.setProperty('--py', (y * 0.18) + 'px');
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

	/* ---------- Word rotator (blur in/out) ---------- */
	var rot = $('[data-rotator-word]');
	var words = Array.isArray(KF.rotate) ? KF.rotate : [];
	var wstyles = Array.isArray(KF.rotateStyles) ? KF.rotateStyles : [];
	var rotBox = rot && rot.parentNode;
	var sizeRot = function () {
		if (!rotBox || !words.length) return;
		var probe = rot.cloneNode(false), max = 0;
		probe.removeAttribute('data-rotator-word');
		probe.style.cssText = 'position:absolute;visibility:hidden;inset-inline-start:0;top:0;width:' + rotBox.clientWidth + 'px;display:block';
		rotBox.appendChild(probe);
		words.forEach(function (w) { probe.textContent = w; max = Math.max(max, probe.offsetHeight); });
		rotBox.removeChild(probe);
		rotBox.style.minHeight = max + 'px';
	};
	if (rotBox) { sizeRot(); window.addEventListener('resize', sizeRot); if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(sizeRot); }
	if (rot && words.length > 1 && !reduce) {
		var wi = 0;
		setInterval(function () {
			rot.classList.add('is-out');
			setTimeout(function () {
				wi = (wi + 1) % words.length;
				rot.textContent = words[wi];
				if (wstyles[wi]) rot.setAttribute('style', wstyles[wi]);
				rot.classList.remove('is-out');
				rot.classList.add('is-in');
				void rot.offsetWidth; // reflow
				rot.classList.remove('is-in');
			}, 520);
		}, 2800);
	}

	/* ---------- Particles (hero) ---------- */
	var canvas = $('[data-particles]');
	if (canvas && !reduce) {
		var ctx = canvas.getContext('2d');
		var dpr = Math.min(window.devicePixelRatio || 1, 2);
		var W, H, parts = [], mouse = { x: 0, y: 0, tx: 0, ty: 0 }, running = true, raf;
		var brandCols = ['35,103,242', '130,71,219', '37,211,102', '250,204,21'];
		var colors;
		var setColors = function () {
			var fg = getComputedStyle(root).getPropertyValue('--fg').trim() || '255,255,255';
			colors = [fg, fg, fg, fg].concat(brandCols);
			parts.forEach(function (p) { p.c = colors[(Math.random() * colors.length) | 0]; });
		};
		var resize = function () {
			var r = canvas.getBoundingClientRect();
			W = r.width; H = r.height;
			canvas.width = W * dpr; canvas.height = H * dpr;
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
			var n = Math.round(Math.min(110, (W * H) / 14000));
			parts = [];
			for (var i = 0; i < n; i++) {
				parts.push({
					x: Math.random() * W, y: Math.random() * H,
					r: Math.random() * 1.4 + 0.3,
					vx: (Math.random() - 0.5) * 0.12, vy: (Math.random() - 0.5) * 0.12,
					a: Math.random() * 0.6 + 0.15, z: Math.random() * 0.8 + 0.2,
					c: colors ? colors[(Math.random() * colors.length) | 0] : '255,255,255'
				});
			}
		};
		var draw = function () {
			mouse.x += (mouse.tx - mouse.x) * 0.05;
			mouse.y += (mouse.ty - mouse.y) * 0.05;
			ctx.clearRect(0, 0, W, H);
			for (var i = 0; i < parts.length; i++) {
				var p = parts[i];
				p.x += p.vx; p.y += p.vy;
				if (p.x < -5) p.x = W + 5; if (p.x > W + 5) p.x = -5;
				if (p.y < -5) p.y = H + 5; if (p.y > H + 5) p.y = -5;
				var x = p.x + mouse.x * p.z * 26, y = p.y + mouse.y * p.z * 26;
				ctx.beginPath();
				ctx.arc(x, y, p.r, 0, Math.PI * 2);
				ctx.fillStyle = 'rgba(' + p.c + ',' + p.a + ')';
				ctx.fill();
			}
			if (running) raf = requestAnimationFrame(draw);
		};
		resize();
		setColors();
		draw();
		doc.addEventListener('kf:theme', setColors);
		window.addEventListener('resize', resize);
		window.addEventListener('pointermove', function (e) {
			mouse.tx = (e.clientX / window.innerWidth - 0.5);
			mouse.ty = (e.clientY / window.innerHeight - 0.5);
		}, { passive: true });
		new IntersectionObserver(function (en) {
			running = en[0].isIntersecting;
			if (running) { cancelAnimationFrame(raf); raf = requestAnimationFrame(draw); }
		}).observe(canvas);
	}

	/* ---------- Spotlight cards ---------- */
	if (finePointer) {
		$$('[data-spotlight]').forEach(function (el) {
			el.addEventListener('pointermove', function (e) {
				var r = el.getBoundingClientRect();
				el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
				el.style.setProperty('--my', (e.clientY - r.top) + 'px');
			});
		});
	}

	/* ---------- Magnetic buttons ---------- */
	if (finePointer && !reduce) {
		$$('[data-magnetic]').forEach(function (el) {
			el.addEventListener('pointermove', function (e) {
				var r = el.getBoundingClientRect();
				var x = (e.clientX - r.left - r.width / 2) * 0.18;
				var y = (e.clientY - r.top - r.height / 2) * 0.28;
				el.style.transform = 'translate(' + x + 'px,' + y + 'px)';
			});
			el.addEventListener('pointerleave', function () { el.style.transform = ''; });
		});
	}

	/* ---------- Number ticker ---------- */
	var tickIO = new IntersectionObserver(function (entries) {
		entries.forEach(function (en) {
			if (!en.isIntersecting) return;
			var el = en.target, to = parseInt(el.getAttribute('data-count'), 10) || 0;
			tickIO.unobserve(el);
			if (reduce) { el.textContent = to; return; }
			var start = null, dur = 1600 + to * 40;
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

	/* ---------- Text reveal on scroll (manifesto) ---------- */
	var tr = $('[data-textreveal]');
	if (tr) {
		var txt = $('[data-words]', tr);
		var parts2 = txt.textContent.trim().split(/\s+/);
		txt.innerHTML = '';
		parts2.forEach(function (w, i) {
			var s = doc.createElement('span');
			s.className = 'w';
			s.textContent = w;
			txt.appendChild(s);
			if (i < parts2.length - 1) txt.appendChild(doc.createTextNode(' '));
		});
		var ws = $$('.w', txt);
		var trUpdate = function () {
			var r = tr.getBoundingClientRect();
			var total = r.height - window.innerHeight;
			var p = total > 0 ? Math.min(1, Math.max(0, -r.top / total)) : 1;
			var on = Math.round(p * 1.15 * ws.length);
			for (var i = 0; i < ws.length; i++) ws[i].classList.toggle('on', i < on);
		};
		if (!reduce) {
			trUpdate();
			window.addEventListener('scroll', trUpdate, { passive: true });
			window.addEventListener('resize', trUpdate);
		}
	}

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
					/* Fresh nonce first: pages may be served from cache. */
					fetch(KF.ajax + '?action=kf_nonce', { credentials: 'same-origin', cache: 'no-store' })
						.then(function (r) { return r.json(); })
						.catch(function () { return null; })
						.then(function (n) {
							var fd = new FormData();
							fd.append('action', 'kf_book_log'); fd.append('nonce', (n && n.success && n.data.book) || B.nonce);
							Object.keys(payload).forEach(function (k) { if (k !== 'website_hp' && k !== 'type') fd.append(k, payload[k]); });
							return fetch(KF.ajax, { method: 'POST', body: fd, credentials: 'same-origin' });
						}).catch(function () {});
					setStatus('ok', T.ok);
					if (window.dataLayer) window.dataLayer.push({ event: 'book_meeting', meeting: meeting });
					sel.hour = null; updateSum(); loadSlots(sel.date);
				})
				.catch(function () { setStatus('err', T.err, true); })
				.then(function () { bBtn.disabled = false; bLabel.textContent = T.confirm || 'Book'; });
		});
	}


	/* ---------- Extra motion ---------- */
	if (!reduce) {
		/* Hero title: letters (Latin/Cyrillic) or words (Arabic) rise in. */
		var split = $('[data-split] .hero__line');
		if (split) {
			var arabic = KF.lang === 'ar', n = 0;
			var txt0 = split.textContent.trim();
			split.textContent = '';
			txt0.split(/\s+/).forEach(function (w, wi2, arr) {
				var ws = doc.createElement('span'); ws.className = 'split-w';
				if (arabic) { ws.className = 'split-ch'; ws.style.setProperty('--i', n++ * 3); ws.textContent = w; }
				else { Array.from(w).forEach(function (ch) { var c = doc.createElement('span'); c.className = 'split-ch'; c.style.setProperty('--i', n++); c.textContent = ch; ws.appendChild(c); }); }
				split.appendChild(ws);
				if (wi2 < arr.length - 1) split.appendChild(doc.createTextNode(' '));
			});
			split.setAttribute('aria-label', txt0);
		}
		/* Section titles: words lift in. */
		$$('[data-words-in]').forEach(function (h) {
			var t = h.textContent.trim(); h.textContent = '';
			t.split(/\s+/).forEach(function (w, i, arr) {
				var sp = doc.createElement('span'); sp.className = 'wi'; sp.style.setProperty('--i', i); sp.textContent = w;
				h.appendChild(sp); if (i < arr.length - 1) h.appendChild(doc.createTextNode(' '));
			});
			io.observe(h);
		});
		/* Cursor glow in the hero. */
		var hero = $('.hero'), glow = $('[data-glow]');
		if (hero && glow && finePointer) {
			hero.addEventListener('pointermove', function (e) {
				var r = hero.getBoundingClientRect();
				glow.style.setProperty('--gx', (e.clientX - r.left) + 'px');
				glow.style.setProperty('--gy', (e.clientY - r.top) + 'px');
			});
		}
		/* 3D tilt. */
		if (finePointer) {
			$$('.card, .value, .feature, .sibling, .post-card, .sector-card, .step, .mv__card, .which__row').forEach(function (el) {
				el.setAttribute('data-tilt', '');
				el.addEventListener('pointermove', function (e) {
					var r = el.getBoundingClientRect();
					var px = (e.clientX - r.left) / r.width - 0.5, py = (e.clientY - r.top) / r.height - 0.5;
					var k = el.classList.contains('card') ? 4 : 7;
					el.style.setProperty('--rx', (-py * k).toFixed(2) + 'deg');
					el.style.setProperty('--ry', (px * k).toFixed(2) + 'deg');
				});
				el.addEventListener('pointerleave', function () { el.style.setProperty('--rx', '0deg'); el.style.setProperty('--ry', '0deg'); });
			});
		}
		/* Click ripple on buttons. */
		doc.addEventListener('pointerdown', function (e) {
			var b = e.target.closest('.btn, .dock__btn, .day, .slot, .filters a');
			if (!b) return;
			var r = b.getBoundingClientRect(), d = Math.max(r.width, r.height);
			var rp = doc.createElement('span'); rp.className = 'ripple';
			rp.style.cssText = 'width:' + d + 'px;height:' + d + 'px;left:' + (e.clientX - r.left - d / 2) + 'px;top:' + (e.clientY - r.top - d / 2) + 'px';
			if (getComputedStyle(b).position === 'static') b.style.position = 'relative';
			b.style.overflow = 'hidden';
			b.appendChild(rp);
			setTimeout(function () { rp.remove(); }, 650);
		});
	}

	/* ---------- v1.4 motion ---------- */
	if (!reduce) {
		/* Auto-stagger grid children that reveal. */
		$$('.bento, .values, .features, .posts, .sector-cards, .siblings, .steps, .stages, .which, .sectors, .stats, .faq').forEach(function (g) {
			$$(':scope > .reveal, :scope > li.reveal, :scope > * > .reveal', g).forEach(function (el, i) {
				if (!el.style.getPropertyValue('--d')) el.style.setProperty('--d', (Math.min(i, 8) * 0.07) + 's');
			});
		});
		/* Floating icon offsets. */
		$$('.value__icon, .dd__ico, .beams__icon, .contact__ico').forEach(function (el, i) { el.style.setProperty('--fi', i % 5); });
		/* Lists cascade in. */
		$$('.ticks, .chips-list, .pains, .footer ul, .book__agenda, .markets').forEach(function (ul) {
			ul.classList.add('cascade');
			Array.prototype.forEach.call(ul.children, function (li, i) { li.style.setProperty('--ci', i); });
			io.observe(ul);
		});
		/* Inner page h1 underline sweep. */
		$$('.phero .h1').forEach(function (h) { io.observe(h); });
		/* Typed eyebrow on inner heroes. */
		$$('.phero .eyebrow').slice(0, 1).forEach(function (el) {
			var full = el.textContent.trim(); if (!full || full.length > 60) return;
			el.textContent = ''; el.classList.add('typed');
			var k = 0, tick = function () { k++; el.textContent = full.slice(0, k); if (k < full.length) setTimeout(tick, 38); else el.classList.add('done'); };
			setTimeout(tick, 350);
		});
		/* Mouse spotlight inside sections. */
		if (finePointer) {
			$$('.section').forEach(function (sec) {
				if (sec.classList.contains('section--flow') || sec.classList.contains('section--sectors')) return;
				sec.setAttribute('data-spot', '');
				sec.addEventListener('pointermove', function (e) {
					var r = sec.getBoundingClientRect();
					sec.style.setProperty('--sx', (e.clientX - r.left) + 'px');
					sec.style.setProperty('--sy', (e.clientY - r.top) + 'px');
				});
			});
			/* Cursor ring. */
			var cur = doc.createElement('div'); cur.className = 'cursor'; cur.setAttribute('aria-hidden', 'true'); doc.body.appendChild(cur);
			doc.addEventListener('pointermove', function (e) {
				cur.style.setProperty('--cx', e.clientX + 'px'); cur.style.setProperty('--cy', e.clientY + 'px');
				cur.classList.toggle('is-link', !!e.target.closest('a, button, summary, label, [role="radio"]'));
			}, { passive: true });
			doc.addEventListener('pointerdown', function () { cur.classList.add('is-down'); });
			doc.addEventListener('pointerup', function () { cur.classList.remove('is-down'); });
			doc.addEventListener('pointerleave', function () { cur.style.setProperty('--cx', '-100px'); });
		}
		/* Count-up for any big number that scrolls in again after theme change is handled by ticker. */
	}

	/* RTL marker for any script that needs it */
	if (rtl) root.classList.add('is-rtl');
})();
