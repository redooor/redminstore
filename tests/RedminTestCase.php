<?php

namespace Redooor\Redminstore\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Redooor\Redminportal\RedminportalServiceProvider;
use Redooor\Redminstore\RedminstoreServiceProvider;

abstract class RedminTestCase extends TestbenchTestCase
{
    public static function applicationBasePath()
    {
        return dirname(__DIR__);
    }

    protected function getPackageProviders($app): array
    {
        return [
            InertiaServiceProvider::class,
            RedminportalServiceProvider::class,
            RedminstoreServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        $app['config']->set('app.url', 'http://localhost');
        $app['config']->set('inertia.testing.page_paths', [
            dirname(__DIR__) . '/src/resources/js/Pages',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        Artisan::call('migrate', [
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__ . '/../vendor/redooor/redminportal/src/database/migrations')
                ?: '/Users/andrewsang/Development/redooor/redminportal/src/database/migrations',
        ]);
    }
}
