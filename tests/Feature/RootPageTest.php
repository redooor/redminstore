<?php

namespace Redooor\Redminstore\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminstore\Tests\RedminTestCase;

class RootPageTest extends RedminTestCase
{
    private function page(string $slug, bool $private = false): Page
    {
        return Page::create(['title' => ucfirst($slug), 'slug' => $slug, 'content' => '<p>Hi</p>', 'private' => $private]);
    }

    public function test_public_page_is_served_at_root(): void
    {
        $this->page('about');

        $this->get('/about')
            ->assertOk()
            ->assertInertia(fn (Assert $p) => $p->component('CmsPage')->where('page.title', 'About'));
    }

    public function test_private_and_unknown_slugs_use_the_normal_404(): void
    {
        $this->page('secret', private: true);

        $this->get('/secret')->assertNotFound();
        $this->get('/nothing-here')->assertNotFound();
        $this->get('/about/team')->assertNotFound();
    }

    public function test_real_routes_win_over_a_page_with_the_same_slug(): void
    {
        $this->page('products');

        $this->get('/products')->assertInertia(fn (Assert $p) => $p->component('Products/Index'));
    }

    public function test_routes_registered_later_by_the_app_win_too(): void
    {
        $this->page('hello');
        Route::middleware('web')->get('/hello', fn () => 'app route');

        $this->get('/hello')->assertOk()->assertSee('app route');
    }

    public function test_home_links_pages_at_root(): void
    {
        $this->page('about');

        $this->get('/')->assertInertia(fn (Assert $p) => $p->where('pages.0.url', url('/about')));
    }

    public function test_page_prefix_redirects_to_root(): void
    {
        $this->page('about');

        $this->get('/page/about')->assertStatus(301)->assertRedirect('/about');
    }

    public function test_head_request_is_served(): void
    {
        $this->page('about');

        $this->call('HEAD', '/about')->assertOk();
    }

    public function test_turning_the_option_off_at_runtime_disables_a_cached_fallback(): void
    {
        $this->page('about');
        config(['redminstore.pages_at_root' => false]);

        $this->get('/about')->assertNotFound();
    }
}
