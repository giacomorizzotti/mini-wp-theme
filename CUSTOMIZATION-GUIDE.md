# Mini Theme - Customization Strategy Guide

This theme provides **two ways** to customize for different WordPress instances. Choose the right approach based on your needs.

## 🤔 Which Approach Should I Use?

### Quick Decision Tree

```
How many customizations do you need?

├─ Just a few tweaks (1-5 changes)
│  └─ Use OVERRIDE SYSTEM
│
├─ Moderate changes (5-10 changes)
│  ├─ All minor (CSS, few functions)
│  │  └─ Use OVERRIDE SYSTEM
│  └─ Some structural changes
│     └─ Use CHILD THEME
│
└─ Major customization (10+ changes)
   └─ Use CHILD THEME
```

---

## 📊 Comparison Chart

| Feature | Override System | Child Theme |
|---------|----------------|-------------|
| **Setup Time** | < 1 minute | 2-3 minutes |
| **Learning Curve** | Minimal | Low |
| **Best For** | Quick tweaks | Major changes |
| **WordPress Standard** | No | Yes |
| **Visible in WP Admin** | No | Yes (separate theme) |
| **Switching Parent/Child** | N/A | Yes |
| **File Organization** | All in `overrides/` | Separate theme folder |
| **Update Safety** | ✅ Safe | ✅ Safe |
| **Client-Friendly** | Medium | High |

---

## 🎯 Use Case Examples

### Override System Examples

✅ **Perfect for:**
- UWA website: Custom brand colors + modified header
- Internal blog: Different footer content
- Test site: Trying out a new template design
- Portfolio site: Custom single-project template + CSS

📁 **What you'd override:**
```
overrides/
├── styles/custom.css          # Brand colors
├── templates/header.php       # Custom header
└── custom-functions.php       # 2-3 helper functions
```

### Child Theme Examples

✅ **Perfect for:**
- Client corporate site: Complete rebrand, custom post types, new page templates
- E-commerce site: WooCommerce customizations, multiple templates
- Multi-language site: Extensive template modifications
- White-label product: Will be used by multiple end-users

📁 **What you'd create:**
```
mini-client/
├── style.css                  # Extensive CSS changes
├── functions.php              # Custom post types, taxonomies, etc.
├── woocommerce/              # WooCommerce templates
├── single.php                 # Custom single post
├── archive-*.php             # Multiple archive templates
├── page-*.php                # Multiple page templates
└── template-parts/           # Custom template parts
```

---

## 📋 Decision Checklist

### Choose **Override System** if:
- [ ] Making 1-5 file changes
- [ ] Mostly CSS/styling tweaks
- [ ] You manage the site yourself
- [ ] Don't need to see theme in WP Admin
- [ ] Want fastest deployment
- [ ] Changes are instance-specific and temporary

### Choose **Child Theme** if:
- [ ] Making 10+ file changes
- [ ] Creating custom post types/taxonomies
- [ ] Client needs to see theme in Admin
- [ ] Might reuse customizations elsewhere
- [ ] Want standard WordPress approach
- [ ] Need to distribute/share the theme
- [ ] Planning extensive ongoing development

---

## 🚀 Deployment Workflows

### Override System Deployment

```bash
# In your instance
cd /path/to/wp-content/themes/mini/

# Create your overrides
cp overrides/styles/custom.example.css overrides/styles/custom.css
nano overrides/styles/custom.css

# Add functions if needed
cp overrides/custom-functions.example.php overrides/custom-functions.php

# Done! Refresh your site
```

**Time:** ~2 minutes  
**Files changed:** 1-3

### Child Theme Deployment

```bash
# Copy starter
cd /path/to/wp-content/themes/
cp -r mini/micro mini-sitename

# Customize
cd mini-sitename
nano style.css  # Update theme info
nano functions.php  # Add custom code

# Activate in WordPress Admin
# Appearance → Themes → Mini Sitename → Activate
```

**Time:** ~5 minutes  
**Files changed:** 2+ (separate theme)

---

## 💡 Real-World Scenarios

### Scenario 1: Personal Blog
**Need:** Different colors, custom footer
**Choose:** ✅ Override System  
**Why:** Simple CSS changes, 1-2 files  
**Files:** `overrides/styles/custom.css`, `overrides/templates/footer.php`

### Scenario 2: Client Restaurant Site
**Need:** Custom menu post type, booking system, gallery templates, rebrand
**Choose:** ✅ Child Theme  
**Why:** Multiple custom features, client needs control  
**Files:** Full child theme with 10+ customized files

### Scenario 3: Company Blog
**Need:** Custom header, modified news template
**Choose:** ✅ Override System  
**Why:** Just 2 templates, internal use  
**Files:** `overrides/templates/header.php`, `overrides/templates/single-news.php`

### Scenario 4: Multi-Site Network
**Need:** Each site has different branding but similar structure
**Choose:** ✅ Child Theme (different child for each site)  
**Why:** Easier to manage separate themes per site  
**Files:** `mini-site1/`, `mini-site2/`, etc.

### Scenario 5: Staging Environment Testing
**Need:** Test new template designs before production
**Choose:** ✅ Override System  
**Why:** Quick to test, easy to rollback  
**Files:** Temporary overrides for testing

---

## ⚠️ Important Rules

### ❌ DON'T Mix Both on Same Instance

**Bad:**
```
mini/
└── overrides/
    └── styles/custom.css       # Override system
    
mini-child/                      # Child theme
└── style.css                    # Also active!
```
This creates confusion about which takes precedence.

**Good:**
```
# Instance A (UWA)
mini/
└── overrides/
    └── styles/custom.css       # Uses override system

# Instance B (Client)
mini/                            # Parent (unmodified)
mini-client/                     # Child theme
```

### ✅ DO Choose One Per Instance

Each WordPress installation should use **either**:
- Override system (modify parent theme with `overrides/`)
- Child theme (activate separate child theme)

---

## 🔄 Migration Path

### From Override System → Child Theme

If you start with overrides and outgrow it:

```bash
# 1. Create child theme
cp -r mini/micro ../mini-instance

# 2. Copy your overrides
cp mini/overrides/styles/custom.css mini-instance/assets/css/
cp mini/overrides/custom-functions.php mini-instance/functions.php  # Merge
cp mini/overrides/templates/* mini-instance/

# 3. Remove overrides
rm -rf mini/overrides/templates/*
rm mini/overrides/styles/custom.css
rm mini/overrides/custom-functions.php

# 4. Activate child theme
# WordPress Admin → Appearance → Themes → Activate
```

### From Child Theme → Override System

If child theme is overkill:

```bash
# 1. Copy files to overrides
cp mini-child/assets/css/custom.css mini/overrides/styles/
cp mini-child/single.php mini/overrides/templates/
# Extract functions from mini-child/functions.php to mini/overrides/custom-functions.php

# 2. Deactivate child theme
# WordPress Admin → Appearance → Themes → Activate Mini (parent)

# 3. Archive child theme
mv mini-child mini-child.backup
```

---

## 📚 Quick Reference

| What I Need | Use This | Documentation |
|-------------|----------|---------------|
| Brand colors only | Override System | [overrides/README.md](overrides/README.md) |
| 1-2 template changes | Override System | [overrides/QUICKSTART.md](overrides/QUICKSTART.md) |
| Custom functions (<10) | Override System | [overrides/README.md](overrides/README.md) |
| Custom post types | Child Theme | [micro/README.md](micro/README.md) |
| Extensive rebrand | Child Theme | [micro/README.md](micro/README.md) |
| Client site | Child Theme | [micro/QUICKSTART.md](micro/QUICKSTART.md) |
| Multiple instances | Both (different per site) | This guide |

---

## 🎓 Summary

**Both systems are safe and update-friendly!** The choice is about:

1. **Scale of changes** - Override for small, Child for large
2. **Audience** - Override for internal, Child for clients
3. **Maintenance** - Override is simpler, Child is more organized for complex sites

**Remember:** One approach per WordPress instance. Never mix both on the same site.

---

**Need help deciding?** Ask yourself:
- "Can I do this with < 5 file changes?" → **Override System**
- "Will this require 10+ changes or custom post types?" → **Child Theme**

Still unsure? Start with **Override System** - it's easier to migrate to Child Theme later if needed!
