<?php

namespace Redooor\Redminstore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Redooor\Redminportal\App\Models\Bundle;
use Redooor\Redminportal\App\Models\Category;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminportal\App\Models\Post;
use Redooor\Redminportal\App\Models\Product;
use Redooor\Redminportal\App\Models\Tag;

/**
 * Optional demo content for trying out the RedminStore frontend.
 *
 * Run it explicitly (it is never run by a plain `db:seed`):
 *
 *     php artisan db:seed --class="Redooor\Redminstore\Database\Seeders\SampleDataSeeder"
 *
 * Safe to run more than once, and never overwrites your data: rows are matched by name, SKU or slug and
 * left untouched if they already exist. Product SKUs are prefixed with DEMO-.
 * Requires the RedminPortal migrations and `php artisan vendor:publish --tag=redminstore-public`
 * (the sample images are served from public/vendor/redooor/redminstore/img/sample).
 *
 * The RedminPortal admin links resized copies by naming convention (e.g. 100x100_crop/<file>), so the
 * SVGs are also shipped in the dimension folders from RedminPortal's config/image.php. If you change
 * those dimensions, copy the SVGs into matching folders.
 */
class SampleDataSeeder extends Seeder
{
    private const IMAGE_PATH = 'vendor/redooor/redminstore/img/sample/';

    public function run(): void
    {
        Model::unguarded(function () {
            $categories = $this->categories();
            $products = $this->products($categories);
            $this->bundles($categories, $products);
            $this->pages();
            $this->posts();
        });
    }

    /** @return array<string, Category> keyed by slug-like handle */
    private function categories(): array
    {
        $rows = [
            'books' => ['Books', 'Practical reading for builders.', 30],
            'coffee-tea' => ['Coffee & Tea', 'Beans, leaves and brewing gear.', 20],
            'stationery' => ['Stationery', 'Notebooks and pens for daily use.', 10],
        ];

        $categories = [];
        foreach ($rows as $handle => [$name, $description, $order]) {
            $category = Category::firstOrCreate(['name' => $name], [
                'short_description' => $description,
                'long_description' => "<p>{$description} This category is sample data.</p>",
                'active' => true,
                'order' => $order,
            ]);
            if ($category->wasRecentlyCreated) {
                $this->image($category, $handle);
            }
            $categories[$handle] = $category;
        }

        return $categories;
    }

    /** @return array<string, Product> */
    private function products(array $categories): array
    {
        $rows = [
            // sku, name, category, price, featured, active, image, tags
            ['DEMO-BOOK-001', 'Laravel in Practice', 'books', 29.90, true, true, 'laravel-in-practice', ['bestseller']],
            ['DEMO-BOOK-002', 'Inertia & Vue Handbook', 'books', 34.50, false, true, 'inertia-vue-handbook', []],
            ['DEMO-BOOK-003', 'Designing Content Models', 'books', 24.00, true, true, 'content-models', ['new']],
            ['DEMO-COF-001', 'Single-Origin Coffee Beans 250g', 'coffee-tea', 18.50, true, true, 'coffee-beans', ['bestseller', 'gift']],
            ['DEMO-TEA-001', 'Jasmine Green Tea', 'coffee-tea', 12.00, false, true, 'jasmine-tea', ['new']],
            ['DEMO-COF-002', 'Ceramic Pour-Over Set', 'coffee-tea', 45.00, true, true, 'pour-over-set', ['gift']],
            ['DEMO-STA-001', 'Dot-Grid Notebook', 'stationery', 9.90, false, true, 'dot-grid-notebook', []],
            ['DEMO-STA-002', 'Brass Fountain Pen', 'stationery', 64.00, true, true, 'fountain-pen', ['gift']],
            // Inactive products are hidden from the storefront.
            ['DEMO-STA-999', 'Discontinued Desk Lamp (hidden)', 'stationery', 79.00, false, false, 'desk-lamp', []],
        ];

        $products = [];
        foreach ($rows as [$sku, $name, $handle, $price, $featured, $active, $image, $tags]) {
            $product = Product::firstOrCreate(['sku' => $sku], [
                'name' => $name,
                'category_id' => $categories[$handle]->id,
                'short_description' => "Sample product: {$name}.",
                'long_description' => "<p>{$name} is sample data created by the RedminStore demo seeder.</p>",
                'price' => $price,
                'featured' => $featured,
                'active' => $active,
            ]);
            if ($product->wasRecentlyCreated) {
                $this->image($product, $image);
                $this->tag($product, $tags);
            }
            $products[$sku] = $product;
        }

        // Variants of the coffee beans appear on its product page.
        $variants = ['DEMO-COF-001-500' => ['Single-Origin Coffee Beans 500g', 32.00], 'DEMO-COF-001-1KG' => ['Single-Origin Coffee Beans 1kg', 58.00]];
        $variantIds = [];
        foreach ($variants as $sku => [$name, $price]) {
            $variant = Product::firstOrCreate(['sku' => $sku], [
                'name' => $name,
                'category_id' => $categories['coffee-tea']->id,
                'short_description' => "Sample variant: {$name}.",
                'price' => $price,
                'featured' => false,
                'active' => true,
            ]);
            if ($variant->wasRecentlyCreated) {
                $this->image($variant, 'coffee-beans');
            }
            $variantIds[] = $variant->id;
        }
        $products['DEMO-COF-001']->variants()->syncWithoutDetaching($variantIds);

        return $products;
    }

    private function bundles(array $categories, array $products): void
    {
        $bundle = Bundle::firstOrCreate(['sku' => 'DEMO-BUN-001'], [
            'name' => 'Morning Reading Kit',
            'category_id' => $categories['books']->id,
            'short_description' => 'A book, a notebook and coffee beans.',
            'long_description' => '<p>Sample bundle created by the RedminStore demo seeder.</p>',
            'price' => 49.00,
            'featured' => false,
            'active' => true,
        ]);
        if ($bundle->wasRecentlyCreated) {
            $this->image($bundle, 'reading-kit');
            $bundle->products()->syncWithoutDetaching(
                collect(['DEMO-BOOK-001', 'DEMO-STA-001', 'DEMO-COF-001'])->map(fn ($sku) => $products[$sku]->id)->all()
            );
        }
    }

    private function pages(): void
    {
        $rows = [
            // slug, title, content, private
            ['about-us', 'About Us', '<p>RedminStore is a small demo storefront built on RedminPortal. Everything you see here is sample data.</p>', false],
            ['shipping-and-returns', 'Shipping and Returns', '<h2>Shipping</h2><p>Sample shipping information.</p><h2>Returns</h2><p>Sample returns policy.</p>', false],
            ['contact', 'Contact', '<p>Questions? This is a demo, so nobody is listening, but your own site could show contact details here.</p>', false],
            ['internal-notes', 'Internal Notes (private)', '<p>Private pages are hidden from the storefront.</p>', true],
        ];

        foreach ($rows as [$slug, $title, $content, $private]) {
            Page::firstOrCreate(['slug' => $slug], compact('title', 'content', 'private'));
        }
    }

    private function posts(): void
    {
        $rows = [
            ['welcome-to-redminstore', 'Welcome to RedminStore', '<p>This post is sample data. Edit or delete it from the RedminPortal admin.</p>', true, false],
            ['how-this-demo-works', 'How This Demo Works', '<p>Pages, posts, categories and products are managed in RedminPortal and displayed here by RedminStore.</p>', false, false],
            ['upcoming-announcement', 'Upcoming Announcement (draft)', '<p>Private posts are hidden from the storefront.</p>', false, true],
        ];

        foreach ($rows as [$slug, $title, $content, $featured, $private]) {
            Post::firstOrCreate(['slug' => $slug], compact('title', 'content', 'featured', 'private'));
        }
    }

    private function image(Model $model, string $name): void
    {
        $model->images()->firstOrCreate(['path' => self::IMAGE_PATH . $name . '.svg']);
    }

    /** @param string[] $names */
    private function tag(Product $product, array $names): void
    {
        $ids = array_map(fn (string $name) => Tag::firstOrCreate(['name' => $name])->id, $names);
        $product->tags()->syncWithoutDetaching($ids);
    }
}
