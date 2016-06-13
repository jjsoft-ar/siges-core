<?php

namespace JJSoft\SigesCore\EntityGenerator\Listeners;

use Illuminate\Support\Facades\Schema;
use JJSoft\SigesCore\EntityGenerator\Events\EntityWasCreated;
use JJSoft\SigesCore\EntityGenerator\Events\TableWasCreatedInDb;

/**
 * Class CreateTableInDatabase
 * @package JJSoft\SigesCore\EntityGenerator\Listeners
 */
class CreateTableInDatabase
{
    /**
     * Handle the event.
     * If the entity is supposed to create a
     * table in the Database, it will do
     * It won't do anything otherwise
     * @param  Events  $event
     * @return void
     */
    public function handle(EntityWasCreated $event)
    {
        if ((bool) $event->entity->create_table) {
            Schema::create($event->entity->table_name, function ($table) {
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
            });
            event(new TableWasCreatedInDb($event->entity));
        }
    }
}
