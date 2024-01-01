@php
    use App\Helper\Object\StudyLogAcceptedObject;
        /**
         * @var StudyLogAcceptedObject[] $users
         */
@endphp
<div class="my-1">
    <p class="demo-inline-spacing">
        <a class=" me-1 w-100" data-bs-toggle="collapse" href="#collapseUser" role="button" aria-expanded="false" aria-controls="collapseUser">
            Người liên quan <span class="mdi mdi-magnify-expand"></span>

        </a>
    </p>
    <div class="collapse" id="collapseUser">
        @foreach($users as $user)
            <div class="mb-3 d-flex align-items-center border bg-label-github p-2 rounded">
                <img
                    src="{{$user->getAvatar()}}"
                    alt="Avatar" class="rounded-circle avatar-xs me-2">
                <div>{{$user->getName()}}</div>
                @if($user->isAccepted())
                    <div class="text-success small ms-2">Đã xác nhận bởi {{$user->getAcceptedBySystem()?"Hệ Thống":"Người dùng"}}
                        lúc {{$user->getAcceptedTime()}}</div>
                @endif
            </div>
        @endforeach
    </div>
</div>
