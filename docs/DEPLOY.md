# Deployment

## Environments

| Environment | Host | Notes |
|---|---|---|
| Staging | `annual-cyan-antelope-31.hostingersite.com` | Auto-deploy from `main`. Always `noindex`. |
| Production | `kefamily.online` | Not live yet. Promote only after staging review. |

## How deploys work

Hostinger's built-in "Connect with GitHub" is disabled while the hosting
account is managed through *Admin access*, so deploys run from GitHub
Actions over SSH instead:

1. hPanel → Advanced → **SSH Access** is enabled and holds the public key
   `github-actions-kefamily-web`.
2. The private half is stored in the repo secret **`HOSTINGER_SSH_KEY`**
   (Settings → Secrets and variables → Actions).
3. `.github/workflows/deploy-staging.yml` runs on every push to `main`:
   PHP lint → backup of the current theme on the server
   (`~/kefamily-backups/`, last 10 kept) → `rsync` to
   `public_html/wp-content/themes/kefamily` → smoke test of every page
   (fails the run on any non-200 or PHP error).
4. `.github/workflows/ci.yml` lints PHP + JS and builds an installable
   `kefamily.zip` artifact on every push.

## After the first deploy

- Activate the theme: Appearance → Themes → **KeFamily**.
  Activation creates the `About` and `Contact` pages, sets permalinks to
  `/%postname%/` and flushes rewrite rules.
- Fill Appearance → Customize → *KeFamily — Business details*.
- If the LiteSpeed Cache plugin is active, purge all after each deploy.

## Rollback

Revert the commit on `main` and push — the workflow redeploys the previous
version. Server-side backups of every previous deploy are in
`~/kefamily-backups/`. A CI `kefamily.zip` artifact can also be uploaded
manually from Appearance → Themes.

## Going live on kefamily.online (later)

1. Point the domain to the production site in hPanel.
2. Add a `deploy-production.yml` workflow (copy of staging with the
   production path) triggered from a `production` branch.
3. The theme drops `noindex` automatically on non-staging hosts.
4. Submit `https://kefamily.online/wp-sitemap.xml` in Search Console.
