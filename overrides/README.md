# Mini Theme - Instance Overrides System

This directory allows you to customize your WordPress theme for each specific instance without modifying the core theme files. This works similarly to WordPress child themes but keeps everything in one place.

## 📁 Directory Structure

```
overrides/
├── templates/          # Override main template files
├── parts/             # Override template-parts/
├── patterns/          # Override patterns/
├── styles/            # Instance-specific CSS
├── custom-functions.php  # Instance-specific PHP functions
└── README.md          # This file
```

## 🚀 How It Works

### 1. **Override Template Files** (templates/)

Place any main template file here to override the core theme version:

**Example:** Copy `single.php` to `overrides/templates/single.php` and modify it.

Supported files:
- `index.php`
- `single.php`, `single-{post-type}.php`
- `page.php`
- `archive.php`, `archive-{post-type}.php`
- `front-page.php`
- `home.php`
- `header.php`
- `footer.php`
- `404.php`
- And any other WordPress template file

### 2. **Override Template Parts** (parts/)

Override files from the `template-parts/` directory:

**Example:** `overrides/parts/content-news.php` will override `template-parts/content-news.php`

In your templates, use the provided helper function:
```php
// Instead of: get_template_part('template-parts/content', 'news');
// Use: mini_get_template_part_override('template-parts/content', 'news');
```

Or use standard WordPress function - the filter will handle it automatically.

### 3. **Override Patterns** (patterns/)

Override files from the `patterns/` directory:

**Example:** `overrides/patterns/content_1-col_hero.php` will override `patterns/content_1-col_hero.php`

### 4. **Custom Styles** (styles/)

Add instance-specific CSS that loads after the main theme styles:

**File:** `overrides/styles/custom.css`

```css
/* Your custom styles here */
.site-header {
    background-color: #your-color;
}
```

This file is automatically enqueued with cache-busting based on modification time.

### 5. **Custom Functions** (custom-functions.php)

Add instance-specific PHP functions and hooks:

**File:** `overrides/custom-functions.php`

```php
<?php
/**
 * Instance-specific functions
 */

// Add custom post types
function my_custom_post_type() {
    // Your code here
}
add_action('init', 'my_custom_post_type');

// Modify theme behavior
function my_custom_filter($content) {
    // Your modifications
    return $content;
}
add_filter('the_content', 'my_custom_filter');
```

## 📝 Usage Examples

### Example 1: Custom Homepage Template

1. Copy `front-page.php` to `overrides/templates/front-page.php`
2. Modify as needed for this specific instance
3. The override is automatically used

### Example 2: Custom News Article Layout

1. Create `overrides/parts/content-news.php`
2. Customize the news article display
3. The override is used when news articles are displayed

### Example 3: Instance-Specific Styling

1. Create `overrides/styles/custom.css`
2. Add your custom CSS:
```css
/* Custom brand colors for this instance */
:root {
    --primary-color: #ff6b6b;
    --secondary-color: #4ecdc4;
}

.site-title {
    color: var(--primary-color);
}
```

### Example 4: Add Custom Functionality

1. Create `overrides/custom-functions.php`
2. Add custom code:
```php
<?php
// Register custom menu location
function instance_custom_menu() {
    register_nav_menus(array(
        'instance-menu' => __('Instance Specific Menu', 'mini'),
    ));
}
add_action('init', 'instance_custom_menu');
```

## 🔍 Helper Functions

### Check if an override exists

```php
if (mini_has_override('template', 'single-news.php')) {
    // Override exists
}

if (mini_has_override('style', 'custom.css')) {
    // Custom CSS exists
}
```

### Use overridable template parts

```php
// This automatically checks for overrides
mini_get_template_part_override('template-parts/content', 'page');
```

## 🎯 Best Practices

1. **Keep Core Files Intact**: Never modify files outside the `overrides/` directory
2. **Use Version Control**: Add `overrides/*` to `.gitignore` but track your instance changes separately
3. **Document Changes**: Keep notes about why you made specific overrides
4. **Test Thoroughly**: Test overrides before deploying to production
5. **Update Carefully**: When updating the core theme, check if your overrides are still compatible

## 🔒 Version Control

The `overrides/` directory is git-ignored by default to keep instance-specific code separate from the core theme. This means:

- ✅ Core theme can be updated easily
- ✅ Instance customizations stay local to each installation
- ✅ Different sites can have different overrides

If you want to track overrides for a specific instance:
```bash
# In your instance's repository
git add -f wp-content/themes/mini/overrides/
```

## 🐛 Troubleshooting

**Override not working?**
1. Check file path and name match exactly
2. Clear WordPress cache
3. Check file permissions
4. Verify the file has valid PHP/CSS syntax

**Styles not loading?**
1. Ensure file is named `custom.css` in `overrides/styles/`
2. Clear browser cache
3. Check browser console for errors

**Functions not running?**
1. Ensure file is named `custom-functions.php` in `overrides/`
2. Check for PHP errors in WordPress debug log
3. Verify hooks are using correct priority

## 📚 Additional Resources

- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Hooks Reference](https://developer.wordpress.org/reference/hooks/)
- [WordPress Theme Development](https://developer.wordpress.org/themes/)

---

**Need help?** Check the theme documentation or consult the WordPress Codex.
