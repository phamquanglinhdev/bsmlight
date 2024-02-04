@php
    use App\Helper\Object\StudyLogAcceptedObject;use App\Models\User;use Carbon\Carbon;use Illuminate\Support\Facades\Auth;
        /**
         * @var StudyLogAcceptedObject[] $users
         */
@endphp
<div class="my-1">
    <p class="demo-inline-spacing">
        <a class=" me-1 w-100" data-bs-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false"
           aria-controls="collapseUser">
            Người liên quan <span class="mdi mdi-magnify-expand"></span>

        </a>
    </p>
    <div class="collapse" id="collapseUser">
        @if(in_array(Auth::user()->{'role'},[User::HOST_ROLE,User::STAFF_ROLE]))
            <div class="my-2">
                <a href="{{url('studylog/confirm/logs/'.$users[0]->getStudylogId())}}"
                   class="text-white bg-success p-1 small border-none rounded">Xác nhận thay toàn bộ giáo viên , trợ
                    giảng</a>
            </div>
        @endif
        @foreach($users as $user)
            <div class="mb-3 d-flex align-items-center border bg-label-github p-2 rounded">
                <img
                    src="{{$user->getAvatar()}}"
                    alt="Avatar" class="rounded-circle avatar-xs me-2">
                <div>{{$user->getName()}}</div>
                @if($user->isAccepted())
                    <div class="text-success small ms-2 " id="label_acp_{{$user->getUserId()}}">Đã xác nhận
                        bởi {{$user->getAcceptedBySystem()?"Hệ Thống":"Người dùng"}}
                        {{ $user->getAcceptedBy() != "0" ? "[".$user->getAcceptedBy()."]" : ""}}
                        lúc {{$user->getAcceptedTime()}}</div>
                @else
                    <div class="text-success small ms-2 " id="label_acp_{{$user->getUserId()}}"> </div>
                    @if(Auth::user()->{'role'} <= User::STAFF_ROLE && ! $user->isStudent())
                        <a id="acp_{{$user->getUserId()}}"
                           href="{{url('studylog/confirm/log/'.$user->getStudylogId().'/alt/'.$user->getUserId())}}"
                           class="text-white bg-success p-1 small border-none rounded ms-3 alt_acp">Xác nhận thay</a>
                    @endif
                @endif

            </div>
        @endforeach
    </div>
</div>


@push('after_scripts')
    <script>
        $(".alt_acp").click(function (e) {
            e.preventDefault()
            const user_id = this.id
            $.ajax({
                method: "GET",
                url: this.href,
            })

            const alt_message = '{{"Đã xác nhận bởi ".Auth::user()->{'name'}.' lúc '.Carbon::now()->toDateTimeLocalString() }}'

            console.log(alt_message)

            const labelId = "label_" + user_id
            console.log(labelId)
            document.getElementById(labelId).innerText = alt_message
            document.getElementById(user_id).style.display = "none"
        })
    </script>
@endpush
