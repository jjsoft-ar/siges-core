<?php

namespace JJSoft\SigesCore\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use JJSoft\SigesCore\Tests\Stubs\UserModel;

/**
 * Class TestCase
 * @package JJSoft\SigesCore\Tests
 */
class TestCase extends Orchestra{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        // This is a HORRIBLE HACK while Dingo API accepts a PR
        // please check https://github.com/dingo/api/pull/776
        $api = require __DIR__.'/../vendor/dingo/api/config/api.php';
        $app['config']['api'] = $api;
        return [
            'Dingo\Api\Provider\LaravelServiceProvider',
            'JJSoft\SigesCore\Providers\SigesCoreServiceProvider'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('jwt.user', 'JJSoft\SigesCore\Tests\Stubs\UserModel');
    }

    /**
     * Migrate a SQL lite Database to test the package
     */
    protected function migrateDatabase()
    {
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
    }

    protected function createUser()
    {
        UserModel::create([
            'name' => 'test User',
            'email' => 'someuser@example.com',
            'password' => '123456789',
            'uuid' => '74927348972398472398'
        ]);
    }

    /**
     * it Just assert true so phpunit don't cry
     * with this class not having any tests
     */
    public function test_it_asserts_true()
    {
        $this->assertTrue(true);
    }

}