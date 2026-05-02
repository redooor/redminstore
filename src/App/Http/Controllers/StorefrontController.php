<?php

namespace Redooor\Redminstore\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Redooor\Redminportal\App\Models\Bundle;
use Redooor\Redminportal\App\Models\Category;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminportal\App\Models\Post;
use Redooor\Redminportal\App\Models\Product;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class StorefrontController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'featuredProducts' => Product::query()
                ->with(['category', 'images'])
                ->where('active', true)
                ->where('featured', true)
                ->latest()
                ->limit(6)
                ->get()
                ->map(fn (Product $product) => $this->productSummary($product)),
            'pages' => Page::query()
                ->where('private', false)
                ->latest()
                ->limit(5)
                ->get(['id', 'title', 'slug'])
                ->map(fn (Page $page) => $this->contentSummary($page, 'page')),
            'posts' => Post::query()
                ->where('private', false)
                ->latest()
                ->limit(5)
                ->get(['id', 'title', 'slug'])
                ->map(fn (Post $post) => $this->contentSummary($post, 'post')),
        ]);
    }

    public function page(string $slug): Response|SymfonyResponse
    {
        if (! $this->validSlug($slug)) {
            return $this->notFound();
        }

        $page = Page::query()
            ->where('slug', $slug)
            ->where('private', false)
            ->first();

        if (! $page) {
            return $this->notFound();
        }

        return Inertia::render('CmsPage', [
            'page' => [
                'title' => $page->title,
                'content' => $page->content,
            ],
        ]);
    }

    public function post(string $slug): Response|SymfonyResponse
    {
        if (! $this->validSlug($slug)) {
            return $this->notFound();
        }

        $post = Post::query()
            ->where('slug', $slug)
            ->where('private', false)
            ->first();

        if (! $post) {
            return $this->notFound();
        }

        return Inertia::render('CmsPost', [
            'post' => [
                'title' => $post->title,
                'content' => $post->content,
            ],
        ]);
    }

    public function products(Request $request): Response
    {
        $categoryId = $request->integer('category') ?: null;

        $products = Product::query()
            ->with(['category', 'images'])
            ->where('active', true)
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderByDesc('featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Products/Index', [
            'products' => $this->paginatedProducts($products),
            'categories' => $this->activeCategories(),
            'filters' => [
                'category' => $categoryId,
            ],
        ]);
    }

    public function product(int $product): Response|SymfonyResponse
    {
        $product = Product::query()
            ->with(['category', 'images', 'variants.images'])
            ->where('active', true)
            ->find($product);

        if (! $product) {
            return $this->notFound();
        }

        return Inertia::render('Products/Show', [
            'product' => array_merge($this->productSummary($product), [
                'long_description' => $product->long_description,
                'options' => $product->options,
                'variants' => $product->variants
                    ->where('active', true)
                    ->map(fn (Product $variant) => $this->productSummary($variant))
                    ->values(),
            ]),
        ]);
    }

    public function category(int $category): Response|SymfonyResponse
    {
        $category = Category::query()
            ->with(['images'])
            ->where('active', true)
            ->find($category);

        if (! $category) {
            return $this->notFound();
        }

        return Inertia::render('Categories/Show', [
            'category' => $this->categorySummary($category),
            'products' => Product::query()
                ->with(['category', 'images'])
                ->where('active', true)
                ->where('category_id', $category->id)
                ->latest()
                ->get()
                ->map(fn (Product $product) => $this->productSummary($product)),
            'bundles' => Bundle::query()
                ->with(['category', 'images'])
                ->where('active', true)
                ->where('category_id', $category->id)
                ->latest()
                ->get()
                ->map(fn (Bundle $bundle) => $this->bundleSummary($bundle)),
        ]);
    }

    public function notFound(): SymfonyResponse
    {
        return Inertia::render('NotFound')
            ->toResponse(request())
            ->setStatusCode(404);
    }

    private function validSlug(string $slug): bool
    {
        return Validator::make(['slug' => $slug], ['slug' => ['required', 'alpha_dash']])->passes();
    }

    private function productSummary(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'short_description' => $product->short_description,
            'price' => number_format((float) $product->price, 2),
            'featured' => (bool) $product->featured,
            'image' => $this->imageUrl($product),
            'category' => $product->category ? $this->categorySummary($product->category) : null,
            'url' => route('redminstore.products.show', $product->id),
        ];
    }

    private function bundleSummary(Bundle $bundle): array
    {
        return [
            'id' => $bundle->id,
            'name' => $bundle->name,
            'sku' => $bundle->sku,
            'short_description' => $bundle->short_description,
            'price' => number_format((float) $bundle->price, 2),
            'image' => $this->imageUrl($bundle),
        ];
    }

    private function categorySummary(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'short_description' => $category->short_description,
            'long_description' => $category->long_description,
            'image' => $this->imageUrl($category),
            'url' => route('redminstore.categories.show', $category->id),
        ];
    }

    private function contentSummary(Page|Post $content, string $type): array
    {
        return [
            'id' => $content->id,
            'title' => $content->title,
            'slug' => $content->slug,
            'url' => route("redminstore.{$type}s.show", $content->slug),
        ];
    }

    private function paginatedProducts(LengthAwarePaginator $products): array
    {
        return [
            'data' => $products->getCollection()
                ->map(fn (Product $product) => $this->productSummary($product))
                ->values(),
            'links' => $products->linkCollection(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
        ];
    }

    private function activeCategories(): array
    {
        return Category::query()
            ->where('active', true)
            ->orderByDesc('order')
            ->orderBy('name')
            ->get()
            ->map(fn (Category $category) => $this->categorySummary($category))
            ->all();
    }

    private function imageUrl($model): ?string
    {
        $image = $model->relationLoaded('images') ? $model->images->first() : $model->images()->first();

        if (! $image || ! $image->path) {
            return null;
        }

        if (str_starts_with($image->path, 'http://') || str_starts_with($image->path, 'https://')) {
            return $image->path;
        }

        return asset(ltrim($image->path, '/'));
    }
}
