<?php

namespace JJSoft\SigesCore\FieldGenerator\Handler;

use JJSoft\SigesCore\FieldGenerator\FieldModel;

/**
 * Class ReOrderFieldCommandHandler
 * @package JJSoft\SigesCore\FieldGenerator\Handler
 */
class ReOrderFieldCommandHandler
{
    /**
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $order = 1;
        foreach ($command->fields as $field) {
            $f = FieldModel::find($field);
            $f->order = $order;
            $f->save();
            $order++;
        }
        return $field;
    }
}
