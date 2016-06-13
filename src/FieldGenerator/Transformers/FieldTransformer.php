<?php

namespace JJSoft\SigesCore\FieldGenerator\Transformers;

use League\Fractal\TransformerAbstract;
use JJSoft\SigesCore\FieldGenerator\FieldModel;

class FieldTransformer extends TransformerAbstract
{
    public function transform(FieldModel $field)
    {
        $fieldTypes = app('field.types');
        $type = $fieldTypes->getFieldClass($field->type);
        return [
            'id' => $field->id,
            'namespace' => $field->namespace,
            'name' => $field->name,
            'description' => $field->description,
            'slug' => $field->slug,
            'type' => $field->type,
            'options' => unserialize($field->options),
            'locked' => (bool) $field->locked,
            'hidden' => (bool) $field->hidden,
            'order' => $field->order,
            'default' => $field->default,
            'required' => (string)$field->required,
            'fieldType' => [
                'name' => $type->name
            ]
        ];
    }
}
