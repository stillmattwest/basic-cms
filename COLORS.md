# CMS Component Library - Color System

## 🎨 Semantic Color System

This component library uses a **semantic color system** that makes it easy to reuse components across different projects with different color schemes.

## 📋 Available Color Palettes

### Primary Colors (`primary-*`)
Used for main interactive elements, buttons, links, and focus states.
- Current mapping: **Teal** (`#0d9488` for primary-600)
- Available shades: 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950

### Accent Colors (`accent-*`)
Used for subtle highlights, background accents, and secondary elements.
- Current mapping: **Teal** (same as primary for monochromatic harmony)
- Available shades: 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950

### Featured Colors (`featured-*`)
Used specifically for featured content badges and special highlights.
- Current mapping: **Yellow** (`#f59e0b` for featured-500)
- Available shades: 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950

## 🔧 Usage in Components

### Common Patterns:

**Buttons & Links:**
```blade
class="bg-primary-600 hover:bg-primary-700 text-white"
class="text-primary-600 hover:text-primary-800"
```

**Focus States:**
```blade
class="focus:ring-primary-500 focus:border-primary-500"
```

**Featured Content:**
```blade
class="bg-featured-100 text-featured-800 dark:bg-featured-900 dark:text-featured-200"
```

**Subtle Backgrounds:**
```blade
class="bg-accent-50 dark:bg-accent-800"
```

## 🌈 Customizing for Other Projects

To use these components with a different color scheme, simply update the color mappings in your `tailwind.config.js`:

### Example: Blue Color Scheme
```javascript
// tailwind.config.js
theme: {
  extend: {
    colors: {
      primary: {
        50: '#eff6ff',   // blue-50
        // ... map to blue colors
        600: '#2563eb', // blue-600
        // ... rest of blue scale
      },
      // Keep accent and featured as needed
    }
  }
}
```

### Example: Purple Color Scheme
```javascript
// tailwind.config.js
theme: {
  extend: {
    colors: {
      primary: {
        50: '#faf5ff',   // purple-50
        // ... map to purple colors
        600: '#9333ea', // purple-600
        // ... rest of purple scale
      }
    }
  }
}
```

## 🎯 Benefits

1. **Reusable**: Components work across different projects
2. **Maintainable**: Change colors in one place
3. **Consistent**: Semantic names ensure proper usage
4. **Flexible**: Easy to swap color schemes
5. **Dark Mode Ready**: All colors have dark mode variants

## 📝 Migration Notes

When migrating existing projects:
1. Update `tailwind.config.js` with semantic color definitions
2. Replace hardcoded color classes (e.g., `blue-600` → `primary-600`)
3. Rebuild CSS assets
4. Test across all components and pages

---

*This system ensures your component library remains flexible and reusable across multiple projects while maintaining design consistency.*
