<?php


namespace JJSoft\SigesCore\FieldGenerator\Handler;

use JJSoft\SigesCore\FieldGenerator\FieldModel;
use JJSoft\SigesCore\FieldGenerator\Events\FieldWasDeleted;

class DeleteFieldCommandHandler
{
    public function handle($command)
    {
        $model = FieldModel::find($command->id);
        $modelArray = $model->toArray();
        $model->delete();
        event(new FieldWasDeleted($modelArray));
    }
}
