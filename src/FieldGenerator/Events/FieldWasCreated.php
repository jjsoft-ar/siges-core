<?php

namespace JJSoft\SigesCore\FieldGenerator\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\FieldGenerator\FieldModel;

/**
 * Class EntityWasCreated
 * @package JJSoft\SigesCore\FieldGenerator\Events
 */
class FieldWasCreated extends Event
{
    /**
     * Field generated
     * @var
     */
    public $field;

    /**
     * The model created
     * @param FieldModel $model
     */
    public function __construct(FieldModel $model)
    {
        $this->field = $model;
    }
}
