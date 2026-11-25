# Changelog

## 1.4.3 — 2026-11-25

Live review of kefamily.online (192 URLs crawled from the browser):
- 0 broken links, 0 duplicate titles, canonical + hreflang on every page,
  no noindex, no old staging URLs, valid JSON-LD; median response 71 ms.
- Terms page meta descriptions were too short (EN/AR/RU) — rewritten.
- Under ~24 simultaneous uncached requests the shared host returned
  "Database Error" (MySQL connection limit). Turned on Hostinger's server
  page cache (free, auto-cleared every 30 min) so traffic spikes are served
  from cache.
- Because pages can now be cached, the booking flow fetches a fresh nonce
  before logging the lead (same as the contact form already did).

## 1.4.2 — 2026-11-25

- Alternating section bands: every second section sits on a distinct
  surface (dark #11111a / light #eceef4) with hairline borders and a moving
  brand line on top; cards on a band use the base colour so they still
  stand out. The manifesto fades into its own band.
- Mobile: nav bar turns almost opaque when scrolled (text no longer shows
  through), manifesto is a normal block on phones (no long empty sticky
  area), larger tag tap targets.
- Live on kefamily.online (domain connected in hPanel, sitemap submitted).

## 1.4.0 — 2026-11-25

Blog
- 22 new articles, so every category has five: KeFamily, KePixel, KeMarq,
  KeChat and KeClinic — each in English, Arabic, Russian and German
  (100 article URLs). Seeded once from inc/articles/*.json (seed v3, with a
  lock so two visitors can't seed twice); editable in wp-admin afterwards.
- Every article links contextually to the matching pages on kepixel.online,
  kemarq.net (same language) and kechat.online, and to KeFamily company pages
  and sibling articles. All external URLs were checked (200).
- Related articles prefer the same category; KeFamily-topic cards get a tag.
- Sitemap: 192 URLs. Local audit: 0 issues, 0 broken links.

Motion
- Page-to-page view transitions, nav drop-in, 3D rise-in for cards with
  automatic stagger, cascading lists, brand-colour underline sweep on
  headings, floating icons, spinning gradient border on hovered cards,
  drawn underlines and nudging arrows on links, drifting orbs in page
  heroes, mouse spotlight in sections, cursor ring on desktop, typed
  eyebrow on inner pages. Fixed: card tilt was cancelled by the reveal
  transform; the primary button shine keyframes were being overridden.

## 1.3.1 — 2026-11-25

Mobile review (390px, EN/AR/RU/DE, light + dark, menu and chat panel open):
- Home hero on phones: headline and buttons first, orbit below (was pushing
  the title under the fold).
- Floating dock hides while the closing CTA or the footer is on screen (they
  carry the same buttons), so it never covers them; smaller pulse ring.
- Footer links in two columns on phones, extra bottom space; tighter section
  spacing; 44px+ tap targets for text links and FAQ rows.
- Product screens: shorter event rows on phones; select fields styled like
  inputs; booking "Confirm" button uses the primary style; plan badges no
  longer stretch.

## 1.3.0 — 2026-11-25

- Back to the v1.1 look (orbit hero, particles, aurora, marquee, bento cards
  with live product screens, beams, retro-grid CTA) at Mostafa's request,
  keeping everything added in 1.2: 4 languages, official logos, /book/,
  WhatsApp + meeting dock, blog, SEO.
- More motion: scroll progress bar in the four brand colours, hero title
  letters rise in (words in Arabic), section titles lift in word by word,
  cursor glow in the hero, orbit parallax, 3D tilt on cards, click ripple,
  pulsing WhatsApp button, animated slots/days in booking, sweeping brand
  line on alternate sections, animated chat panel. All off under
  prefers-reduced-motion.
- Light is still the default mode.

## 1.2.0 — 2026-11-25

Design (editorial direction, see docs/DESIGN.md)
- Rebuilt the visual language: white-led Swiss editorial layout, hairlines,
  numbered sections, monumental type (Manrope; Readex Pro for Arabic).
- Removed decorative noise: particles, aurora, marquee, meteors, retro grid,
  spotlight/beam borders, blur reveals, shimmer buttons.
- Home: monumental hero with brand-coloured rotator (height reserved, no
  layout shift), numbered company index, ecosystem diagram, facts row,
  inverted manifesto, industries list, values, latest articles, FAQ,
  monumental inverted CTA.
- Official logo artwork (KeFamily light/dark, KeClinic light/dark, app
  icons); favicons + apple-touch icon; new OG image.
- Light is the default mode; dark is a remembered user choice.

Languages
- English (primary, at /), Arabic (/ar/), Russian (/ru/), German (/de/).
  Full RU/DE copy in inc/lang/*.json. Language switcher in nav, mobile menu
  and footer. Old ?lang=en URLs 301 to the new paths.
- hreflang en/ar/ru/de + x-default, og:locale per language, html lang/dir.

New
- /book/: meeting booking like kemarq.net — Google Meet or WhatsApp call,
  next 10 working days, live free slots (Riyadh time), confirmation through
  the same Google Apps Script endpoint (Customizer setting); every booking
  is also saved as a Lead in wp-admin + emailed.
- Floating dock on every page: "Book a meeting" + WhatsApp chat panel with
  greeting and topic shortcuts that open WhatsApp with a prefilled message.
- Blog: /blog/ (topic filters, pagination), /blog/{slug}/ articles with
  reading time, translations, related posts, BlogPosting schema; posts get
  a language/slug/topic box in the editor. 3 starter articles × 4 languages.
- Sitemap: 23 routes × 4 languages + every article (104 URLs).

## 1.1.0 — 2026-11-25

Brand & identity
- Real brand colours taken from each live site: KePixel blue #2367F2,
  KeMarq purple #8247DB, KeChat green #25D366, KeClinic yellow #FACC15.
- KeFamily itself is now white/neutral: new mark (four family tiles in the
  family colour around a heart holding the four brand colours), white
  primary buttons, neutral glows. Brand colours appear only in brand
  contexts; the hero word rotator switches to each brand's colour.
- Light + dark mode (follows the system, toggle in the nav, remembered).

Pages (21 routes × Arabic/English = 42 URLs)
- New: /companies/, /solutions/ + six industry pages, /how-it-works/,
  /careers/, /partners/, /faq/, /privacy-policy/, /terms/.
- Router (`inc/routes.php`) drives URLs, titles, descriptions,
  breadcrumbs and the sitemap from one table.
- Navigation with Companies/Solutions dropdowns; full mobile menu; footer
  links to every page.

Technical SEO
- Unique title/description per URL, canonical, hreflang (ar/en/x-default),
  OG/Twitter, Organization + WebSite + BreadcrumbList + Service + FAQPage
  schema, visible breadcrumbs, one H1 and no heading skips on every page,
  all 42 URLs in the XML sitemap; audited locally with 0 issues.

## 1.0.3 — 2026-11-25

- KeClinic brand colour changed to yellow (#FACC15) everywhere: card,
  company page, logo mark, favicon, OG image, gradients, particles.
- Nav offset below the WordPress admin bar for logged-in editors.

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
