<?php

namespace JJSoft\SigesCore\FieldGenerator\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\FieldGenerator\FieldModel;

/**
 * Class FieldWasEdited
 * @package JJSoft\SigesCore\FieldGenerator\Events
 */
class FieldWasEdited extends Event
{
    /**
     * Field generated
     * @var
     */
    public $field;

    /**
     * @var bool
     */
    public $rename = false;

    /**
     * Old Slug
     */
    public $oldSlug;

    /**
     * The model created
     * @param FieldModel $model
     */
    public function __construct(FieldModel $model, $rename, $oldSlug = "")
    {
        $this->field = $model;
        $this->rename = $rename;
        $this->oldSlug = $oldSlug;
    }
}
