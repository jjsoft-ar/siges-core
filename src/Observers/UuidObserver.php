<?php

namespace JJSoft\SigesCore\Observers;

use Uuid;

/**
 * Class UuidObserver
 * Generate Uuid on creation of a resource
 * @package JJSoft\SigesCore\Observers
 */
class UuidObserver
{
    /**
     * @param $model
     * @throws \Exception
     */
    public function creating($model)
    {
        $model->uuid = Uuid::generate(4);
    }
}