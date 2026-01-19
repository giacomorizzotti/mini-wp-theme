# Quick Deploy - Child Theme

## 🚀 3-Step Deployment

### 1️⃣ Copy & Rename
```bash
cd /path/to/wp-content/themes/
cp -r mini/micro mini-yoursite
```

### 2️⃣ Edit Theme Info
```bash
nano mini-yoursite/style.css
```
Change:
- **Theme Name** → Your site name
- **Description** → Your description  
- **Author** → Your name

### 3️⃣ Activate
WordPress Admin → Appearance → Themes → Activate your child theme

---

## ✏️ Quick Edits

### Add Colors
`style.css`:
```css
:root {
    --primary: #3498db;
}
.site-header { background: var(--primary); }
```

### Add Function
`functions.php` - uncomment any example function

### Override Template
```bash
cp ../mini/single.php ./single.php
```

**Full docs:** [README.md](README.md)
