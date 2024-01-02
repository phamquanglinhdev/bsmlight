<?php

namespace App\Http\Controllers;

use App\Helper\Object\CommentObject;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            $comment = Comment::query()->create($dataToCreate);

            $commentObject = new CommentObject(
                user_id : $comment['user_id'],
                user_name : $comment->user?->name,
                user_avatar : $comment->user?->avatar,
                comment_time : Carbon::parse($comment['created_at'])->toDateTimeLocalString('minutes'),
                type : $comment['type'],
                content : $comment['content'],
                self : $comment['user_id'] == Auth::id()
            );

            return view('studylog.component.self-comment', ['comment' => $commentObject])->render();
        });
    }
}
