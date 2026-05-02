# Upgrade Guide

## From 0.1.x To 1.x

RedminStore 1.x is a full modernization for Laravel 12.

### Requirements

- PHP 8.2 or newer
- Laravel 12
- RedminPortal 2.x
- Node.js suitable for Vite 6

### Removed

- Laravel 5.1 support
- Bootstrap 3
- jQuery
- Redmaterials
- Grunt
- Bower
- Less source files
- Legacy Blade-only storefront layout

### Added

- Laravel package auto-discovery
- Inertia Laravel
- Vue 3
- Tailwind CSS
- Vite build output in `src/public/build`
- Catalog MVP routes for products and categories

### Development Dependency

For local development, RedminStore depends on a sibling RedminPortal checkout:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../redminportal",
      "options": {
        "symlink": true
      }
    }
  ]
}
```

Run `composer update` after changing the local RedminPortal checkout.
