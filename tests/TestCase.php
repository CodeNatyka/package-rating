<?php

namespace Natyka\Test;

use Natyka\Models\Rating;
use Natyka\RatingServiceProvider;
use Natyka\Test\Models\Page;
use Natyka\Test\Models\User;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->withFactories(__DIR__.'/database/factories');

        $this->artisan('migrate', ['--database' => 'sqlite']);
    }

    protected function getPackageProviders($app)
    {
        return [
            RatingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.locale', 'es');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => __DIR__.'/database.sqlite',
            'prefix' => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('auth.providers.pages.model', Page::class);
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
        $app['config']->set('rating.models.rating', Rating::class);
        $app['config']->set('rating.required_approval', false);
        $app['config']->set('rating.from', 1);
        $app['config']->set('rating.to', 10);
    }

    protected function resetDatabase()
    {
        file_put_contents(__DIR__.'/database.sqlite', null);
    }
}
