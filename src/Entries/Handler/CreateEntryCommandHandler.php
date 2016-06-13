<?php

namespace JJSoft\SigesCore\Entries\Handler;

use DB;
use Carbon\Carbon;
use JJSoft\SigesCore\Entries\Events\EntryWasInserted;

/**
 * Class CreateEntryCommandHandler
 * @package JJSoft\SigesCore\Entries\Handler
 */
class CreateEntryCommandHandler
{
    /**
     * Insert the record in the DB
     * @param $command
     */
    public function handle($command)
    {
        $command->input['created_at'] = Carbon::now();
        $command->input['updated_at'] = Carbon::now();
        $entry = DB::table($command->entity->getTableName())->insertGetId($command->input);
        event(new EntryWasInserted($command->entity, $entry, $command->input));
        return [
            'entry_id' => $entry,
            'input' => $command->input
        ];
    }
}
