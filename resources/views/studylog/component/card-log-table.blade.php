@php
    use App\Helper\Object\CardLogObject;
        /**
         * @var CardLogObject[] $cardLogs
         */
@endphp
<div class="small">
    <div class="my-2 badge bg-label-google-plus">Học sinh - Thẻ học</div>

    <div class="row">
        @foreach($cardLogs as $cardLog)
            <div class="col-md-6 col-12 mb-2">
                <a class="small p-2 bg-label-github me-1 w-100 text-start" type="button" data-bs-toggle="collapse"
                   data-bs-target="#multiCollapseExample{{$cardLog->getId()}}" aria-expanded="false"
                   aria-controls="multiCollapseExample{{$cardLog->getId()}}">
                    <div class="d-flex align-items-center">
                        <img src="{{$cardLog->getStudentAvatar()}}"
                             class="avatar-xs me-2 rounded-circle" alt="">
                        <span>{{$cardLog->getStudentName()}} [{{$cardLog->getUuid()}}]</span>
                    </div>
                </a>
                <div class="collapse multi-collapse" id="multiCollapseExample{{$cardLog->getId()}}">
                    <div class="p-3 border">
                        <div class="mb-1">Thẻ học: {{$cardLog->getUuid()}} </div>
                        <div class="mb-1">Tên học sinh: {{$cardLog->getStudentUuid()}} </div>
                        <div class="mb-1">Mã học sinh: {{$cardLog->getStudentUuid()}} </div>
                        <div class="mb-1">Trạng thái: {{$cardLog->getStatusText()}}</div>
                        <div class="mb-1">Trừ buổi học: <span
                                    class="{{$cardLog->getDay() ? 'text-success' : 'text-danger'}} fw-bold">{{$cardLog->getDay() ? 'Có' : 'Không'}}</span>
                        </div>
                        <div class="mt-2">Lời nhắn của giáo viên cho HS/PHHS:</div>
                        <div class="p-1">
                            <i>
                                "{{$cardLog->getTeacherComment()}}"
                            </i>
                        </div>
                        <div class="mt-2">Lời nhắn của trợ giảng cho HS/PHHS:</div>
                        <div class="p-1">
                            <i>
                                "{{$cardLog->getSupporterComment()}}"
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
   </div>

</div>
