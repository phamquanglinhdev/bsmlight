@php use App\Helper\Object\CommentObject; @endphp
@php
    /**
     * @var CommentObject $comment
     */
@endphp
<li class="chat-message">
    <div class="d-flex overflow-hidden">
        <div class="user-avatar flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
                <img
                    src="{{$comment->getUserAvatar()}}"
                    alt="Avatar" class="rounded-circle">
            </div>
        </div>
        <div class="chat-message-wrapper flex-grow-1">
            <div class="text-start text-muted mt-1">
                <small>{{$comment->getUserName()}}</small>
            </div>
            <div class="chat-message-text">
                @switch($comment->getType())
                    @case(\App\Models\Comment::TEXT_TYPE)
                        <div class="chat-message-text">
                            <p class="mb-0">{{$comment->getContent()}}</p>
                        </div>
                        @break
                    @case(\App\Models\Comment::LOG_TYPE)
                        <div class="badge bg-label-success">
                            {{$comment->getContent()}}
                        </div>
                        @break
                    @case(\App\Models\Comment::ATTRIBUTES_MODIFY_TYPE)
                        @include('studylog.component.modify_attribute',['attributes' => json_decode($comment->getContent(),1)])
                        @break
                @endswitch
            </div>
            <div class="text-muted mt-1">
                <small>{{$comment->getCommentTime()}}</small>
            </div>
        </div>
    </div>
</li>
