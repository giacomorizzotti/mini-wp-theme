# Mini WordPress Theme

A minimal, flexible WordPress theme built on the mini framework. Designed for modern WordPress development with support for custom post types, block patterns, and extensive customization options.

## ✨ Features

### 🎯 Custom Post Type Support
Full template support for custom content types:
- **Events** - Event management with date/time/location display
- **Courses** - Educational content with lesson organization
- **Lessons** - Individual course lessons
- **Matches** - Sports event management
- **News** - News article publishing
- **Slides** - Slideshow content management

### 🎨 Block Patterns
Pre-built layout patterns for rapid development:
- **Content Layouts**: 1-column, 2-column, 3-column, 4-column variations
- **Hero Sections**: Full-page images, background-fixed images
- **Contact Forms**: Quick contact, full contact forms
- **CTAs**: Black box CTAs, "Keep me updated" sections
- **Maps**: Integrated map displays
- **Sliders**: Dynamic slideshow patterns
- **Structure Elements**: Flexible box layouts (10%, 12%, 16%, 20%, 25%, 30%, 33%, 40%, 50%, 60%, 66%, 70%, 75%, 80%, 88%, 90%, 100%)

### 🎭 Customization System
Two flexible approaches for theme customization:

#### 1️⃣ Override System (Quick & Simple)
For minor tweaks and small customizations:
```bash
# Copy example files and edit
cp overrides/styles/custom.example.css overrides/styles/custom.css
# Add your customizations - done!
```

#### 2️⃣ Child Theme (Full Customization)
For major changes and client sites:
```bash
# Copy the starter kit
cp -r micro ../mini-yoursite
# Edit style.css and activate in WordPress
```

### 📱 Responsive Design
- Mobile-first approach
- Flexible grid system
- RTL (Right-to-Left) language support
- Customizable logo heights for different screen states

### 🔧 Developer Tools
- **SASS/SCSS** compilation with source maps
- **ESLint** and **Stylelint** for code quality
- **PHP CodeSniffer** for WordPress coding standards
- **WP-CLI** integration for translations
- Automated build process with npm scripts

### 🌐 CDN Integration
Flexible asset loading with CDN support:
- Load mini framework CSS/JS from CDN or locally
- Configurable CDN versions
- Development and production CDN environments
- Automatic fallback to local assets

### 🎛️ Theme Customizer
Built-in customization options:
- Logo height controls
- Tagline visibility toggle
- Scroll-based logo adjustments
- Menu toggle height settings

### 📦 Multiple Sidebars
Dedicated sidebars for different content types:
- Default sidebar
- Course sidebar
- Event sidebar
- Lesson sidebar
- News sidebar
- Match sidebar

## 🚀 Installation

### Requirements
- WordPress 5.0+
- PHP 5.6+
- Node.js (for development)
- Composer (for development)

### Quick Install
1. Download the theme files
2. Upload the `mini-theme` folder to `/wp-content/themes/`
3. Activate the theme through the WordPress admin dashboard

### Development Setup
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Start development mode (watch for changes)
npm run watch
```

## 🛠️ Development Commands

### CSS/SASS
```bash
# Compile SASS to CSS
npm run compile:css

# Generate RTL stylesheet
npm run compile:rtl

# Watch for SASS changes
npm run watch
```

### Code Quality
```bash
# Lint SASS files
npm run lint:scss

# Lint JavaScript files
npm run lint:js

# Check PHP coding standards
composer lint:wpcs

# Check PHP syntax
composer lint:php
```

### Translations
```bash
# Generate .pot file
composer make-pot
```

### Distribution
```bash
# Create distribution zip (excludes dev files)
npm run bundle
```

## 📁 Theme Structure

```
mini-theme/
├── style.css                 # Main stylesheet
├── style-rtl.css            # RTL stylesheet
├── functions.php            # Theme functions
├── index.php                # Main template
├── front-page.php           # Front page template
├── home.php                 # Blog page template
├── page.php                 # Single page template
├── single.php               # Single post template
├── archive.php              # Archive pages
├── search.php               # Search results
├── 404.php                  # 404 error page
├── inc/                     # Include files
│   ├── enqueue.php         # Asset loading
│   ├── customizer.php      # Customizer options
│   ├── helpers.php         # Utility functions
│   ├── template-tags.php   # Template functions
│   └── ...
├── template-parts/          # Template parts
│   ├── content.php         # Post content
│   ├── content-event.php   # Event content
│   ├── content-course.php  # Course content
│   └── ...
├── patterns/               # Block patterns
│   ├── content_1-col.php  # Layout patterns
│   ├── slider.php         # Slider pattern
│   └── ...
├── sass/                   # SASS source files
│   ├── style.scss         # Main SASS file
│   └── _mini_wp.scss      # Framework imports
├── js/                     # JavaScript files
├── css/                    # Compiled CSS
├── languages/              # Translation files
├── micro/                  # Child theme starter
├── overrides/              # Override system
├── img/                    # Theme images
├── composer.json           # PHP dependencies
├── package.json            # Node dependencies
└── README.md              # This file
```

## 🎨 Customization Examples

### Using Block Patterns
Block patterns are available in the WordPress block editor under "Patterns" → "Mini Theme".

### Custom CSS Overrides
Add custom styles using the override system:
```css
/* overrides/styles/custom.css */
.my-custom-class {
    background-color: #f0f0f0;
    padding: 20px;
}
```

### Child Theme Development
Use the micro starter kit for full customization:
```php
// micro/functions.php
<?php
function micro_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'micro-style', get_stylesheet_uri(), array( 'parent-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'micro_enqueue_styles' );
```

## 🔌 Plugin Integration

### Mini Plugin Compatibility
This theme is designed to work seamlessly with the [Mini WordPress Plugin](https://github.com/giacomorizzotti/mini-plugin), which provides:
- Custom content type management
- SEO meta boxes
- Shortcode system
- Enhanced media upload support

### Required Plugins
- None required, but enhanced functionality with Mini Plugin

## 🌍 Internationalization

- Translation-ready with `.pot` file generation
- RTL language support
- Italian date formatting utilities (when used with Mini Plugin)

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run code quality checks:
   ```bash
   composer lint:wpcs
   npm run lint:scss
   npm run lint:js
   ```
5. Test your changes
6. Submit a pull request

## 📄 License

This theme is licensed under the GPL v2 or later.

## 👨‍💻 Author

**Giacomo Rizzotti**
- Website: [https://www.giacomorizzotti.com/](https://www.giacomorizzotti.com/)
- Theme URI: [https://mini.uwa.agency/](https://mini.uwa.agency/)

## 📊 Changelog

### Version 1.1.5
- Enhanced block patterns system
- Improved CDN integration
- Added micro child theme starter kit
- RTL language support
- Multiple sidebar system
- Custom post type template support
- SASS compilation with source maps
- Code quality tooling (ESLint, Stylelint, PHPCS)

### Version 1.0.0
- Initial release
- Basic theme structure
- Customizer integration
- Responsive design foundation

### 🤔 Which Should I Use?

- **Override System** → 1-5 changes, mostly CSS/minor tweaks, quick deployment
- **Child Theme** → 10+ changes, custom post types, client sites, extensive rebrand

**📚 Decision Guide:** See [CUSTOMIZATION-GUIDE.md](CUSTOMIZATION-GUIDE.md) for detailed comparison and use cases

**Documentation:**
- [Customization Strategy Guide](CUSTOMIZATION-GUIDE.md) ⭐ Start here!
- [Override System](overrides/README.md) | [Quick Start](overrides/QUICKSTART.md)
- [Child Theme](micro/README.md) | [Quick Deploy](micro/QUICKSTART.md)

Both approaches keep your parent theme clean and updateable!
