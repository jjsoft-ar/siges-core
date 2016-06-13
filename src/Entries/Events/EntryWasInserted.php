<?php

namespace JJSoft\SigesCore\Entries\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\EntityGenerator\EntityModel;

/**
 * Class EntryWasInserted
 * @package JJSoft\SigesCore\Entries\Events
 */
class EntryWasInserted extends Event
{
    /**
     * @var EntityModel
     */
    public $entity;

    /**
     * @var
     */
    public $entry;

    /**
     *
     * @var
     */
    public $data;

    /**
     * @param EntityModel $entity
     * @param $entry
     */
    public function __construct(EntityModel $entity, $entry, $data)
    {
        $this->entity = $entity;
        $this->entry = $entry;
        $this->data = $data;
    }
}
