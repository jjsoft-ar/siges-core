<?php

namespace JJSoft\SigesCore\FieldGenerator\Middleware;

use JJSoft\SigesCore\FieldGenerator\FieldModel;
use League\Tactician\Middleware;

class SetCommandDataFromEditFieldModel implements Middleware
{
    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $model = FieldModel::find($command->id);
        if (!isset($command->locked)) {
            $command->locked = $model->locked;
        }
        return $next($command);
    }
}
