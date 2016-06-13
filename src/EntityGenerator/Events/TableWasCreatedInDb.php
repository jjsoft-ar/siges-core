<?php

namespace JJSoft\SigesCore\EntityGenerator\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\EntityGenerator\EntityModel;

class TableWasCreatedInDb extends Event
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
