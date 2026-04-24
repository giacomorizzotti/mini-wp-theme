# Mini Theme - Child Theme Starter Kit

This directory contains a complete child theme starter template for the Mini WordPress theme. Use this when deploying Mini to a new WordPress instance that needs customization.

## 📦 What's Included

```
micro/
├── style.css                    # Required: Theme info and base styles
├── functions.php                # Required: Enqueue styles + custom functions
├── screenshot.png               # Optional: Theme thumbnail (1200x900px)
├── assets/
│   ├── css/
│   │   └── custom.css          # Additional custom styles
│   └── js/
│       └── custom.js           # Custom JavaScript
├── template-parts/
│   └── content-custom.php.example  # Custom template parts
├── patterns/                   # Override parent patterns
├── *.php.example              # Example template overrides
└── README.md                  # This file
```

## 🚀 Quick Deploy (3 Steps)

### Step 1: Copy the Starter Kit

```bash
# From the themes directory
cd /path/to/wp-content/themes/

# Copy and rename for your instance
cp -r mini/micro mini-yourinstance

# Example names:
# mini-uwa
# mini-client-name
# mini-staging
```

### Step 2: Customize Theme Info

Edit `style.css` header:

```css
/*
 Theme Name:   Mini UWA          # ← Change this
 Description:  Child theme for UWA website  # ← Change this
 Author:       Your Name         # ← Change this
 Template:     mini              # ← Keep as 'mini'
 Version:      1.0.0
*/
```

### Step 3: Activate in WordPress

1. Go to WordPress Admin → Appearance → Themes
2. Find your new child theme (e.g., "Mini UWA")
3. Click **Activate**

That's it! ✅

## 📝 Customization Guide

### Add Custom CSS

**Option 1: In `style.css`** (for main styles)
```css
/* In style.css, after the header comment */
.site-header {
    background-color: #your-color;
}
```

**Option 2: In `assets/css/custom.css`** (for additional styles)
```css
/* Automatically loaded if file exists */
.custom-element {
    color: blue;
}
```

### Add Custom PHP Functions

In `functions.php`, uncomment and modify examples:

```php
// Register custom post type
function mini_child_custom_post_type() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'mini-child'),
        ),
        'public' => true,
        'has_archive' => true,
    ));
}
add_action('init', 'mini_child_custom_post_type');
```

### Override Parent Templates

**Method 1: Copy from parent**
```bash
# Copy any template from parent theme
cp ../mini/single-news.php ./single-news.php

# Edit the copy - it will override the parent
```

**Method 2: Use examples provided**
```bash
# Rename example files (remove .example)
mv single.php.example single.php

# Edit as needed
```

### Create Custom Template Parts

```bash
# Remove .example extension
mv template-parts/content-custom.php.example template-parts/content-custom.php

# Use in your templates:
# get_template_part('template-parts/content', 'custom');
```

### Add Custom JavaScript

Edit `assets/js/custom.js`:

```javascript
(function($) {
    $(document).ready(function() {
        // Your code here
        console.log('Child theme JS loaded');
    });
})(jQuery);
```

## 🎨 Common Customizations

### Change Site Colors

```css
/* In style.css */
:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
}

.site-header {
    background-color: var(--primary-color);
}
```

### Add Custom Logo Size

```php
// In functions.php
function mini_child_custom_logo_size() {
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'mini_child_custom_logo_size', 11);
```

### Modify Excerpt Length

```php
// In functions.php
function mini_child_excerpt_length($length) {
    return 30; // Number of words
}
add_filter('excerpt_length', 'mini_child_excerpt_length', 999);
```

### Add Custom Menu Location

```php
// In functions.php
function mini_child_register_menus() {
    register_nav_menus(array(
        'footer-secondary' => __('Footer Secondary Menu', 'mini-child'),
    ));
}
add_action('init', 'mini_child_register_menus');
```

## 📂 File Organization

### What Goes Where?

| File Type | Location | Purpose |
|-----------|----------|---------|
| Main styles | `style.css` | Theme info + primary CSS |
| Extra styles | `assets/css/custom.css` | Additional CSS (auto-loaded) |
| Custom JS | `assets/js/custom.js` | JavaScript (auto-loaded) |
| Template overrides | Root directory | Override parent templates |
| Custom template parts | `template-parts/` | Reusable template components |
| Custom patterns | `patterns/` | Block editor patterns |
| Functions | `functions.php` | PHP functions and hooks |

## 🔄 Updating the Parent Theme

Child themes make parent theme updates safe:

1. **Update Mini theme** (parent) via WordPress or Git
2. **Your customizations are preserved** in the child theme
3. **Test the site** to ensure compatibility
4. **Adjust child theme** if needed for new parent features

⚠️ **Important**: Always test updates on staging first!

## 🎯 Best Practices

### ✅ DO:
- Keep customizations in the child theme
- Use `get_template_directory()` for parent, `get_stylesheet_directory()` for child
- Test thoroughly before deploying
- Document your customizations
- Use proper WordPress coding standards
- Enqueue scripts/styles properly (already set up in functions.php)

### ❌ DON'T:
- Modify parent theme files
- Copy entire parent theme files if you only need small changes
- Hardcode URLs or paths
- Ignore WordPress security best practices

## 📱 Responsive Design

The child theme inherits parent theme responsiveness. To customize:

```css
/* In style.css */
@media screen and (max-width: 768px) {
    .site-header {
        padding: 1rem;
    }
}

@media screen and (max-width: 480px) {
    .site-title {
        font-size: 1.5rem;
    }
}
```

## 🔍 Debugging

### Enable WordPress Debug Mode

In `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check errors in: `wp-content/debug.log`

### Check Theme Status

```php
// Add to functions.php temporarily
function mini_child_debug_info() {
    if (current_user_can('manage_options')) {
        echo '<!-- Child Theme Active -->';
        echo '<!-- Parent: ' . get_template() . ' -->';
        echo '<!-- Child: ' . get_stylesheet() . ' -->';
    }
}
add_action('wp_head', 'mini_child_debug_info');
```

## 📚 Resources

- [WordPress Child Themes Documentation](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)

## 🆘 Troubleshooting

### Child theme not showing in WordPress?

- Check `style.css` header has `Template: mini`
- Ensure parent theme "mini" is installed
- Clear WordPress cache

### Styles not loading?

- Check `functions.php` is enqueuing styles correctly
- Clear browser cache
- Check browser console for errors
- Verify file paths are correct

### Custom functions not working?

- Check for PHP errors in debug log
- Ensure hooks are using correct priority
- Verify function names don't conflict with parent theme

### Templates not overriding?

- Check filename matches parent template exactly
- Clear WordPress cache
- Ensure file is in the correct location (child theme root for main templates)

## 📋 Deployment Checklist

Before deploying to production:

- [ ] Updated theme name and info in `style.css`
- [ ] Added custom CSS/JS as needed
- [ ] Tested all custom functionality
- [ ] Checked responsive design on mobile/tablet
- [ ] Verified parent theme updates don't break child
- [ ] Tested forms and interactive elements
- [ ] Checked browser compatibility
- [ ] Optimized images and assets
- [ ] Set up proper caching
- [ ] Enabled production error logging (not display)

---

## 📬 Contact Form

The mini plugin includes a built-in contact form. Use the shortcode anywhere:

```
[mini_contact_form]
```

Default fields: **Name**, **Surname**, **Email**, **Phone**, **Message** + optional GDPR consent (enabled in *WP Admin → Mini → Contact Form*).

### Customize fields (add / remove / reorder)

In `custom-functions.php`:

```php
add_filter( 'mini_contact_form_fields', function ( $fields ) {
    unset( $fields['phone'] );        // remove a field
    $fields['company'] = [            // add a field
        'type'         => 'text',
        'label'        => __( 'Company', 'mini' ),
        'name'         => 'mini_cf_company',
        'required'     => false,
        'box_class'    => 'box-100',
        'autocomplete' => 'organization',
    ];
    return $fields;
} );
```

### Override a field's template

Copy the example and remove `.example` to activate:

```bash
cp template-parts/contact-form-field-name.php.example \
   template-parts/contact-form-field-name.php
```

You can create similar overrides for any field slug (`surname`, `email`, `phone`, `message`, `gdpr`).

### Override the entire form

```bash
cp template-parts/contact-form.php.example \
   template-parts/contact-form.php
```

### Override hierarchy

The theme checks for templates in this order (first match wins):

1. `overrides/parts/contact-form.php` — instance-specific
2. `micro/template-parts/contact-form.php` — this child theme ← you are here
3. `template-parts/contact-form.php` — mini-theme default



```bash
# Deploy new instance
cp -r mini/micro mini-sitename

# Edit theme info
nano mini-sitename/style.css

# Activate in WP Admin
# Appearance → Themes → Mini Sitename → Activate
```

**Need help?** Check the parent Mini theme documentation or WordPress Codex.
