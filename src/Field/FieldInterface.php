<?php

namespace JJSoft\SigesCore\Field;

/**
 * Interface FieldInterface
 * @package JJSoft\SigesCore\Field
 */
interface FieldInterface
{
    /**
     * Set the field type for this field
     * @param FieldTypeInterface $type
     * @return mixed
     */
    public function setType(FieldTypeInterface $type);
}
