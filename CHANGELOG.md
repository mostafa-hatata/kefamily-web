# Changelog

## 1.0.2 — 2026-11-25

Technical SEO pass:
- XML sitemap: added the four company pages and every English URL
  (custom `kefamily` provider); removed author archives and private leads.
- Fixed heading hierarchy (no h1→h3 jumps) on company and contact pages;
  footer column titles are now h2.
- BreadcrumbList schema on inner pages; shorter, keyword-led titles for
  About/Contact; English home description trimmed to 135 characters.
- KeClinic features laid out 2×2.

## 1.0.1 — 2026-11-25

- Deploy pipeline live: GitHub Actions → SSH → staging, with server-side
  backups and post-deploy smoke tests.

## 1.0.0 — 2026-11-25

First release of the KeFamily website theme (staging).

- Home: orbiting-family hero with particles, aurora and word rotator;
  dual marquee; bento grid of the four companies with live mini-visuals,
  spotlight cards and border beams; animated-beam ecosystem; number
  ticker stats; scroll text-reveal manifesto; values; sectors; FAQ (with
  FAQPage schema); retro-grid CTA with meteors.
- Company pages `/companies/{kepixel,kemarq,kechat,keclinic}/`.
- About page with scroll-filled timeline, mission/vision and markets.
- Contact page with AJAX form → stored as private *KeFamily Leads* posts +
  email; honeypot, rate limit, fresh nonce for cached pages.
- Arabic (RTL, default) + English via `?lang=en`, hreflang, canonical,
  Open Graph image, Organization JSON-LD with sub-organizations.
- Staging hosts are forced `noindex, nofollow`.
- Self-hosted fonts (Readex Pro, Instrument Serif — OFL); no external
  requests; reduced-motion support.
