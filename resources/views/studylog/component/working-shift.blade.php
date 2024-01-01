@php
    use App\Helper\Object\WorkingShiftObject;
    /**
* @var WorkingShiftObject[] $workingShifts
 */
@endphp
<div class="">
    <div class="my-2 badge bg-label-google-plus mt-4">Ca học</div>
    @foreach($workingShifts as $workingShift)
        <div class="mb-2">
            <a class="w-100 p-2 bg-label-github me-1" type="button" data-bs-toggle="collapse"
               data-bs-target="#ws-{{$workingShift->getId()}}" aria-expanded="false" aria-controls="">
                Ca học {{$workingShift->getStartTime()}} - {{$workingShift->getEndTime()}}
            </a>
            <div class="collapse multi-collapse" id="ws-{{$workingShift->getId()}}">
                <div class="p-2 border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">Thời gian : 10:44 - 11:44</div>
                            <div class="d-flex align-items-center">
                        <span class="me-2">
                            Giáo viên:
                        </span>
                                <a href="{{url('/teacher/show/'.$workingShift->getTeacherId())}}">
                                    <img class="avatar-xs me-1 rounded-circle"
                                         src="{{$workingShift->getTeacherAvatar()}}"
                                         alt=""/>
                                    <span>{{$workingShift->getTeacherName()}}</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                        <span class="me-2">
                            Trợ giảng:
                        </span>
                                <a href="{{url('/supporter/show/'.$workingShift->getSupporterId())}}">
                                    <img class="avatar-xs me-1 rounded-circle"
                                         src="{{$workingShift->getSupporterAvatar()}}"
                                         alt=""/>
                                    <span>{{$workingShift->getSupporterName()}}</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <div>Phòng học: {{$workingShift->getRoom()}}</div>
                                <div class="mt-2">
                                    <span>Giáo viên checkin: </span>
                                    <a href="{{url($workingShift->getTeacherTimestamp())}}" target="_blank">
                                        <span class="mdi mdi-check-decagram text-success mdi-24px"></span>
                                    </a>
                                </div>
                                <div class="mt-2">
                                    <span>Trợ giảng checkin: </span>
                                    <a href="{{url($workingShift->getSupporterTimestamp())}}" target="_blank">
                                        <span class="mdi mdi-check-decagram text-success mdi-24px"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-floating form-floating-outline w-100">
                            <div id="teacher-note-{{$workingShift->getId()}}" class="form-control">{{$workingShift->getTeacherComment()}}</div>
                            <label for="teacher-note-{{$workingShift->getId()}}">Báo cáo của giáo viên cho Admin</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-floating form-floating-outline w-100">
                            <div id="teacher-note-{{$workingShift->getId()}}" class="form-control">{{$workingShift->getSupporterComment()}}</div>
                            <label for="teacher-note-{{$workingShift->getId()}}">Báo cáo của trợ giảng cho Admin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
