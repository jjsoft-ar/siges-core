<?php

namespace JJSoft\SigesCore\Notifications\SendAppNotification\Events;

use JJSoft\SigesCore\Events\Event;
use JJSoft\SigesCore\Notifications\SendAppNotification\Notification;

/**
 * Class NotificationWasSent
 * @package HJJSoft\SigesCore\Notifications\SendAppNotification\Events
 */
class NotificationWasSent extends Event
{
    /**
     * @var Notification
     */
    public $notification;

    /**
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
}
