<?php

namespace JJSoft\SigesCore\Traits;

/**
 * Trait EntityManager
 * Use it to Manage Entities and fields in your classes
 * @author Jose Luis Fonseca <jose@ditecnologia.com>
 * @package JJSoft\SigesCore\Traits
 */
trait EntityManager
{
    use DispatchesCommands;

    /**
     * Generate an entity
     * @param array $data
     * @return mixed
     */
    public function generateEntity(array $data = [])
    {
        return $this->execute('JJSoft\SigesCore\EntityGenerator\EntityGeneratorCommand',
            'JJSoft\SigesCore\EntityGenerator\Handler\EntityGeneratorHandler', $data, [
                'JJSoft\SigesCore\EntityGenerator\Middleware\EntityGeneratorValidator',
                'JJSoft\SigesCore\EntityGenerator\Middleware\SetPrefixAndTableName'
            ]);
    }

    /**
     * Generate a field for an entity
     * @param array $data
     * @return mixed
     */
    public function generateField(array $data = [])
    {
        return $this->execute('JJSoft\SigesCore\FieldGenerator\CreateFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\CreateFieldCommandHandler', $data, [
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldGeneratorValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldTypeValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOrderSetter',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
            ]);
    }

    /**
     * Edit a field
     * @param array $data
     * @return mixed
     */
    public function editField(array $data = [])
    {
        return $this->execute('JJSoft\SigesCore\FieldGenerator\EditFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\EditFieldCommandHandler', $data, [
                'JJSoft\SigesCore\FieldGenerator\Middleware\EditFieldTypeValidator',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CreateTheFieldSlug',
                'JJSoft\SigesCore\FieldGenerator\Middleware\SetFieldTypeOnEdit',
                'JJSoft\SigesCore\FieldGenerator\Middleware\SetCommandDataFromEditFieldModel',
                'JJSoft\SigesCore\FieldGenerator\Middleware\CallPreAssignEventOnField',
                'JJSoft\SigesCore\FieldGenerator\Middleware\FieldOptionsSerializer',
            ]);
    }

    /**
     * Delete a Field
     * @param $id
     * @return mixed
     */
    public function deleteField($id)
    {
        return $this->execute('JJSoft\SigesCore\FieldGenerator\DeleteFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\DeleteFieldCommandHandler', [
            'id' => $id
        ]);
    }

    /**
     * Re order from a field
     * @param $id
     * @param $order
     * @return mixed
     */
    public function reOrderField($items)
    {
        return $this->execute('JJSoft\SigesCore\FieldGenerator\ReOrderFieldCommand',
            'JJSoft\SigesCore\FieldGenerator\Handler\ReOrderFieldCommandHandler', [
                'fields' => $items
            ]);
    }
}
