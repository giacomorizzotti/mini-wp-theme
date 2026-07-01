# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repo is

The canonical "mini" WordPress parent theme — a minimal theme built on the mini framework's vanilla CSS/JS (`/home/projects/mini/css/`, `/home/projects/mini/js/`), with template support for several custom post types (events, courses, lessons, matches, news, slides) and a block-pattern library.

## Deployment topology — check this before editing anything

**This repo is symlinked into multiple live WordPress installs; it is not edited in place per-site.**

- Canonical source: `/home/projects/mini/wp/mini-theme/` (this repo).
- Symlinked as `wp-content/themes/mini-theme` in `uwa/wp` and as `wp-content/themes/mini` in the methodos site — **single source of truth, edit once here, changes are live everywhere immediately** (same inode, not a copy).
- `micro/` (inside this repo) is the **child-theme starter kit** — itself symlinked as `wp-content/themes/micro` in `uwa/wp` only. Edit here for changes meant to propagate to future child themes built from this starter.
- `/home/projects/uwa/dev/methodos/website/wp-content/themes/methodos/` is a **real, non-symlinked fork** of `micro` for one specific site. It does **not** auto-sync — changes to `micro` must be manually ported into `methodos` if they should apply there, while preserving methodos's own divergences (e.g. its own header.php with extra branding, its own functions.php).

Before editing, run `ls -la` (or `readlink -f`) on the target path to confirm whether you're looking at this canonical source, the `micro` starter, or a divergent real copy like `methodos`. Don't bother manually "syncing" the plugin/parent-theme symlink paths — they're the same file already.

**Default scope:** when a request is about one specific site (e.g. "my Methodos project"), implement it as a site-local override there, not as a change to this canonical theme/`micro` — even a backward-compatible one. Promoting a site-specific feature to the shared theme is a separate, deliberate decision made later, not a default.

## Customizing for a new WordPress instance: two systems, pick by scope

This theme documents its own decision tree for this (`CUSTOMIZATION-GUIDE.md`, `QUICK-REFERENCE.md`) — summary:

- **Override system** (`overrides/`) — for 1-5 small changes (a few CSS tweaks, a handful of custom functions). Copy `overrides/styles/custom.example.css` → `custom.css` and edit; same pattern for `overrides/custom-functions.example.php`, `overrides/templates/`, `overrides/parts/`, `overrides/patterns/`. No new theme needed.
- **Child theme** (`micro/`) — for structural changes, custom post types, or any client site getting 10+ changes: `cp -r micro ../mini-yoursite`, edit `style.css`'s theme metadata, activate. See `micro/README.md` / `micro/QUICKSTART.md`.

## Commands

```bash
npm run watch          # node-sass sass/ -> root, watch mode, with source maps
npm run compile:css    # one-off compile + stylelint --fix
npm run compile:rtl    # rtlcss style.css -> style-rtl.css
npm run lint:scss      # wp-scripts lint-style sass/**/*.scss
npm run lint:js        # wp-scripts lint-js js/*.js
composer run lint:wpcs # PHP CodeSniffer, WordPress coding standards
composer run lint:php  # parallel-lint across the theme
composer run make-pot  # wp i18n make-pot . languages/_s.pot
```

CSS source of truth is `sass/` — compiled output (`style.css`, `style.css.map`, `style-rtl.css`) is checked in and must be regenerated via the above, not edited directly.

## Structure

- `functions.php` + `inc/` — theme setup split by concern: `enqueue.php` (asset loading, including the CDN-vs-local mini.css/mini.js toggle — see `mini_cdn_options` in `functions.php`), `customizer.php`, `custom-header.php`, `custom-logo.php`, `cpt-archive-pages.php`, `shortcodes.php`, `template-functions.php`, `template-tags.php`, `meta-boxes.php`, `jetpack.php`, `admin-customization.php`, `blocks-settings.php`, `contact-form-fields.php`, `override.php` (loads the `overrides/` system above).
- `header.php`/`footer.php`/`sidebar*.php` — global chrome. `header.php` is also where mini.css custom-property overrides get injected per WordPress Customizer settings (`mini_css_variable()` calls for `--info`/`--success`/`--warning`/`--danger`/`--bad`/etc.) — that's how site admins recolor the mini palette without touching CSS.
- `single-*.php`/`archive-*.php`/`sidebar-*.php` per custom post type (course, event, lesson, match, news, landing_page) — template + archive + sidebar variant for each.
- `template-parts/` — reusable partials (`content-*.php` per post type, `contact-form*.php`).
- `blocks/` — custom Gutenberg block patterns.
- `micro/` — child-theme starter kit, see topology note above.
- `overrides/` — per-site override system, see customization note above.
