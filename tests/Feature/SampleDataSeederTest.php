<?php

namespace Redooor\Redminstore\Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Redooor\Redminportal\App\Models\Bundle;
use Redooor\Redminportal\App\Models\Category;
use Redooor\Redminportal\App\Models\Image;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminportal\App\Models\Post;
use Redooor\Redminportal\App\Models\Product;
use Redooor\Redminportal\App\Models\Tag;
use Redooor\Redminstore\Database\Seeders\SampleDataSeeder;
use Redooor\Redminstore\Tests\RedminTestCase;

class SampleDataSeederTest extends RedminTestCase
{
    public function test_seeded_storefront_renders_sample_content(): void
    {
        $this->seed(SampleDataSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('featuredProducts', 5)
                ->has('pages', 3)
                ->has('posts', 2));

        $this->get('/products')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->has('products.data', 10) // 8 active + 2 variants; the inactive one is hidden
                ->has('categories', 3));

        $beans = Product::where('sku', 'DEMO-COF-001')->firstOrFail();
        $this->get('/products/' . $beans->id)
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->has('product.variants', 2));

        $this->get('/categories/' . Category::where('name', 'Books')->firstOrFail()->id)
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->has('products', 3)->has('bundles', 1));

        $this->assertCount(3, Bundle::where('sku', 'DEMO-BUN-001')->firstOrFail()->products);

        $this->get('/page/about-us')->assertOk();
        $this->get('/page/internal-notes')->assertNotFound();
        $this->get('/post/upcoming-announcement')->assertNotFound();
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(SampleDataSeeder::class);
        $count = fn () => [
            Product::count(), Category::count(), Image::count(), Page::count(), Post::count(),
            Tag::count(), Bundle::count(), \DB::table('taggables')->count(), \DB::table('product_variant')->count(),
            \DB::table('bundle_product')->count(),
        ];
        $counts = $count();

        $this->seed(SampleDataSeeder::class);

        $this->assertSame($counts, $count());
    }

    public function test_seeder_does_not_overwrite_existing_content(): void
    {
        Page::create(['title' => 'My Real Contact Page', 'slug' => 'contact', 'content' => 'real', 'private' => true]);
        Category::create(['name' => 'Books', 'short_description' => 'Mine', 'active' => true]);

        $this->seed(SampleDataSeeder::class);

        $page = Page::where('slug', 'contact')->firstOrFail();
        $this->assertSame('My Real Contact Page', $page->title);
        $this->assertTrue((bool) $page->private);
        $book = Category::where('name', 'Books')->firstOrFail();
        $this->assertSame('Mine', $book->short_description);
        $this->assertCount(0, $book->images);
    }

    public function test_sample_images_ship_with_the_package(): void
    {
        $this->seed(SampleDataSeeder::class);

        foreach (Image::pluck('path') as $path) {
            $file = dirname(__DIR__, 2) . '/src/public/' . substr($path, strlen('vendor/redooor/redminstore/'));
            $this->assertFileExists($file);
        }
    }
}
