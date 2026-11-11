# Quick Start Guide - Theme Overrides

## 🚀 Quick Setup (5 minutes)

### 1. Override a Template
```bash
# Copy any template file to overrides/templates/
cp single.php overrides/templates/single.php
# Edit the file - it will automatically be used!
```

### 2. Add Custom CSS
```bash
# Create custom CSS file
cp overrides/styles/custom.example.css overrides/styles/custom.css
# Add your styles - they'll load automatically!
```

### 3. Add Custom Functions
```bash
# Create custom functions file
cp overrides/custom-functions.example.php overrides/custom-functions.php
# Add your PHP code - it loads automatically!
```

## 📋 Common Use Cases

### Change Homepage Layout
```bash
cp front-page.php overrides/templates/front-page.php
# Edit overrides/templates/front-page.php
```

### Customize Single Post Display
```bash
cp single.php overrides/templates/single.php
# Edit overrides/templates/single.php
```

### Override News Template
```bash
cp single-news.php overrides/templates/single-news.php
# Edit overrides/templates/single-news.php
```

### Add Custom Colors
```css
/* In overrides/styles/custom.css */
:root {
    --brand-primary: #your-color;
    --brand-secondary: #your-other-color;
}
```

### Register Custom Post Type
```php
// In overrides/custom-functions.php
function my_custom_post_type() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => 'Portfolio',
            'singular_name' => 'Portfolio Item'
        ),
        'public' => true,
        'has_archive' => true,
    ));
}
add_action('init', 'my_custom_post_type');
```

## 🎯 What Can You Override?

- ✅ **Templates**: Any `.php` file in theme root
- ✅ **Parts**: Files from `template-parts/`
- ✅ **Styles**: Add CSS in `styles/custom.css`
- ✅ **Functions**: Add PHP in `custom-functions.php`

## 💡 Pro Tips

1. **Test First**: Always test overrides on a staging site
2. **Keep Backups**: Keep original files as reference
3. **Use Examples**: Start from the `.example` files provided
4. **Clear Cache**: Clear WordPress cache after changes
5. **Version Control**: Each instance can have different overrides

## 🔍 Troubleshooting

**Override not working?**
- Check filename matches exactly (including extension)
- Clear WordPress cache
- Check file permissions (should be readable)

**CSS not loading?**
- Filename must be exactly `custom.css`
- Clear browser cache
- Check for syntax errors

**Functions not running?**
- Filename must be exactly `custom-functions.php`
- Check PHP error log
- Verify PHP syntax is correct

## 📖 Need More Help?

See the full [README.md](README.md) for detailed documentation.
