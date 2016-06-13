<?php

namespace JJSoft\SigesCore\Field;

/**
 * Trait FieldTypeImplementationTrait
 * @package JJSoft\SigesCore\Field
 */
trait FieldTypeImplementationTrait
{
    /**
     * Gererate a slug based on name or other parameter
     * @param $name
     * @return string
     */
    public function generateSlug($name)
    {
        return str_slug($name);
    }

    /**
     * Pre Assign Event to do anything the fieldType needs to.
     * @param $command
     */
    public function preAssignEvent($command)
    {
    }

    /**
     * By default wont do anything before saving
     * @param $value
     * @return mixed
     */
    public function preSaveEvent($value)
    {
        return $value;
    }

    /**
     * By default it returns the raw value
     * @return mixed
     */
    public function presentFront()
    {
        return $this->value;

    }
}
