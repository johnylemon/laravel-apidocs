<?php

namespace Johnylemon\Apidocs\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->getEnvironmentSetUp($this->app);

        config()->set('laravel-apidocs', require __DIR__.'/../config/laravel-apidocs.php');
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return ['Johnylemon\\Apidocs\\Providers\ApidocsServiceProvider'];
    }
}
