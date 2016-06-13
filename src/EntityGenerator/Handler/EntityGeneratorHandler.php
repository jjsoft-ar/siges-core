<?php

namespace JJSoft\SigesCore\EntityGenerator\Handler;

use JJSoft\SigesCore\EntityGenerator\EntityModel;
use JJSoft\SigesCore\EntityGenerator\Events\EntityWasCreated;

/**
 * Class EntityGeneratorHandler
 * @package JJSoft\SigesCore\EntityGenerator\Handler
 */
class EntityGeneratorHandler
{
    /**
     * Creates the Entity Record
     * @param $command
     * @return static
     */
    public function handle($command)
    {
        $entity = EntityModel::create((array) $command);
        event(new EntityWasCreated($entity));
        return $entity;
    }
}
