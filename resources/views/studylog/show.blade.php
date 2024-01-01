@php
    use App\Helper\StudyLogShowViewModel;
        /**
         * @var StudyLogShowViewModel $studyLogShowViewModel
         */
        $studyLog  = $studyLogShowViewModel->getStudyLog();
        $cardLogs = $studyLogShowViewModel->getCardLogs();
        $workingShifts = $studyLogShowViewModel->getWorkingShifts();
@endphp
@extends("layouts.app")
@section('content')
    <div class="container-fluid ms-5 mt-4 p-2 me-5">
        <div class="mb-2 d-flex justify-content-between align-items-center mb-2 p-2 py-3 bg-label-github rounded">
            <div class="fw-bold  mb-0 ms-2 d-flex align-items-center">
                <div class="h5 mb-0 me-2">
                    {{$studyLog->getTitle()}}
                </div>
                <div class="badge bg-primary small rounded">{{$studyLog->getStatusText()}}</div>
            </div>
            <div>
                <button class="btn btn-success small me-1">
                    <span class="mdi mdi-check-circle me-1"></span>
                    <span class="small">Xác nhận buổi học chính xác</span>
                </button>
                <button class="btn btn-success small me-1">
                    <span class="mdi mdi-check-circle me-1"></span>
                    <span class="small">Duyệt buổi học</span>
                </button>
                <button class="btn btn-danger small me-1">
                    <span class="mdi mdi-cancel me-1"></span>
                    <span class="small">Hủy buổi học</span>
                </button>
                <button class="btn btn-primary small">
                    <span class="mdi mdi-check-circle me-1"></span>
                    <span class="small">Gửi lên</span>
                </button>
            </div>
        </div>
        <div class="my-3">
            <div class="p-3 bg-label-github rounded">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="h6">Lớp điểm danh</div>
                            <div class="d-flex">
                                <img class="avatar-md me-2 rounded-circle"
                                     src="{{$studyLog->getClassroomAvatar()}}">
                                <div>
                                    <div>{{$studyLog->getClassroomName()}}</div>
                                    <div class="text-muted">Mã lớp: {{$studyLog->getClassroomUuid()}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="h6">Ngày học</div>
                            <div class="d-flex">
                                <span class="mdi mdi-calendar-range me-2"></span>
                                <span>{{$studyLog->getWeekDay()}}</span>
                            </div>
                            <div class="d-flex mt-1">
                                <span class="mdi mdi-calendar-arrow-right me-2"></span>

                                <span>{{$studyLog->getScheduleText()}}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="h6">Tài liệu đính kèm</div>
                            <div class="row">
                                <a href="{{$studyLog->getLink()}}" class="col-md-6 mb-2">
                                    <span class="mdi mdi-link-box"></span>
                                    <span>Liên kết đính kèm</span>
                                </a>
                                <a href="{{$studyLog->getPhoto()}}" class="col-md-6 mb-2">
                                    <span class="mdi mdi-image"></span>
                                    <span>Ảnh đính kèm</span>
                                </a>
                                <a href="{{$studyLog->getVideo()}}" class="col-md-6 mb-2">
                                    <span class="mdi mdi-movie-filter"></span>
                                    <span>Video đính kèm</span>
                                </a>
                                <a href="{{$studyLog->getStudylogImage()}}" class="col-md-6 mb-2">
                                    <span class="mdi mdi-image"></span>
                                    <span>Ảnh chụp lớp học</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="h6">Nội dung bài học:</div>
                    <div class="quote">
                        <i>
                            {{$studyLog->getNotes()}}
                        </i>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="rounded p-2">
                    @include('studylog.component.users',['users' => $studyLogShowViewModel->getStudyLogAcceptedUsers()])
                    @include('studylog.component.card-log-table',['cardLogs' => $cardLogs])
                    @include('studylog.component.working-shift',['workingShifts' => $workingShifts])
                </div>
            </div>
            <div class="col-md-6">
                <div class="rounded small">
                    @include("studylog.component.comments",['users' => $studyLogShowViewModel->getStudyLogAcceptedUsers()])
                </div>
            </div>
        </div>
    </div>
@endsection
