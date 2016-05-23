<?php

namespace JJSoft\SigesCore\Notifications\SendAppNotification\Handler;

use JJSoft\SigesCore\Notifications\SendAppNotification\Notification;
use JJSoft\SigesCore\Notifications\SendAppNotification\Events\NotificationWasSent;

class SendAppNotificationCommandHandler
{
    public function handle($command)
    {
        $notification = Notification::create((array) $command);
        event(new NotificationWasSent($notification));
        return $notification;
    }
}
