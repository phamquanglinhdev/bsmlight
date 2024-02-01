<?php

namespace App\Composer;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view): void
    {
        $notifications = Notification::query()
            ->where('user_id', Auth::id())
            ->orderBy('read','DESC')
            ->orderBy('created_at','DESC')
            ->limit(20)
            ->get();
        $view->with('notifications', $notifications);
    }
}
