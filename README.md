# KeFamily — WordPress theme

Official website theme for **KeFamily**, the parent company of
[KePixel](https://kepixel.online), [KeMarq](https://kemarq.net),
[KeChat](https://kechat.online) and KeClinic.

- Bilingual: Arabic (RTL, default) and English (`?lang=en`).
- No page builder, no jQuery, no external requests: fonts are self-hosted.
- Animated effects re-implemented in vanilla CSS/JS after open-source
  patterns from **Magic UI**, **Animate UI** and **Uiverse** (all MIT):
  shimmer button, border beam, orbiting circles, animated beams, marquee,
  magic-card spotlight, number ticker, word rotate, scroll text reveal,
  retro grid, meteors, particles, aurora / shiny text.
- All `prefers-reduced-motion` users get a static version.

## Structure

```
style.css               theme header
functions.php           bootstrap
inc/content.php         ALL site copy (Arabic + English) — edit text here
inc/helpers.php         language + URL helpers
inc/setup.php           assets, routing (/companies/{slug}/), activation
inc/seo.php             titles, meta, OG, hreflang, JSON-LD, staging noindex
inc/contact.php         contact form → "KeFamily Leads" in wp-admin + email
inc/customizer.php      WhatsApp, leads email, KeClinic URL, socials
inc/icons.php           inline SVG icons + logo
front-page.php          home
company.php             /companies/kepixel|kemarq|kechat|keclinic/
page-about.php          /about/
page-contact.php        /contact/
template-parts/         card visuals, animated beams, CTA
assets/                 css, js, fonts, images
```

## Editing content

- **Text** (both languages): `inc/content.php`.
- **WhatsApp number, leads email, KeClinic URL, social links**:
  wp-admin → Appearance → Customize → *KeFamily — Business details*.
- **Leads**: wp-admin → *KeFamily Leads* (every submission is stored there
  even if email delivery fails). Integrations can hook `kf_lead_created`.

## Deploy

See [`docs/DEPLOY.md`](docs/DEPLOY.md). Short version: every push to
`main` is deployed by Hostinger Git to
`public_html/wp-content/themes/kefamily` on the **staging** site
(`annual-cyan-antelope-31.hostingersite.com`). Staging hosts are
automatically `noindex, nofollow`.

## Change log

See [`CHANGELOG.md`](CHANGELOG.md).
