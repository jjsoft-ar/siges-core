<?php

namespace JJSoft\SigesCore\Entries\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\EntityGenerator\EntityModel;

/**
 * Class EntryWasUpdated
 * @package JJSoft\SigesCore\Entries\Events
 */
class EntryWasUpdated extends Event
{
    /**
     * @var EntityModel
     */
    public $entity;

    /**
     * @var
     */
    public $entry_id;

    /**
     *
     * @var
     */
    public $data;

    /**
     * @param EntityModel $entity
     * @param $entry
     */
    public function __construct(EntityModel $entity, $entry_id, $data)
    {
        $this->entity = $entity;
        $this->entry_id = $entry_id;
        $this->data = $data;
    }
}
