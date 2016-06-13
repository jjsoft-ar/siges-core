<?php

namespace JJSoft\SigesCore\Tests\EntityEntries;

use JJSoft\SigesCore\Tests\TestCase;

class TestEntriesCommands extends TestCase{

    protected function setFieldsForEntryTests($entity)
    {
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler');
        $fields = [
            [
                'entity_id' => $entity->id,
                'name' => 'first name',
                'description' => 'field Description',
                'slug' => 'first_name',
                'locked' => 1,
                'create_field' => 1,
                'type' => 'text',
                'default' => 'defaultOne',
                'required' => 1,
                'options' => [
                    'foo' => 'bar'
                ],
                'order' => 1
            ],
            [
                'entity_id' => $entity->id,
                'name' => 'last name',
                'description' => 'field Description',
                'slug' => 'last_name',
                'locked' => 1,
                'create_field' => 1,
                'type' => 'text',
                'options' => [
                    'foo' => 'bar'
                ],
                'order' => 2
            ]
        ];
        $fieldsGenerated = [];
        foreach($fields as $field)
        {
            $fieldsGenerated[] = $bus->dispatch('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand', $field, [
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
            ]);
        }
        return $fieldsGenerated;
    }

    public function getEntityWithFields()
    {
        $entity = $this->getAnEntity();
        $this->setFieldsForEntryTests($entity);
        return $entity;
    }


    /**
     * @expectedException JJSoft\SigesCore\Exceptions\EntryValidationException
     */
    public function test_it_validates_an_entry_for_entity_and_throws_exception_if_missing_data()
    {
        $this->migrateDatabase();
        $entity = $this->getEntityWithFields();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Entries\CreateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\CreateEntryCommandHandler');
        $bus->dispatch('JJSoft\SigesCore\Entries\CreateEntryCommand', [
            'entity' => $entity->id,
            'input' => [
                'last_name' => 'Fonseca'
            ]
        ], [
            'JJSoft\SigesCore\Entries\Middleware\SetEntity',
            'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
            'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
            'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
        ]);
    }

    public function test_it_runs_pre_save_method_in_field_type()
    {
        $this->migrateDatabase();
        $entity = $this->getEntityWithFields();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Entries\CreateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\CreateEntryCommandHandler');
        $entry = $bus->dispatch('JJSoft\SigesCore\Entries\CreateEntryCommand', [
            'entity' => $entity->id,
            'input' => [
                'first_name' => 'JOSE LUIS',
                'last_name' => 'Fonseca'
            ]
        ], [
            'JJSoft\SigesCore\Entries\Middleware\SetEntity',
            'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
            'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
            'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
        ]);
        $this->assertEquals('jose luis', $entry['input']['first_name']);
    }

    public function test_it_saves_the_entry()
    {
        $this->migrateDatabase();
        $entity = $this->getEntityWithFields();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Entries\CreateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\CreateEntryCommandHandler');
        $bus->dispatch('JJSoft\SigesCore\Entries\CreateEntryCommand', [
            'entity' => $entity->id,
            'input' => [
                'first_name' => 'Jose Luis',
                'last_name' => 'Fonseca'
            ]
        ], [
            'JJSoft\SigesCore\Entries\Middleware\SetEntity',
            'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
            'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
            'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
        ]);
        $this->seeInDatabase($entity->getTableName(), [
            'first_name' => 'jose luis',
            'last_name' => 'fonseca'
        ]);
    }

}