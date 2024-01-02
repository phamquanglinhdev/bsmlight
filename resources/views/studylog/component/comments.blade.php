@php
    use App\Helper\Object\CommentObject;
    use App\Helper\Object\StudyLogObject;use App\Models\Comment;
    /**
     * @var CommentObject[] $comments
* @var StudyLogObject $studyLog
     */
@endphp
<link rel="stylesheet" href="{{asset("demo/assets/vendor/css/pages/app-chat.css")}}">
<div class="app-chat rounded">
    <div class="app-chat-history">
        <div class="chat-history-body rounded ps ps--active-y" style="overflow-y: scroll!important;">
            <ul class="chat-history">
                @foreach($comments as $comment)
                    @if($comment->isSelf())
                        @include('studylog.component.self-comment',['comment' => $comment])
                    @else
                        @include('studylog.component.comment',['comment' => $comment])
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="chat-history-footer p-0 mt-4">
            <form id="send-comment" method="POST" action="{{url('comment/store')}}"
                  class="form-send-message d-flex justify-content-between align-items-center ">
                @csrf
                <input type="hidden" name="object_id" value="{{$studyLog->getId()}}">
                <input type="hidden" name="object_type" value="{{Comment::STUDY_LOG_COMMENT}}">
                <input required name="content" class="form-control message-input me-3 shadow-none"
                       placeholder="Gửi comment của bạn">
                <div class="message-actions d-flex align-items-center">
                    <i class="btn btn-text-secondary btn-icon rounded-pill speech-to-text mdi mdi-microphone mdi-20px cursor-pointer text-heading waves-effect waves-light"></i>
                    <label for="attach-doc" class="form-label mb-0">
                        <i class="mdi mdi-paperclip mdi-20px cursor-pointer btn btn-text-secondary btn-icon rounded-pill me-2 ms-1 text-heading waves-effect waves-light"></i>
                        <input type="file" id="attach-doc" hidden="">
                    </label>
                    <button type="submit" class="btn btn-primary d-flex send-msg-btn waves-effect waves-light">
                        <span class="align-middle">Gửi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .app-chat-history {
        height: calc(100vh - 15rem) !important;
    }

    .app-chat .app-chat-history {
        border-radius: 0.325rem !important;
    }
</style>
@push('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#send-comment').submit(function (e) {
                e.preventDefault();
                const form = document.getElementById('send-comment')
                axios.post(form.action, new FormData(form), {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                    },
                    onUploadProgress: function (progressEvent) {

                    },
                }).then((response) => {
                    form.reset()
                    $('.chat-history').prepend(response.data)
                })
            })
        })
    </script>
@endpush
