<?php

namespace JJSoft\SigesCore\FieldGenerator\Listeners;

use Illuminate\Support\Facades\Schema;
use JJSoft\SigesCore\FieldGenerator\Events\FieldWasCreated;
use JJSoft\SigesCore\FieldGenerator\Events\FieldWasCreatedInDb;

/**
 * Class CreateColumnInDatabase
 * @package JJSoft\SigesCore\FieldGenerator\Listeners
 */
class CreateColumnInDatabase
{
    /**
     * Once the field has been created in the DB Record
     * The column in the entoty table will be created.
     * @param FieldWasCreated $event
     */
    public function handle(FieldWasCreated $event)
    {
        $field = $event->field;
        if ($field->create_field) {
            Schema::table($event->field->entity->getTableName(), function ($table) use ($field) {
                $table->{$field->getType()->getColumnType()}($field->slug)->nullable()->default($field->default);
            });
            event(new FieldWasCreatedInDb($field));
        }
    }
}
