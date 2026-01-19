# Quick Reference: Override vs Child Theme

## 🚦 Quick Decision

```
Your Changes          →  Use This
────────────────────────────────────
1-5 files                Override ✓
Just CSS                 Override ✓
Custom functions (few)   Override ✓
Custom post types        Child ✓
10+ file changes         Child ✓
Client site              Child ✓
Extensive rebrand        Child ✓
```

## ⚡ Quick Commands

### Override System
```bash
# In mini/overrides/
cp styles/custom.example.css styles/custom.css
# Edit files - auto-loads!
```

### Child Theme
```bash
# In wp-content/themes/
cp -r mini/micro mini-sitename
# Edit style.css → Activate in WP Admin
```

## 📖 Full Guide
See [CUSTOMIZATION-GUIDE.md](CUSTOMIZATION-GUIDE.md) for detailed comparison.

## ⚠️ Remember
**One approach per WordPress instance** - don't mix both!
