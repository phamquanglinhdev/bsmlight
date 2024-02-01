<?php

namespace App\Http\Controllers;

use App\Helper\DesktopNotification;
use App\Helper\Object\CommentObject;
use App\Helper\Object\NotificationObject;
use App\Models\Comment;
use App\Models\StudyLog;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return View
     * @throws ValidationException
     * @author Phạm Quang Linh <linhpq@getflycrm.com>
     * @since 02/01/2024 9:56 am
     */
    public function store(Request $request): string
    {
        $this->validate($request, [
            'object_type' => 'required|in:' . Comment::STUDY_LOG_COMMENT . ',' . Comment::CARD_COMMENT,
            'object_id' => 'required|integer',
            'content' => 'required|string',
            'type' => 'nullable|integer|in:' . Comment::TEXT_TYPE . ',' . Comment::IMAGE_TYPE . ',' . Comment::ATTACHMENT_TYPE,
        ]);

        return DB::transaction(function () use ($request) {
            $dataToCreate = [
                'user_id' => Auth::id(),
                'object_type' => $request->get('object_type'),
                'object_id' => $request->get('object_id'),
                'content' => $request->get('content'),
                'type' => $request->get('type') ?? 0,
            ];
            /**
             * @var Comment $comment
             */

            $comment = Comment::query()->create($dataToCreate);

            $commentObject = new CommentObject(
                user_id: $comment['user_id'],
                user_name: $comment->user?->name,
                user_avatar: $comment->user?->avatar,
                comment_time: Carbon::parse($comment['created_at'])->toDateTimeLocalString('minutes'),
                type: $comment['type'],
                content: $comment['content'],
                self: $comment['user_id'] == Auth::id()
            );

            $this->handleSendNotification($comment);

            return view('studylog.component.self-comment', ['comment' => $commentObject])->render();
        });
    }

    /**
     * @throws GuzzleException
     */
    private function handleSendNotification(Comment $comment)
    {
        switch ($comment['object_type']) {
            case Comment::STUDY_LOG_COMMENT:
                /**
                 * @var StudyLog $studyLog
                 */
                $studyLog = StudyLog::query()->where('id', $comment['object_id'])->first();
                $collectIds = [];

                foreach ($studyLog->CardLogs()->get() as $cardLog) {
                    $collectIds[] = $cardLog['student_id'];
                }

                foreach ($studyLog->WorkingShifts()->get() as $workingShift) {
                    $collectIds[] = $workingShift['teacher_id'];
                    $collectIds[] = $workingShift['supporter_id'];
                    $collectIds[] = $workingShift['staff_id'];
                }

                $collectIds[] = $studyLog['created_by'];

                $collectIds = array_filter($collectIds,function (int $userId){
                    return $userId!=Auth::id();
                });



                DesktopNotification::sendNotificationForAll(new NotificationObject(
                    Auth::user()->{'name'} . ' đã bình luận ở buổi học ' . $studyLog->getSupportIdAttribute(),
                    Str::limit($comment['content']),
                    $collectIds,
                    '',
                    url('/studylog/show/' . $studyLog['id']),
                    []
                ));

                break;
            default:
                break;
        }
    }
}
