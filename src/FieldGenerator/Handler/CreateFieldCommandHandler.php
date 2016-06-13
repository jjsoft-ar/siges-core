<?php

namespace JJSoft\SigesCore\FieldGenerator\Handler;

use JJSoft\SigesCore\FieldGenerator\FieldModel;
use JJSoft\SigesCore\EntityGenerator\EntityModel;
use JJSoft\SigesCore\FieldGenerator\Events\FieldWasCreated;

/**
 * Class FieldGeneratorHandler
 * @package JJSoft\SigesCore\FieldGenerator\Handler
 */
class CreateFieldCommandHandler
{
    /**
     * Handle the creation of the Field in the Database
     * @param $command
     * @return static
     */
    public function handle($command)
    {
        $command->namespace = EntityModel::find($command->entity_id)->namespace;
        $field = FieldModel::create((array) $command);
        event(new FieldWasCreated($field));
        return $field;
    }
}
