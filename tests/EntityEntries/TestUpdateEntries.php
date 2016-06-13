<?php

namespace JJSoft\SigesCore\Tests\EntityEntries;

class TestUpdateEntries extends TestEntriesCommands{

    protected function prepare()
    {
        $this->migrateDatabase();
        $entity = $this->getEntityWithFields();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Entries\CreateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\CreateEntryCommandHandler');
        $command = $bus->dispatch('JJSoft\SigesCore\Entries\CreateEntryCommand', [
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
        return [
            'entry_id' => $command['entry_id'],
            'input' => $command['input'],
            'entity' => $entity
        ];
    }

    public function test_it_edits_an_entry()
    {
        $preparedData = $this->prepare();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Entries\UpdateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\UpdateEntryCommandHandler');
        $command = $bus->dispatch('JJSoft\SigesCore\Entries\UpdateEntryCommand', [
            'entity' => $preparedData['entity']->id,
            'entry_id' => $preparedData['entry_id'],
            'input' => [
                'first_name' => 'Fabien',
                'last_name' => 'Symfony'
            ]
        ], [
            'JJSoft\SigesCore\Entries\Middleware\SetEntity',
            'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
            'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
            'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
        ]);
        $this->seeInDatabase($preparedData['entity']->getTableName(), [
            'id' => $preparedData['entry_id'],
            'first_name' => 'fabien',
            'last_name' => 'symfony'
        ]);
    }

}