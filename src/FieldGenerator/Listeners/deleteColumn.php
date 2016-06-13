<?php

namespace JJSoft\SigesCore\FieldGenerator\Listeners;

use JJSoft\SigesCore\EntityGenerator\EntityModel;
use JJSoft\SigesCore\FieldGenerator\Events\FieldWasDeleted;
use Illuminate\Support\Facades\Schema;

class DeleteColumn
{
    public function handle(FieldWasDeleted $event)
    {
        $field = $event->field;
        $entity = EntityModel::find($field['entity_id']);
        Schema::table($entity->getTableName(), function ($table) use ($field) {
            $table->dropColumn($field['slug']);
        });
    }
}
