# SRJ Website

Source of truth for the `srjconsultingservices.com` custom theme, SRJ mu-plugins,
and the two hand-authored crawler files.

Private repo. The AI Governance config is practice IP.

---

## What is tracked

| Path | What |
|---|---|
| `wp-content/themes/srj-consulting/` | The whole child theme, including `inc/ai-governance-config.php` |
| `wp-content/mu-plugins/srj-*.php` | Our must-use plugins only |
| `robots.txt`, `llms.txt` | Hand-authored, physical files at web root |
| `deploy.ps1` | Deployment script |

**Not tracked:** WordPress core, third-party plugins, the Kadence parent theme,
uploads, `wp-config.php`, host mu-plugins (GoDaddy, Object Cache Pro), and any
file containing a key.

---

## First-time setup

```powershell
git clone git@github.com:<you>/srj-website.git C:\SRJ\srj-website
cd C:\SRJ\srj-website
```

Then open `deploy.ps1` and fill in the four `TODO` values in the `$Servers`
block: production SSH host and user, staging SSH user.

Confirm OpenSSH is present, it ships with Windows 10 and 11:

```powershell
ssh -V
scp
```

Set up key auth once so deploys do not prompt for a password:

```powershell
ssh-keygen -t ed25519 -C "srj-deploy"
type $env:USERPROFILE\.ssh\id_ed25519.pub | ssh USER@HOST "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"
```

---

## Deploying

Staging first. Always.

```powershell
# See what would change, write nothing
.\deploy.ps1 -Path wp-content/themes/srj-consulting/footer.php -DryRun

# Push one file to staging
.\deploy.ps1 -Path wp-content/themes/srj-consulting/footer.php

# Push to production (prompts for confirmation)
.\deploy.ps1 -Target production -Path wp-content/themes/srj-consulting/footer.php

# Push everything tracked
.\deploy.ps1 -Target staging -All
```

### What the script refuses to send

These guards exist because each one has already caused a live incident.

1. **Browser `(n)` filenames.** On July 20 2026 a file named
   `ai-governance-config (1).php` was uploaded as the live config. It contained
   3 of 27 category entries. Most of the AI Governance library went down.
2. **Backups**, `.old` `.bak` `.orig` `.rej`.
3. **Secrets**, `wp-config.php`, `.env`, `.pem`, `.key`.
4. **Host-owned mu-plugins.** Only `srj-*` files are ours.
5. **PHP files that fail `php -l`**, when PHP is on PATH locally.

### Post-transfer size verification

After every transfer the script reads the byte size of each file on the server
and compares it to local. A mismatch is reported loudly and you are told not to
flush cache until it is understood.

The same July 20 outage would have been caught here instantly: 990 KB expected,
69 KB delivered.

---

## After deploying

1. Flush the GoDaddy cache from the WP admin bar. It cascades to the edge.
2. If a config-driven page changed (AI Governance, AI Tools, Glossary),
   rebuild the Relevanssi index: **Settings > Relevanssi > Build the index**.
   Skipping this means search only matches page titles for the changed pages.
3. If a page URL changed, update `llms.txt` in the same pass.
4. Verify on the live URL, not by curl. The Sucuri WAF challenges automated
   fetches.

---

## Templates and the router

This host's template registry is dead: `get_page_templates()` returns 0, so the
Page Attributes dropdown is always empty and `_wp_page_template` is never set.

The `srj-universal-template-router` mu-plugin resolves templates by **filename
match on the page slug** and by **page ancestry**. So a page at `/resources/`
renders from `page-resources.php` with no template assignment anywhere.

To debug routing, append `?srj_route_debug=1` to any URL while logged in as
admin. The `ROUTE:` line tells you which rule matched.

---

## Database-backed pages

Two pages render from custom MySQL tables rather than the config:

| Page | Table | Admin |
|---|---|---|
| `/ai-governance/ai-tools/` | `{prefix}_srj_ai_tools` | Tools > AI Tools Inventory |
| `/resources/ai-glossary/` | `{prefix}_srj_glossary` | Tools > AI Glossary |

Both import from a seed file in `mu-plugins/`, manually, from the admin screen.
Imports upsert and never overwrite operational or editorial columns, so
re-importing refreshes content without destroying hand edits.

The AI Tools page keeps the static config HTML as an automatic fallback: if the
table is empty or the plugin is removed, the page renders exactly as before.

---

## Branching

`main` is what is deployed. For anything that touches more than one file, branch,
deploy the branch to staging, verify, then merge and deploy production.

```powershell
git switch -c feature/whatever
# work, commit
.\deploy.ps1 -Target staging -All
# verify on staging, then
git switch main; git merge feature/whatever
.\deploy.ps1 -Target production -All
```

---

## Rules that predate this repo and still apply

- The Kadence parent theme is never edited.
- Bump `SRJ_VERSION` in `functions.php` whenever CSS or JS changes.
- New page styles go in a stylesheet, not inline in PHP.
- Every new tracking script must be declared to Complianz before it ships.
- Never leave known-incorrect content live. Correct it and log it.
