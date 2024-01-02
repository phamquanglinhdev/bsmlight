@php use App\Helper\Object\CommentObject; @endphp
@php
    /**
     * @var CommentObject $comment
     */
@endphp
<li class="chat-message chat-message-right">
    <div class="d-flex overflow-hidden">
        <div class="chat-message-wrapper flex-grow-1">
            <div class="text-end text-muted mt-1">
                <small>{{$comment->getUserName()}}</small>
            </div>
            <div class="chat-message-text">
                <p class="mb-0">{{$comment->getContent()}}</p>
            </div>
            <div class="text-end text-muted mt-1">
                <small>{{$comment->getCommentTime()}}</small>
            </div>
        </div>
        <div class="user-avatar flex-shrink-0 ms-3">
            <div class="avatar avatar-sm">
                <img
                    src="{{$comment->getUserAvatar()}}"
                    alt="Avatar" class="rounded-circle">
            </div>
        </div>
    </div>
</li>
