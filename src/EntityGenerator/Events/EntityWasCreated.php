<?php

namespace JJSoft\SigesCore\EntityGenerator\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\EntityGenerator\EntityModel;

/**
 * Class EntityWasCreated
 * @package JJSoft\SigesCore\EntityGenerator\Events
 */
class EntityWasCreated extends Event
{
    /**
     * Entity generated
     * @var
     */
    public $entity;

    /**
     * @param EntityModel $model
     */
    public function __construct(EntityModel $model)
    {
        $this->entity = $model;
    }
}
