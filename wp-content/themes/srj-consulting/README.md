# SRJ Consulting WordPress Theme

**Version:** 1.0.0
**Type:** Kadence child theme
**Domain:** aiauditforcompanies.com
**Hosting:** GoDaddy Ultimate Managed WordPress

---

## What is included

A complete, production-ready WordPress child theme that renders the 15-page SRJ Consulting site with custom locked-in PHP templates.

```
srj-consulting/
├── style.css                   (theme metadata header)
├── functions.php               (theme setup, customizer, page auto-create)
├── header.php                  (announce bar + nav, shared by every page)
├── footer.php                  (footer + floating CTA, shared by every page)
├── front-page.php              (homepage)
├── home.php                    (Insights blog archive)
├── single.php                  (individual blog post)
├── page.php                    (default page fallback)
├── index.php                   (WordPress required fallback)
├── 404.php                     (not found page)
├── search.php                  (search results)
├── page-about.php              (About page)
├── page-services.php           (Services landing)
├── page-ai-business-enablement-audit.php
├── page-ai-readiness-performance.php
├── page-ai-risk-governance-review.php
├── page-ai-efficiency-process.php
├── page-ai-it-security-audit.php
├── page-ai-security-implementation.php
├── page-industries.php
├── page-contact.php
├── page-privacy.php
├── page-terms.php
├── inc/
│   ├── customizer.php          (Phone/Email/Calendly/Address settings)
│   ├── helpers.php             (shared template helper functions)
│   └── service-helpers.php     (service detail sidebar renderer)
├── assets/
│   ├── css/style.css           (full theme stylesheet)
│   └── js/theme.js             (floating CTA scroll behavior)
└── screenshot.png              (preview image for theme picker)
```

**21 PHP files + assets + screenshot.** Approximately 70 KB compressed.

---

## Installation: 6 steps, ~10 minutes

### Step 1: Create your staging site
- GoDaddy → Hosting → Hosting Settings → Staging Site → **Create**
- Wait 5-10 minutes for staging to spin up
- All steps below should be done in staging first

### Step 2: Install Kadence (parent theme)
- WordPress admin → Appearance → Themes → Add New
- Search: **Kadence**
- Install the theme by Kadence WP
- **Do NOT activate yet**

### Step 3: Upload and activate the SRJ Consulting child theme
- WordPress admin → Appearance → Themes → Add New → **Upload Theme**
- Choose `srj-consulting.zip` (the file you downloaded with this README)
- Click **Install Now**
- After install, click **Activate**

On activation, the theme automatically:
- Creates 14 pages (Home, About, Services, the 6 service pages, Industries, Insights, Contact, Privacy, Terms)
- Sets Home as the front page
- Sets Insights as the posts page
- Sets the permalink structure to `/postname/`

### Step 4: Verify pages were created
- WordPress admin → Pages
- You should see all 14 pages listed
- Click on a few. They have empty content, **and that is correct.** The templates render all content from PHP.

### Step 5: Configure your contact info in the Customizer
- WordPress admin → **Appearance → Customize → SRJ Contact Info**
- Verify these fields:
  - Phone Number (Display): `(415) 413-7772`
  - Phone (tel: Link Format): `+14154137772`
  - Email Address: `info@srjconsultingservices.com`
  - Calendly URL: (the long Calendly URL)
  - Office Street: `13054 Cinderella Ln`
  - Office City/State: `Frisco, TX`
- Click **Publish** when done

If you ever change your phone number, email, or Calendly URL, this is where you update it. Changes propagate to every page on the site automatically.

### Step 6: Set up Rank Math (SEO)
- WordPress admin → Plugins → Add New
- Search: **Rank Math SEO**
- Install the free version and activate
- Run the setup wizard, picking these answers:
  - Site type: **Personal blog / portfolio** or **Small business site**
  - Company name: **SRJ Consulting & Services**
  - Logo: skip for now (add later)
  - Default social image: skip for now
  - Connect Google Search Console: yes (recommended)
- Done. The theme already outputs proper meta tags and JSON-LD structured data, so Rank Math is mainly handling sitemap and Google Search Console integration.

---

## How to write your first blog post

The Insights archive pulls from standard WordPress Posts.

1. WordPress admin → **Posts → Add New**
2. Write your title and body
3. In the right sidebar, set:
   - **Category** (e.g. "Leadership", "Governance", "Security", "Framework")
   - **Excerpt** — write a 2-3 sentence summary. This shows up on the Insights archive and home page.
4. Click **Publish**

The post automatically appears:
- On the homepage Insights section (top 3 most recent)
- On the Insights archive page (all posts, paginated)
- At its own URL: `/your-post-slug/`

---

## Customizer settings you can edit

**Appearance → Customize → SRJ Contact Info** controls the following globally:

| Setting | Where it appears |
|---------|------------------|
| Phone (Display) | Announce bar, hero, inline CTAs, final CTA, footer, contact page |
| Phone (tel: format) | All click-to-call links |
| Email | Announce bar, final CTA, footer, contact page |
| Calendly URL | Every "Schedule a Free AI Consultation" button (8+ per page) |
| Office address | Footer, contact page |
| Short location | Announce bar |

---

## The page templates and how to edit content

For the **locked-in templates** approach you chose, page content is rendered directly from PHP templates, not from the WordPress page editor. This means:

- **To change marketing copy** (hero text, service descriptions, about page narrative), edit the relevant `.php` file via SFTP or the WordPress theme file editor (Appearance → Theme File Editor)
- **To change phone, email, Calendly URL, address**, use the Customizer (no code)
- **To publish blog posts**, use the regular WordPress Posts editor

Each page template file is well-commented and uses ordinary HTML with PHP for the dynamic bits. If you're comfortable editing HTML, you can edit any page yourself.

If you want to make a section editable through the WordPress editor (so you don't have to touch code), let me know and I'll add Advanced Custom Fields support for that section.

---

## SFTP upload alternative (if zip upload fails)

If the zip is too large for the WordPress admin upload (rare for this size, but possible on restrictive hosts):

1. Use your SFTP credentials from GoDaddy:
   - Host: `u92.6d3.myftpupload.com` (from your hosting settings)
   - Username and password from the SSH/SFTP login panel
2. Connect with FileZilla or similar SFTP client
3. Navigate to `/wp-content/themes/`
4. Upload the entire `srj-consulting/` folder
5. Then go to Appearance → Themes in WordPress and activate it

---

## Push from staging to production

Once you have reviewed the staging site thoroughly:

1. GoDaddy → Hosting → Hosting Settings → Staging Site → Actions → **Push to Production**
2. Confirm
3. The production site updates with all theme files, plugins, page content, and customizer settings from staging

---

## Domain configuration

Once the site is on production and working:

### Point aiauditforcompanies.com to GoDaddy
- If the domain is already registered at GoDaddy: nothing to do beyond making sure the domain is attached to this hosting plan
- If registered elsewhere: update nameservers to GoDaddy's

### Set up 301 redirect from srjconsultingservices.com
- Log into GoDaddy DNS for srjconsultingservices.com
- Set up a **301 permanent redirect** (not a frame forward) to `https://aiauditforcompanies.com`
- This preserves SEO equity from your old domain

### Submit sitemap to Google
- Rank Math will have generated `https://aiauditforcompanies.com/sitemap_index.xml`
- Google Search Console → Sitemaps → submit that URL

### Submit to Bing
- Bing Webmaster Tools → submit the same sitemap URL

### Set up robots.txt
- The theme does NOT include a robots.txt file because WordPress auto-generates one
- Rank Math has a robots.txt editor (Rank Math → General Settings → Edit robots.txt)
- Paste the contents of the `robots.txt` file from the original site package (with the AI bot allow/block rules)

---

## SEO checklist (already built into the theme)

✅ Title tag dynamically set from WordPress page title
✅ Meta description from page excerpt or fallback
✅ Canonical URLs on every page
✅ Open Graph + Twitter Card meta tags (clean social previews)
✅ JSON-LD ProfessionalService schema on homepage
✅ Semantic HTML (proper h1 → h2 → h3 hierarchy)
✅ Mobile responsive
✅ Fast loading (minimal JS, no bloat)
✅ Clean URL structure (`/services/ai-business-enablement-audit/`)
✅ Image alt support (when you add images)

**After install, configure Rank Math for:**
- Sitemap generation
- Google Search Console connection
- robots.txt editing

---

## Troubleshooting

**"The pages were not auto-created on activation."**
- Go to WordPress admin → Tools → Site Health → check for any issues
- Then deactivate and reactivate the theme; the auto-create logic runs on activation
- If still no pages, you can create them manually with the slugs listed in the README

**"The homepage is showing the wrong template."**
- WordPress admin → Settings → Reading
- Set "Your homepage displays" to "A static page"
- Set "Homepage" to the page titled "Home"
- Set "Posts page" to the page titled "Insights"
- Save

**"The service detail pages are showing the default template."**
- The templates are named `page-{slug}.php` and WordPress auto-matches them by page slug
- Make sure each service page has the correct slug (e.g. "ai-business-enablement-audit")
- WordPress admin → Pages → click the page → check the URL/slug

**"The styling looks broken."**
- Hard refresh the browser (Cmd+Shift+R / Ctrl+F5)
- Check Appearance → Themes that both Kadence (parent) and SRJ Consulting (child) are installed
- Check that the child theme is the active one

---

## What's still TODO after install

These items are not blocking but worth doing once live:

1. **Write real blog posts** (the home and Insights pages show placeholders if no posts exist yet)
2. **Add a custom favicon** (Appearance → Customize → Site Identity)
3. **Connect Google Analytics 4** (via Rank Math or a separate plugin)
4. **Set up a contact form** if you want one (Contact Form 7 or WPForms)
5. **Review and adjust Privacy and Terms** with a lawyer
6. **Push staging to production** after thorough review

---

## Questions?

If anything doesn't look right after install, send me a screenshot and the URL you're looking at. Most issues are either Settings → Reading config or a cache that needs flushing.
