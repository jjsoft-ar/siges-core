<?php

namespace JJSoft\SigesCore\Tests\Providers;

use JJSoft\SigesCore\Tests\TestCase;


/**
 * Class TestServiceProvider
 * @package JJSoft\SigesCore\Tests\Providers
 */
class TestServiceProvider extends TestCase
{

    /**
     * Test if the Service providers is being loaded by the app
     */
    public function test_it_loads_service_provider()
    {
        $this->assertInstanceOf('JJSoft\SigesCore\Providers\SigesCoreServiceProvider',
            app()->getProvider('JJSoft\SigesCore\Providers\SigesCoreServiceProvider'));
    }

    /**
     * Since the service provider is being loaded check if the
     * laravel tactician service provider was also loaded
     */
    public function test_it_loads_laravel_tactician_service_provider()
    {
        $this->assertInstanceOf('Joselfonseca\LaravelTactician\Providers\LaravelTacticianServiceProvider',
            app()->getProvider('Joselfonseca\LaravelTactician\Providers\LaravelTacticianServiceProvider'));
    }
}