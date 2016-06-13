<?php

namespace JJSoft\SigesCore\Traits;

/**
 * Trait EntryManager
 * Use this trait to manage entries for the entities
 * @author Jose Luis Fonseca <jose@ditecnologia.com>
 * @package JJSoft\SigesCore\Traits
 */
trait EntryManager
{
    use DispatchesCommands;

    /**
     * @param $entityId
     * @param array $input
     * @return mixed
     */
    public function createEntry($entityId, array $input = [])
    {
        $input['entity'] = $entityId;
        return $this->execute('JJSoft\SigesCore\Entries\CreateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\CreateEntryCommandHandler', $input, [
                'JJSoft\SigesCore\Entries\Middleware\SetEntity',
                'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
                'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
                'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
            ]);
    }

    /**
     * @param $entityId
     * @param array $input
     * @return mixed
     */
    public function updateEntry($entityId, $entryId, array $input = [])
    {
        $input['entity'] = $entityId;
        $input['entry_id'] = $entryId;
        return $this->execute('JJSoft\SigesCore\Entries\UpdateEntryCommand',
            'JJSoft\SigesCore\Entries\Handler\UpdateEntryCommandHandler', $input, [
                'JJSoft\SigesCore\Entries\Middleware\SetEntity',
                'JJSoft\SigesCore\Entries\Middleware\ValidateEntryData',
                'JJSoft\SigesCore\Entries\Middleware\FilterFieldFromInput',
                'JJSoft\SigesCore\Entries\Middleware\RunPreSaveEvent'
            ]);
    }
}
