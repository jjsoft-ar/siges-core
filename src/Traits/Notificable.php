<?php

namespace JJSoft\SigesCore\Traits;

use JJSoft\SigesCore\Notifications\SendAppNotification\Middleware\SetTheUserId;
use JJSoft\SigesCore\Notifications\SendAppNotification\SendAppNotificationCommand;
use JJSoft\SigesCore\Notifications\SendAppNotification\Handler\SendAppNotificationCommandHandler;

/**
 * Trait Notificable
 * Use this trait to send notifications to a User.
 * @author Jose Fonseca <jose@ditecnologia.com>
 * @package JJSoft\SigesCore\Traits
 */
trait Notificable
{
    use DispatchesCommands;

    /**
     * @param object $user
     * @param $message
     * @param string $type
     * @param $link must be resolvable by url() helper
     */
    public function sendAppNotification($user, $message, $type = "info", $link = null)
    {
        $this->execute(SendAppNotificationCommand::class, SendAppNotificationCommandHandler::class, [
            'user' => $user,
            'type' => $type,
            'message' => $message,
            'link' => $link
        ], [
            SetTheUserId::class
        ]);
    }
}
