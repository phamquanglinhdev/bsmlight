<?php

namespace App\Helper;

use App\Helper\Object\NotificationObject;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserFcm;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class DesktopNotification
{
    /**
     * @throws GuzzleException
     */
    public static function sendNotificationForAll(NotificationObject $notificationObject): void
    {
        $serverKey = 'AAAAhWOhzME:APA91bHgH4Wwvvb06YFqsbEx9WP2ZgVIiYzVovzs57xTfSNhYtqRJk7K7cW2yNeg9smUdyO1VcMSJy8S7sFfv2V66Ew-Wi2L2_pBmFj39ygHqTuVbqnppvuK9ZVYrVblGnLVuqjCU7sB';

        $tokens = UserFcm::query()->whereIn('user_id', $notificationObject->getUserIds())->get();

        $includePlayers = [];

        foreach ($tokens as $token) {
            $includePlayers[] = $token['token'];
        }

        if (empty($includePlayers)) {
            return;
        }

        $client = new Client();

        try {
           $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'registration_ids' => $includePlayers,
                    'notification' => [
                        'title' => $notificationObject->getTitle(),
                        'body' => $notificationObject->getBody(),
                        'sound' => 'default',
                    ],
                    'data' => [
                        'click_action' => $notificationObject->getRef()
                    ],
                ],
            ]);

           foreach ($notificationObject->getUserIds() as $userId) {
               Notification::query()->create([
                   'user_id' => $userId,
                   'thumbnail' => $notificationObject->getThumbnail(),
                   'read' => 0,
                   'title' => $notificationObject->getTitle(),
                   'description' => $notificationObject->getBody(),
                   'url' => $notificationObject->getRef(),
               ]);
           }

        }catch (\Exception $exception) {
            Log::error('Lỗi GUZZTE:', $exception->getTrace());
        }
    }

    /**
     * @throws GuzzleException
     */
    public static function sendNotificationForSingleUser(NotificationObject $notificationObject)
    {
        $users = User::query()->whereIn('id', $notificationObject->getUserIds())->get();

        foreach ($users as $user) {
            DesktopNotification::sendNotificationForAll(new NotificationObject(
                 $notificationObject->getTitle(),
                $user['name'] . ' ơi, ' .$notificationObject->getBody(),
                [$user['id']],
                $notificationObject->getThumbnail(), $notificationObject->getRef(), []
            ));
        }
    }
}
