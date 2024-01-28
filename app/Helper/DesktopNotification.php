<?php

namespace App\Helper;

use App\Helper\Object\NotificationObject;
use App\Models\UserFcm;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DesktopNotification
{
    /**
     * @throws GuzzleException
     */
    public static function sendNotification(NotificationObject $notificationObject): void
    {
        $tokens = UserFcm::query()->whereIn('user_id', $notificationObject->getUserIds())->get();

        $includePlayers = [];

        foreach ($tokens as $token) {
            $includePlayers[] = $token['token'];
        }

        if (empty($includePlayers)) {
            return;
        }

        $client = new Client();

        $client->post('https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Authorization' => 'Basic YjU4ZjFjNzItOGZiYy00N2Q3LWEyZGUtYjBkMTJhZmVjN2M0',
                "Content-Type" => "application/json",
            ],
            'body' => json_encode([
                'app_id' => '7a6addcb-f707-4a8a-bf3a-296924818284',
                'include_player_ids' => $includePlayers,
                'headings' => [
                    'en' => $notificationObject->getTitle()
                ],
                'contents' => [
                    'en' => $notificationObject->getBody()
                ],
                'url' => $notificationObject->getRef()
            ])
        ]);
    }
}
