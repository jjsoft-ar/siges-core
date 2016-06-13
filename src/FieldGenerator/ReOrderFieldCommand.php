<?php

namespace JJSoft\SigesCore\FieldGenerator;

/**
 * Class ReOrderFieldCommand
 * @package JJSoft\SigesCore\FieldGenerator
 */
class ReOrderFieldCommand
{
    /**
     * @var
     */
    public $fields;

    /**
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }
}
