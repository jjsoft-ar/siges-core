<?php

namespace JJSoft\SigesCore\FieldGenerator\Events;

use JJSoft\SigesCore\Events\Event;

class FieldWasDeleted extends Event
{
    /**
     * Field generated
     * @var
     */
    public $field;

    /**
     * The model info deleted
     * @param array $modelArray
     */
    public function __construct($modelArray)
    {
        $this->field = $modelArray;
    }
}
