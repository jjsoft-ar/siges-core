<?php

namespace JJSoft\SigesCore\FieldGenerator;

/**
 * Class DeleteFieldCommand
 * @package JJSoft\SigesCore\FieldGenerator
 */
class DeleteFieldCommand
{
    /**
     * Field ID
     * @var
     */
    public $id;

    /**
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
