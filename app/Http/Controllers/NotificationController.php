<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\DesktopNotification;
use App\Helper\Object\NotificationObject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserFcm;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function saveDesktopFcmTokenAction(Request $request): JsonResponse
    {
        $token = $request->get('token');

        if ($token) {
            UserFcm::query()->updateOrCreate([
                'user_id' => Auth::id(),
                'token' => $token
            ], [
                'user_id' => Auth::id(),
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'ok']);
    }

    public function createNotificationView(): View
    {
        $receiverOptions = [];
        $receiverOptions['teacher'] = 'Tất cả giáo viên trong chi nhánh';
        $receiverOptions['supporter'] = 'Tất cả trợ giảng trong chi nhánh';
        $receiverOptions['staff'] = 'Tất cả nhân viên trong chi nhánh';
        $receiverOptions['student'] = 'Tất cả học sinh trong chi nhánh';

        $allUser = User::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (User $user) {
            return [$user['id'] => $user['uuid'] . ' - ' . $user['name']];
        })->toArray();

        $receiverOptions = array_merge_recursive_distinct($receiverOptions, $allUser);

        $crudBag = new CrudBag();

        $crudBag->setAction('notification.store');
        $crudBag->setEntity('notification');
        $crudBag->setLabel('Thông báo');
        $crudBag->addFields([
            'name' => 'title',
            'label' => 'Tiêu đề thông báo',
            'type' => 'text',
            'class' => 'col-10'
        ]);

        $crudBag->addFields([
            'name' => 'body',
            'label' => 'Nội dung thông báo',
            'type' => 'textarea',
            'class' => 'col-10'
        ]);

        $crudBag->addFields([
            'name' => 'user_receives',
            'type' => 'select-multiple',
            'options' => $receiverOptions,
            'label' => 'Thông báo đến',
            'class' => 'col-10'
        ]);

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws ValidationException
     */
    public function storeNotification(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|string|max:50',
            'body' => 'required|string|max:255',
            'user_receives' => 'required|array'
        ]);

        $title = $request->get('title');
        $body = $request->get('body');
        $userReceives = $request->get('user_receives');
        $userIds = [];

        foreach ($userReceives as $userReceive) {
            switch ($userReceive) {
                case 'teacher':
                    $teacherIds = Teacher::query()->where('branch', Auth::user()->{'branch'})->get()->pluck('id')->toArray();
                    $userIds = array_diff($userIds, $teacherIds);
                    break;
                default:
                    $userIds = array_merge($userIds, [$userReceive]);
            }
        }

        $notificationObject = new NotificationObject(
            title: $title,
            body: $body,
            user_ids: $userIds,
            thumbnail: '',
            ref: 'https://fb.me/linhcuenini',
            attributes: []
        );

        try {
            DesktopNotification::sendNotification($notificationObject);
        } catch (\Exception $exception) {
            dd($exception);
        }

        return redirect()->back()->with('success', 'Gửi đi thành công');
    }
}
