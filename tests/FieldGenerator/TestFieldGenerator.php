<?php

namespace JJSoft\SigesCore\Tests\FieldGenerator;

use JJSoft\SigesCore\Tests\TestCase;
use JJSoft\SigesCore\FieldGenerator\FieldModel;
use JJSoft\SigesCore\Exceptions\FieldTypeNotRegistered;

/**
 * Class TestEntityGenerator
 * @package JJSoft\SigesCore\Tests\EntityGenerator
 */
class TestFieldGenerator extends TestCase
{

    /**
     *
     */
    public function test_it_gets_the_field_generator_command()
    {
        $FieldCreatorCommand = app('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand');
        $this->assertInstanceOf('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            $FieldCreatorCommand);
    }

    public function test_it_validates_field_type_is_valid()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        try {
            $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
                'entity_id' => $this->getAnEntity()->id,
                'name' => 'first name',
                'description' => 'field Description',
                'slug' => 'first_name',
                'locked' => 1,
                'create_field' => 1,
                'type' => 'text'
            ], [
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
            ]);
            $this->assertTrue(true);
        } catch (FieldTypeNotRegistered $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * @expectedException JJSoft\SigesCore\Exceptions\FieldTypeNotRegistered
     */
    public function test_it_validates_field_type_is_invalid()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $this->getAnEntity()->id,
            'name' => 'first name',
            'description' => 'field Description',
            'slug' => 'first_name',
            'locked' => 1,
            'create_field' => 1,
            'type' => 'someFieldType'
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
    }

    /**
     * @expectedException JJSoft\SigesCore\Exceptions\FieldValidationException
     */
    public function test_it_validates_field_to_add()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'locked' => 1,
            'create_field' => 1,
            'type' => 'text'
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
    }

    public function test_it_creates_the_field_in_db()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'first name',
            'description' => 'field Description',
            'slug' => 'first_name',
            'locked' => 1,
            'create_field' => 1,
            'type' => 'text'
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'first_name']);
    }

    public function test_it_creates_the_field_in_table()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'first name',
            'description' => 'field Description',
            'slug' => 'first_name',
            'locked' => 1,
            'create_field' => 1,
            'type' => 'text'
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'first_name']);
        $this->assertTrue(\Schema::hasColumn($entity->getTableName(), 'first_name'));
    }

    public function test_it_does_not_creates_the_field_in_table_as_per_instruction()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'first name',
            'description' => 'field Description',
            'slug' => 'first_name',
            'locked' => 1,
            'create_field' => 0,
            'type' => 'text'
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'first_name']);
        $this->assertFalse(\Schema::hasColumn($entity->getTableName(), 'first_name'));
    }

    public function test_serializes_the_options_property()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $field = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'first name',
            'description' => 'field Description',
            'slug' => 'first_name',
            'locked' => 1,
            'create_field' => 0,
            'type' => 'text',
            'options' => [
                'foo' => 'bar'
            ]
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->assertEquals(serialize(['foo' => 'bar']), $field->options);
    }

    public function test_order_the_fields()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $this->setSomeFields($entity);
        $field = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'address',
            'description' => 'field Description',
            'slug' => 'address',
            'locked' => 1,
            'create_field' => 1,
            'type' => 'text',
            'options' => [
                'foo' => 'bar'
            ]
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->assertEquals(3, $field->order);
    }

    public function test_order_the_fields_when_default_order_provided()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $entity = $this->getAnEntity();
        $this->setSomeFields($entity);
        $field = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', [
            'entity_id' => $entity->id,
            'name' => 'address',
            'description' => 'field Description',
            'slug' => 'address',
            'locked' => 1,
            'create_field' => 1,
            'type' => 'text',
            'options' => [
                'foo' => 'bar'
            ],
            'order' => 1
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->assertEquals(1, $field->order);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'first_name', 'order' => 2]);
    }

    public function test_it_edits_a_field()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\EditFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\EditFieldCommandHandler');
        $entity = $this->getAnEntity();
        $fields = $this->setSomeFields($entity);
        $field = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\EditFieldCommand', [
            'id' => $fields[0]->id,
            'name' => 'address',
            'description' => 'field Description',
            'default' => 'defaultTwo',
            'required' => $fields[0]->required,
            'options' => unserialize($fields[0]->options)
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\EditFieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\SetFieldTypeOnEdit',
            'JJSoft\SigesCore\FieldGenerator\Middleware\SetCommandDataFromEditFieldModel',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->assertEquals('defaultTwo', $field->default);
    }

    public function test_it_edits_a_field_in_db()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\EditFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\EditFieldCommandHandler');
        $entity = $this->getAnEntity();
        $fields = $this->setSomeFields($entity);
        $field = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\EditFieldCommand', [
            'id' => $fields[0]->id,
            'name' => 'address',
            'description' => 'field Description',
            'default' => 'defaultTwo',
            'required' => $fields[0]->required,
            'options' => unserialize($fields[0]->options)
        ], [
            'JJSoft\SigesCore\FieldGenerator\Middleware\EditFieldTypeValidator',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
            'JJSoft\SigesCore\FieldGenerator\Middleware\SetFieldTypeOnEdit',
            'JJSoft\SigesCore\FieldGenerator\Middleware\SetCommandDataFromEditFieldModel',
            'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
            'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
        ]);
        $this->assertEquals('address', $field->slug);
        $this->assertFalse(\Schema::hasColumn($fields[0]->entity->getTableName(), 'first_name'));
        $this->assertTrue(\Schema::hasColumn($fields[0]->entity->getTableName(), 'address'));
    }

    public function test_it_re_order_fields()
    {
        $this->migrateDatabase();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\ReOrderFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\ReOrderFieldCommandHandler');
        $entity = $this->getAnEntity();
        $fields = $this->setSomeFields($entity);
        $bus->dispatch('JJSoft\SigesCore\FieldGenerator\ReOrderFieldCommand', [
            'fields' => [
                $fields[1]->id,
                $fields[0]->id
            ]
        ], [

        ]);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'last_name', 'order' => 1]);
        $this->seeInDatabase('app_entities_fields', ['entity_id' => $entity->id, 'slug' => 'first_name', 'order' => 2]);
    }

}