# Upgrade Guide

## From 0.1.x To 1.x

RedminStore 1.x is a full modernization for Laravel 12 and Laravel 13.

### Requirements

- PHP 8.2 or newer for Laravel 12
- PHP 8.3 or newer for Laravel 13
- Laravel 12 or Laravel 13
- RedminPortal 2.x for Laravel 12
- RedminPortal 3.x for Laravel 13
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

### Laravel 13 Notes

Laravel 13 support is expressed through Composer constraints:

- `laravel/framework`: `^12.0 || ^13.0`
- `orchestra/testbench`: `^10.0 || ^11.0`
- `phpunit/phpunit`: `^11.5 || ^12.5`
- `redooor/redminportal`: `^2.0 || ^3.0`

The local development stack has been verified with PHP 8.3, Laravel 13, RedminPortal 3, Orchestra Testbench 11, and PHPUnit 12.
