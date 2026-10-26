<?php

namespace Redooor\Redminstore\Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Redooor\Redminportal\App\Models\Category;
use Redooor\Redminportal\App\Models\Product;
use Redooor\Redminstore\Tests\RedminTestCase;

class StorefrontCatalogTest extends RedminTestCase
{
    public function test_product_index_includes_only_active_products(): void
    {
        Product::create([
            'name' => 'Active Product',
            'sku' => 'ACTIVE-1',
            'short_description' => 'Visible',
            'price' => 19.95,
            'active' => true,
        ]);
        Product::create([
            'name' => 'Inactive Product',
            'sku' => 'INACTIVE-1',
            'short_description' => 'Hidden',
            'price' => 29.95,
            'active' => false,
        ]);

        $this->get('/products')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Products/Index')
                ->has('products.data', 1)
                ->where('products.data.0.name', 'Active Product'));
    }

    public function test_product_detail_rejects_inactive_product(): void
    {
        $product = Product::create([
            'name' => 'Inactive Product',
            'sku' => 'INACTIVE-DETAIL',
            'short_description' => 'Hidden',
            'price' => 29.95,
            'active' => false,
        ]);

        $this->get('/products/' . $product->id)
            ->assertStatus(404)
            ->assertInertia(fn (Assert $page) => $page->component('NotFound'));
    }

    public function test_category_route_filters_products(): void
    {
        $category = Category::create([
            'name' => 'Books',
            'short_description' => 'Readable goods',
            'active' => true,
        ]);
        $otherCategory = Category::create([
            'name' => 'Games',
            'short_description' => 'Playable goods',
            'active' => true,
        ]);

        Product::create([
            'name' => 'Book Product',
            'sku' => 'BOOK-1',
            'short_description' => 'In category',
            'price' => 10,
            'active' => true,
            'category_id' => $category->id,
        ]);
        Product::create([
            'name' => 'Game Product',
            'sku' => 'GAME-1',
            'short_description' => 'Other category',
            'price' => 15,
            'active' => true,
            'category_id' => $otherCategory->id,
        ]);

        $this->get('/categories/' . $category->id)
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Categories/Show')
                ->where('category.name', 'Books')
                ->has('products', 1)
                ->where('products.0.name', 'Book Product'));
    }
}
