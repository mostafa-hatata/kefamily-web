# Deployment

## Environments

| Environment | Host | Notes |
|---|---|---|
| Staging | `annual-cyan-antelope-31.hostingersite.com` | Auto-deploy from `main`. Always `noindex`. |
| Production | `kefamily.online` | Not live yet. Promote only after staging review. |

## How deploys work

1. Hostinger hPanel → Website → Advanced → **GIT** is connected to this
   repository (branch `main`), install path
   `public_html/wp-content/themes/kefamily`.
2. Auto-deployment webhook is enabled, so every push to `main` deploys.
3. CI (`.github/workflows/ci.yml`) lints PHP + JS on every push and
   builds an installable `kefamily.zip` artifact (useful for a manual
   upload via Appearance → Themes → Add New → Upload).

## After the first deploy

- Activate the theme: Appearance → Themes → **KeFamily**.
  Activation creates the `About` and `Contact` pages, sets permalinks to
  `/%postname%/` and flushes rewrite rules.
- Fill Appearance → Customize → *KeFamily — Business details*.
- If the LiteSpeed Cache plugin is active, purge all after each deploy.

## Rollback

Revert the commit on `main` and push — Hostinger redeploys the previous
version. Or download a previous CI `kefamily.zip` artifact and upload it.

## Going live on kefamily.online (later)

1. Point the domain to the production site in hPanel.
2. Connect the same repo (branch `main` or a `production` branch).
3. The theme drops `noindex` automatically on non-staging hosts.
4. Submit `https://kefamily.online/wp-sitemap.xml` in Search Console.
