@php
    use App\Helper\CrudBag;
        /**
         * @var CrudBag $crudBag
         */
        $listSupporter = $crudBag->getParam('listSupporter') ?? [];
        $listTeacher = $crudBag->getParam('listTeacher') ?? [];
@endphp

@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="bs-stepper wizard-numbered">
            <div class="bs-stepper-header">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-number">01</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Chọn lớp điểm danh</span>
                            <span class="bs-stepper-subtitle">
                                @if($crudBag->getParam('classroom_id')!==null && $crudBag->getParam('classroom_id')!=='')
                                    {{$crudBag->getParam('listClassroom')[$crudBag->getParam('classroom_id')]}}
                                @else
                                    Vui lòng chọn lớp để điểm danh
                                @endif
                            </span>
                        </span>
                    </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#personal-info">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-number">02</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Chọn buổi học</span>
                            <span class="bs-stepper-subtitle">Vui lòng chọn buổi học</span>
                        </span>
                    </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-number">03</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Social Links</span>
                            <span class="bs-stepper-subtitle">Add social links</span>
                        </span>
                    </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form id="studylog_form" action="{{route('studylog.store')}}" method="post">
                    @csrf
                    <!-- Account Details -->
                    <div id="account-details" class="content">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <select type="text" id="classroom_id" name="classroom_id"
                                            class="form-control selectpicker">
                                        <option value="">Chọn</option>
                                        @foreach($crudBag->getParam('listClassroom') as $key => $value)
                                            <option
                                                value="{{$key}}" {{old('classroom_id') == $key ? 'selected' : ''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="classroom_id">Chọn lớp</label>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-primary btn-next"><span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Chọn buổi học</span>
                                    <i
                                        class="mdi mdi-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Personal Info -->
                    <div id="personal-info" class="content">
                        <div class="row g-4">
                            @if( $crudBag->getParam('classroom_id')!==null && $crudBag->getParam('classroom_id')!=='')
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            value="{{$crudBag->getParam('listClassroom')[$crudBag->getParam('classroom_id')]}}"
                                            type="text" id="first-name" class="form-control" disabled/>
                                        <label for="first-name">Lớp học đã chọn</label>
                                    </div>
                                    <input value="{{$crudBag->getParam('classroom_id')}}" type="hidden"
                                           name="classroom_id">
                                </div>

                            @endif
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <select class="selectpicker w-auto" name="classroom_schedule_id" id="language"
                                            data-style="btn-transparent"
                                            data-icon-base="mdi" data-tick-icon="mdi-check text-white">
                                        <option value="" selected>Chọn buổi học</option>
                                        @foreach($crudBag->getParam('listSchedule') ?? [] as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                        <option value="-1">Buổi học khác</option>
                                    </select>
                                    <label for="language">Buổi học</label>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev">
                                    <i class="mdi mdi-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Quay lại chọn lớp</span>
                                </button>
                                <button class="btn btn-primary btn-next"><span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Bắt đầu điểm danh</span>
                                    <i
                                        class="mdi mdi-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div id="social-links" class="content">
                        <div class="row g-4">
                            @foreach($crudBag->getParam('shiftTemplates')??[] as $shiftKey => $shiftTemplate)
                                <div class="border rounded p-3">
                                    <div class="row">
                                        <div class="col-md-3 col-12 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input
                                                    id="shifts[{{$shiftKey}}][start_time]"
                                                    value="{{old('shifts.'.$shiftKey.'.start_time')??$shiftTemplate['start_time']}}"
                                                    name="shifts[{{$shiftKey}}][start_time]" type="time"
                                                    class="form-control">
                                                <label for="shifts[{{$shiftKey}}][start_time]">Thời gian bắt đầu</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input
                                                    id="shifts[{{$shiftKey}}][end_time]"
                                                    value="{{old('shifts.'.$shiftKey.'.end_time')??$shiftTemplate['end_time']}}"
                                                    name="shifts[{{$shiftKey}}][end_time]" type="time"
                                                    class="form-control">
                                                <label for="shifts[{{$shiftKey}}][end_time]">Thời gian kết thúc</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <select
                                                    id="shifts[{{$shiftKey}}][teacher_id]"
                                                    name="shifts[{{$shiftKey}}][end_time]"
                                                    class="selectpicker w-100">
                                                    @foreach($listTeacher as $key => $value)
                                                        <option
                                                            value="{{$key}}" {{old('shifts.'.$shiftKey.'.teacher_id')==$key?'selected':''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="shifts[{{$shiftKey}}][teacher_id]">Giáo viên</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <select
                                                    class="selectpicker w-100"
                                                    name="shifts[{{$shiftKey}}][supporter_id]"
                                                    id="shifts[{{$shiftKey}}][supporter_id]">
                                                    @foreach( $listSupporter as $key => $value)
                                                        <option
                                                            value=" {{$key}}" {{old('shifts.'.$shiftKey.'.supporter_id')==$key?'selected':''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="shifts[{{$shiftKey}}][supporter_id]">Trợ giảng</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text"
                                                       class="form-control"
                                                       id="shifts[{{$shiftKey}}][room]"
                                                       name="shifts[{{$shiftKey}}][room]"
                                                       value="{{old('shifts.'.$shiftKey.'.room')??$shiftTemplate['room']}}"
                                                       placeholder="">
                                                <label for="shifts[{{$shiftKey}}][room]">Phòng học</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input type="file"
                                                       class="form-control"
                                                       id="shifts[{{$shiftKey}}][teacher_timestamp]"
                                                       name="shifts[{{$shiftKey}}][teacher_timestamp]"
                                                       value="{{old('shifts.'.$shiftKey.'.teacher_timestamp')??$shiftTemplate['teacher_timestamp']}}"
                                                       placeholder="">
                                                <label for="shifts[{{$shiftKey}}][teacher_timestamp]">Ảnh điểm danh giáo viên *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input type="file"
                                                       class="form-control"
                                                       id="shifts[{{$shiftKey}}][supporter_timestamp]"
                                                       name="shifts[{{$shiftKey}}][supporter_timestamp]"
                                                       value="{{old('shifts.'.$shiftKey.'.supporter_timestamp')??$shiftTemplate['supporter_timestamp']}}"
                                                       placeholder="">
                                                <label for="shifts[{{$shiftKey}}][supporter_timestamp]">Ảnh điểm danh trợ giảng *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <textarea
                                                    class="textarea form-control w-100 h-px-200"
                                                    id="shifts[{{$shiftKey}}][teacher_comment]"
                                                    name="shifts[{{$shiftKey}}][teacher_comment]"
                                                    placeholder="Ghi chú của giáo viên"
                                                    rows="5"></textarea>
                                                <label for="shifts[{{$shiftKey}}][teacher_comment]">Ghi chú của giáo viên</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <textarea
                                                    class="textarea form-control w-100 h-px-200"
                                                    id="shifts[{{$shiftKey}}][supporter_comment]"
                                                    name="shifts[{{$shiftKey}}][supporter_comment]"
                                                    placeholder="Ghi chú của trợ giảng"
                                                    rows="5"></textarea>
                                                <label for="shifts[{{$shiftKey}}][supporter_comment]">Ghi chú của trợ giảng</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{--                            <div class="col-sm-6">--}}
                            {{--                                <div class="form-floating form-floating-outline">--}}
                            {{--                                    <input type="text" id="google" class="form-control"--}}
                            {{--                                           placeholder="https://plus.google.com/abc"/>--}}
                            {{--                                    <label for="google">Google+</label>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <link rel="stylesheet" href="{{asset('demo/assets/vendor/libs/bs-stepper/bs-stepper.css')}}"/>
    <script src="{{asset('demo/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script>
        const wizardNumbered = document.querySelector(".wizard-numbered");
        const studylogForm = document.querySelector("#studylog-form");

        if (typeof wizardNumbered !== undefined && wizardNumbered !== null) {
            const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next')),
                wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev')),
                wizardNumberedBtnSubmit = wizardNumbered.querySelector('.btn-submit');

            const numberedStepper = new Stepper(wizardNumbered, {
                linear: false,
                transition: true

            });

            numberedStepper.to({{$crudBag->getParam('step') ?? 1}});

            if (wizardNumberedBtnNextList) {
                wizardNumberedBtnNextList.forEach(wizardNumberedBtnNext => {
                    wizardNumberedBtnNext.addEventListener('click', event => {
                        studylogForm.submit()
                        // numberedStepper.next();
                    });
                });
            }
            if (wizardNumberedBtnPrevList) {
                wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
                    wizardNumberedBtnPrev.addEventListener('click', event => {
                        numberedStepper.previous();
                    });
                });
            }
            if (wizardNumberedBtnSubmit) {
                wizardNumberedBtnSubmit.addEventListener('click', event => {
                    alert('Submitted..!!');
                });
            }
        }
    </script>
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/select2/select2.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/select2/select2.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script>
        $(".select2").select2();
        $(".selectpicker").selectpicker();
    </script>
@endpush
