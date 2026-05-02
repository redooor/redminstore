# RedminStore

RedminStore is a Laravel 12 package that provides an Inertia, Vue 3, and Tailwind CSS storefront for ecommerce sites administered with RedminPortal.

This package is intentionally small. It is meant to show developers how to build a public catalog and CMS frontend on top of RedminPortal models, not to provide a complete cart or checkout system.

## Compatibility

| Laravel | RedminPortal | RedminStore |
|:-------:|:------------:|:-----------:|
| 12.x    | 2.x          | 1.x         |

## Features

- Inertia SPA storefront using Vue 3.
- Tailwind CSS theme compiled with Vite.
- Public CMS page and post routes backed by RedminPortal.
- Product catalog index, category pages, and product detail pages.
- Local RedminPortal path dependency for package development.

## Local Development

This repository expects RedminPortal to be checked out next to it:

```text
redooor/
  redminportal/
  redminstore/
```

The Composer path repository points to `../redminportal` and symlinks it during development.

Install PHP dependencies:

```bash
composer update
```

Install frontend dependencies:

```bash
npm install
```

Build assets:

```bash
npm run build
```

During theme development, run:

```bash
npm run dev
```

## Installing In A Laravel 12 App

Require the package from your Laravel app, publish assets, and run RedminPortal migrations/seeds as needed:

```bash
composer require redooor/redminstore
php artisan vendor:publish --tag=redminstore-public --force
```

The package is auto-discovered by Laravel through `composer.json`. Published assets are served from:

```text
public/vendor/redooor/redminstore
```

## Routes

RedminStore registers public routes:

- `/`
- `/page/{slug}`
- `/post/{slug}`
- `/products`
- `/products/{product}`
- `/categories/{category}`

The admin backend remains RedminPortal's responsibility.

## Testing

Run the package test suite:

```bash
composer test
```

The tests use Orchestra Testbench with an in-memory SQLite database and RedminPortal migrations.

## License

RedminStore is open-sourced software licensed under the MIT license.
