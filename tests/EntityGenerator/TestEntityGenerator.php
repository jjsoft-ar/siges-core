<?php

namespace JJSoft\SigesCore\Tests\EntityGenerator;

use JJSoft\SigesCore\Tests\TestCase;

/**
 * Class TestEntityGenerator
 * @package JJSoft\SigesCore\Tests\EntityGenerator
 */
class TestEntityGenerator extends TestCase
{

    /**
     *
     */
    public function test_it_gets_the_entity_creator_command()
    {
        $EntityCreatorCommand = app('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand');
        $this->assertInstanceOf('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand', $EntityCreatorCommand);
    }

    /**
     * @expectedException     JJSoft\SigesCore\Exceptions\CommandValidationException
     */
    public function test_it_validates_the_command()
    {
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand',
            'JJSoft\SigesCore\EntityGenerator\Handler\EntityGeneratorHandler');
        $bus->dispatch('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand', [], [
            'JJSoft\SigesCore\EntityGenerator\Middleware\EntityGeneratorValidator',
            'JJSoft\SigesCore\EntityGenerator\Middleware\SetPrefixAndTableName'
        ]);
    }

    /**
     *
     */
    public function test_it_creates_the_entity_in_the_db()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');

        $bus->addHandler('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand',
            'JJSoft\SigesCore\EntityGenerator\Handler\EntityGeneratorHandler');

        $entity = $bus->dispatch('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand', [
            'namespace' => 'jarvis',
            'name' => 'entity name',
            'description' => 'Entity Description',
            'slug' => 'entity_name',
            'locked' => 1
        ], [
            'JJSoft\SigesCore\EntityGenerator\Middleware\EntityGeneratorValidator',
            'JJSoft\SigesCore\EntityGenerator\Middleware\SetPrefixAndTableName'
        ]);

        $this->assertInstanceOf('JJSoft\SigesCore\EntityGenerator\EntityModel', $entity);
        $this->assertEquals('entity name', $entity->name);
    }

    public function test_it_creates_the_table_in_the_db()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');

        $bus->addHandler('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand',
            'JJSoft\SigesCore\EntityGenerator\Handler\EntityGeneratorHandler');

        $bus->dispatch('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand', [
            'namespace' => 'jarvis',
            'name' => 'entity name',
            'description' => 'Entity Description',
            'slug' => 'entity_name',
            'locked' => 1
        ], [
            'JJSoft\SigesCore\EntityGenerator\Middleware\EntityGeneratorValidator',
            'JJSoft\SigesCore\EntityGenerator\Middleware\SetPrefixAndTableName'
        ]);

        $this->assertTrue(\Schema::hasTable('jarvis_entity_name'));
    }

    public function test_it_should_not_create_a_database_table()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');

        $bus->addHandler('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand',
            'JJSoft\SigesCore\EntityGenerator\Handler\EntityGeneratorHandler');

        $bus->dispatch('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand', [
            'namespace' => 'jarvis',
            'name' => 'entity name 2',
            'description' => 'Entity Description',
            'slug' => 'entity_name_2',
            'locked' => 1,
            'create_table' => 0
        ], [
            'JJSoft\SigesCore\EntityGenerator\Middleware\EntityGeneratorValidator',
            'JJSoft\SigesCore\EntityGenerator\Middleware\SetPrefixAndTableName'
        ]);
        $this->seeInDatabase('app_entities', ['slug' => 'entity_name_2']);
        $this->assertFalse(\Schema::hasTable('jarvis_entity_name_2'));
    }

}