<?php

namespace Redooor\Redminstore\Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminportal\App\Models\Post;
use Redooor\Redminstore\Tests\RedminTestCase;

class StorefrontPageTest extends RedminTestCase
{
    public function test_home_route_renders_inertia(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('featuredProducts')
                ->has('pages')
                ->has('posts'));
    }

    public function test_public_page_slug_renders(): void
    {
        Page::create([
            'title' => 'About',
            'slug' => 'about',
            'content' => '<p>Hello</p>',
            'private' => false,
        ]);

        $this->get('/page/about')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('CmsPage')
                ->where('page.title', 'About'));
    }

    public function test_private_page_slug_returns_not_found(): void
    {
        Page::create([
            'title' => 'Private',
            'slug' => 'private',
            'content' => '<p>Hidden</p>',
            'private' => true,
        ]);

        $this->get('/page/private')
            ->assertStatus(404)
            ->assertInertia(fn (Assert $page) => $page->component('NotFound'));
    }

    public function test_invalid_page_slug_returns_not_found(): void
    {
        $this->get('/page/not-valid!')
            ->assertStatus(404)
            ->assertInertia(fn (Assert $page) => $page->component('NotFound'));
    }

    public function test_public_post_slug_renders(): void
    {
        Post::create([
            'title' => 'Launch',
            'slug' => 'launch',
            'content' => '<p>Published</p>',
            'private' => false,
        ]);

        $this->get('/post/launch')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('CmsPost')
                ->where('post.title', 'Launch'));
    }
}
