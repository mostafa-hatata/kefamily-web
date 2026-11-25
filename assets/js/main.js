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
	var wa = $('.wa-float');
	var onScroll = function () {
		var y = window.scrollY;
		if (nav) nav.classList.toggle('is-scrolled', y > 24);
		if (wa) wa.classList.toggle('show', y > 640);
	};
	onScroll();
	window.addEventListener('scroll', onScroll, { passive: true });

	var burger = $('[data-burger]');
	var mmenu = $('[data-mmenu]');
	function setMenu(open) {
		if (!burger || !mmenu) return;
		burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		mmenu.hidden = !open;
		doc.body.style.overflow = open ? 'hidden' : '';
	}
	if (burger) {
		burger.addEventListener('click', function () { setMenu(burger.getAttribute('aria-expanded') !== 'true'); });
		$$('a', mmenu).forEach(function (a) { a.addEventListener('click', function () { setMenu(false); }); });
		doc.addEventListener('keydown', function (e) { if (e.key === 'Escape') setMenu(false); });
	}

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
	if (rot && words.length > 1 && !reduce) {
		var wi = 0;
		setInterval(function () {
			rot.classList.add('is-out');
			setTimeout(function () {
				wi = (wi + 1) % words.length;
				rot.textContent = words[wi];
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
		var colors = ['167,139,250', '255,154,107', '75,227,176', '125,211,252', '255,255,255'];
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
					c: colors[(Math.random() * colors.length) | 0]
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
		draw();
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
				lg.innerHTML = '<stop offset="0" stop-color="' + color + '"/><stop offset="1" stop-color="#c4b5fd"/>';
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

	/* RTL marker for any script that needs it */
	if (rtl) root.classList.add('is-rtl');
})();
