# mini

A minimal, flexible WordPress theme built on the mini framework. Licensed under GPLv2 or later.

## Setup

### Requirements

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

### Install dependencies

```sh
composer install
npm install
```

## Available CLI commands

- `composer lint:wpcs` — checks all PHP files against [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- `composer lint:php` — checks all PHP files for syntax errors.
- `composer make-pot` — generates a .pot file in the `languages/` directory.
- `npm run compile:css` — compiles SASS files to css.
- `npm run compile:rtl` — generates an RTL stylesheet.
- `npm run watch` — watches all SASS files and recompiles them to css when they change.
- `npm run lint:scss` — checks all SASS files against [CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/).
- `npm run lint:js` — checks all JavaScript files against [JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/).
- `npm run bundle` — generates a .zip archive for distribution, excluding development and system files.

## 🎯 Instance Customization - Two Approaches

This theme provides **two flexible ways** to customize for different WordPress instances:

### 1️⃣ Override System (Quick & Simple)
For minor tweaks and small customizations:
```bash
# Copy example files and edit
cp overrides/styles/custom.example.css overrides/styles/custom.css
# Add your customizations - done!
```

### 2️⃣ Child Theme (Full Customization)
For major changes and client sites:
```bash
# Copy the starter kit
cp -r micro ../mini-yoursite
# Edit style.css and activate in WordPress
```

### 🤔 Which Should I Use?

- **Override System** → 1-5 changes, mostly CSS/minor tweaks, quick deployment
- **Child Theme** → 10+ changes, custom post types, client sites, extensive rebrand

**📚 Decision Guide:** See [CUSTOMIZATION-GUIDE.md](CUSTOMIZATION-GUIDE.md) for detailed comparison and use cases

**Documentation:**
- [Customization Strategy Guide](CUSTOMIZATION-GUIDE.md) ⭐ Start here!
- [Override System](overrides/README.md) | [Quick Start](overrides/QUICKSTART.md)
- [Child Theme](micro/README.md) | [Quick Deploy](micro/QUICKSTART.md)

Both approaches keep your parent theme clean and updateable!
