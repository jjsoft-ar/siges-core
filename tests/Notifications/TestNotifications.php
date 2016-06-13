<?php

namespace JJSoft\SigesCore\Tests\Notifications;

use JJSoft\SigesCore\Tests\Stubs\UserModel;
use JJSoft\SigesCore\Tests\TestCase;

class TestNotifications extends TestCase
{

    /**
     * It can send a notification to a User
     * @test
     */
    public function it_sends_notification_to_user()
    {
        $this->migrateDatabase();
        $this->createUser();
        $user = UserModel::first();
        $bus = app('Joselfonseca\LaravelTactician\CommandBusInterface');
        $bus->addHandler('JJSoft\SigesCore\Notifications\SendAppNotification\SendAppNotificationCommand',
            'JJSoft\SigesCore\Notifications\SendAppNotification\Handler\SendAppNotificationCommandHandler');
        $bus->dispatch('JJSoft\SigesCore\Notifications\SendAppNotification\SendAppNotificationCommand', [
            'user' => $user,
            'type' => 'success',
            'message' => 'Some Message'
        ],
            [
                'JJSoft\SigesCore\Notifications\SendAppNotification\Middleware\SetTheUserId'
            ]);
        $this->seeInDatabase('app_notifications', [
            'user_id' => $user->id,
            'type' => 'success',
            'message' => 'Some Message'
        ]);
    }

}