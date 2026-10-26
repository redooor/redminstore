# RedminStore

RedminStore is a Laravel 13 package that provides an Inertia, Vue 3, and Tailwind CSS storefront for ecommerce sites administered with RedminPortal.

This package is intentionally small. It is meant to show developers how to build a public catalog and CMS frontend on top of RedminPortal models, not to provide a complete cart or checkout system.

## Compatibility

| Laravel | PHP | RedminPortal | RedminStore |
|:-------:|:---:|:------------:|:-----------:|
| 13.x    | 8.3+ | 2.x          | 1.x         |

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

## Installing In A Laravel 13 App

Require the package from your Laravel app, publish assets, and run RedminPortal migrations/seeds as needed:

```bash
composer require redooor/redminstore
php artisan vendor:publish --tag=redminstore-public --force
```

The package is auto-discovered by Laravel through `composer.json`. Published assets are served from:

```text
public/vendor/redooor/redminstore
```

Use PHP 8.3 or newer and RedminPortal 2.x.

## Sample Data (Optional)

To try the storefront with demo content, run the optional seeder after the RedminPortal migrations and after publishing the assets above:

```bash
php artisan db:seed --class="Redooor\Redminstore\Database\Seeders\SampleDataSeeder"
```

It creates 3 categories, 12 products (including variants, a bundle, one featured set and one hidden inactive product), 3 public pages, 2 public posts, plus private examples that stay hidden, and uses small placeholder images shipped with the package. It is never run by a plain `db:seed`, and it can be run again safely: records are matched by name, SKU (prefixed `DEMO-`) or slug and are never overwritten if they already exist. Delete the sample records from the RedminPortal admin when you are done.

## Routes

RedminStore registers public routes:

- `/`
- `/{slug}` for public CMS pages (see below)
- `/page/{slug}` (redirects to `/{slug}`)
- `/post/{slug}`
- `/products`
- `/products/{product}`
- `/categories/{category}`

The admin backend remains RedminPortal's responsibility.

### Pages at the site root

A public page created in RedminPortal is served at the site root, like a typical CMS: a page with slug `about` appears at `/about`, and `/page/about` redirects to it. Pages marked private in RedminPortal return 404.

This is registered as a Laravel fallback route, so it only runs when nothing else matches. Your own routes, RedminPortal's `/admin` and `/login`, and the storefront routes (`/products`, `/categories/...`) always win over a page with the same slug, so avoid giving a page the slug `products`, `admin`, `login`, etc. Only single-segment slugs are supported, and unknown URLs fall through to your app's normal 404.

To keep pages under `/page/{slug}` instead, publish the config and set `pages_at_root` to `false`:

```bash
php artisan vendor:publish --tag=redminstore-config
```

## Testing

Run the package test suite:

```bash
composer test
```

The tests use Orchestra Testbench with an in-memory SQLite database and RedminPortal migrations.

## License

RedminStore is open-sourced software licensed under the MIT license.
