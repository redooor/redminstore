<?php

namespace Redooor\Redminstore\Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Redooor\Redminportal\App\Models\Page;
use Redooor\Redminstore\Tests\RedminTestCase;

class RootPageDisabledTest extends RedminTestCase
{
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);
        $app['config']->set('redminstore.pages_at_root', false);
    }

    public function test_pages_stay_under_page_prefix_when_disabled(): void
    {
        Page::create(['title' => 'About', 'slug' => 'about', 'content' => '<p>Hi</p>', 'private' => false]);

        $this->get('/about')->assertNotFound();
        $this->get('/page/about')->assertOk();
        $this->get('/')->assertInertia(fn (Assert $p) => $p->where('pages.0.url', url('/page/about')));
    }
}
