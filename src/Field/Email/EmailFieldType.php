<?php

namespace JJSoft\SigesCore\Field\Email;

use Field;
use JJSoft\SigesCore\Field\FieldTypeInterface;
use JJSoft\SigesCore\Field\FieldTypeImplementationTrait;

/**
 * Class EmailFieldType
 * @package JJSoft\SigesCore\Field\Email
 */
class EmailFieldType implements FieldTypeInterface
{
    use FieldTypeImplementationTrait;

    /**
     * @var
     */
    private $value;

    /**
     * @var string
     */
    protected $columnType = "string";

    /**
     * The field type name
     * @var string
     */
    public $name = "Email";

    /**
     * get the column type for this field type
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * Set a value for this field;
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


    /**
     * get the value for the field
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the presenter class if any
     * @return mixed
     */
    public function present()
    {
        return Field::email($this->fieldSlug, $this->value, ['label' => $this->fieldName]);
    }

    /**
     * Que the form for the options of the field type
     * @return mixed
     */
    public function getOptionsForm()
    {
        return view('sigesCore::field.types.email.optionsForm')->render();
    }

    /**
     * @return mixed
     */
    public function presentFront()
    {
        return $this->value;
    }
}
