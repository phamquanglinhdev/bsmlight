@php
    use App\Helper\CrudBag;
        /**
         * @var CrudBag $crudBag
         */

        $listSupporter = $crudBag->getParam('listSupporter') ?? [];
        $listTeacher =  $crudBag->getParam('listTeacher') ?? [];
        $cardsTemplate =  $crudBag->getParam('cardsTemplate') ?? [];
        $listCardLogStatus = $crudBag->getParam('listCardLogStatus') ?? [];
        $validCardList = $crudBag->getParam('validCardList') ?? [];
        $shiftTemplates =$crudBag->getParam('shiftTemplates') ?? [];
        $listSchedule = $crudBag->getParam('listSchedule') ?? [];
        $allSchedules = $crudBag->getParam('allSchedules') ?? [];
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
                <div class="step" data-target="#personal-day">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-number">02</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Chọn ngày học</span>
                            <span class="bs-stepper-subtitle">
                                  @if($crudBag->getParam('studylog_day')!==null && $crudBag->getParam('studylog_day')!=='')
                                    {{\Illuminate\Support\Carbon::parse($crudBag->getParam('studylog_day'))->format('d/m/Y') ?? 'Chưa chọn ngày học'}}
                                @else
                                    Vui lòng chọn ngày học
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
                        <span class="bs-stepper-number">03</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Chọn buổi học</span>
                            <span class="bs-stepper-subtitle">
                                  @if($crudBag->getParam('classroom_schedule_id')!==null && $crudBag->getParam('classroom_schedule_id')!=='')
                                    {{$listSchedule[$crudBag->getParam('classroom_schedule_id')] ?? 'Chưa chọn buổi học'}}
                                @else
                                    Vui lòng chọn buổi học
                                @endif
                            </span>
                        </span>
                    </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                        <span class="bs-stepper-label">
                        <span class="bs-stepper-number">04</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Điểm danh</span>
                            <span class="bs-stepper-subtitle">Tiến hành điểm danh</span>
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
                    <div id="personal-day" class="content">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                @if( $crudBag->getParam('classroom_id')!==null && $crudBag->getParam('classroom_id')!=='')
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            value="{{$crudBag->getParam('listClassroom')[$crudBag->getParam('classroom_id')]}}"
                                            type="text" id="first-name" class="form-control" disabled/>
                                        <label for="first-name">Lớp học đã chọn</label>
                                    </div>
                                    <input value="{{$crudBag->getParam('classroom_id')}}" type="hidden"
                                           name="classroom_id">
                                    <div class="mt-2">
                                        <div class="fw-bold mb-2">Lịch học của lớp : </div>
                                        @foreach($allSchedules as $schedule)
                                            <div class="badge-pro">
                                                {{$schedule}}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input name="studylog_day" type="date" id="studylog_day" class="form-control">
                                    <label for="studylog_day">Ngày điểm danh</label>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev">
                                    <i class="mdi mdi-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Quay lại chọn lớp</span>
                                </button>
                                <button class="btn btn-primary btn-next"><span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Chọn buổi học</span>
                                    <i class="mdi mdi-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Personal Info -->
                    <div id="personal-info" class="content">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                @if( $crudBag->getParam('classroom_id')!==null && $crudBag->getParam('classroom_id')!=='')
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            value="{{$crudBag->getParam('listClassroom')[$crudBag->getParam('classroom_id')]}}"
                                            type="text" id="first-name" class="form-control" disabled/>
                                        <label for="first-name">Lớp học đã chọn</label>
                                    </div>
                                    <input value="{{$crudBag->getParam('classroom_id')}}" type="hidden"
                                           name="classroom_id">
                                @endif
                                <div class="line my-3"></div>
                                @if( $crudBag->getParam('studylog_day')!==null && $crudBag->getParam('studylog_day')!=='')
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            value="{{\Illuminate\Support\Carbon::parse($crudBag->getParam('studylog_day'))->format('d/m/Y')}}"
                                            type="text" id="first-name" class="form-control" disabled/>
                                        <label for="first-name">Ngày điểm danh</label>
                                    </div>
                                    <input value="{{$crudBag->getParam('studylog_day')}}" type="hidden"
                                           name="studylog_day">
                                @endif
                            </div>

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
                                    <span class="align-middle d-sm-inline-block d-none">Quay lại chọn ngày học</span>
                                </button>
                                <button class="btn btn-primary btn-next"><span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Bắt đầu điểm danh</span>
                                    <i class="mdi mdi-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div id="social-links" class="content">
                        <div class="row g-4 mb-4">
                            <div id="shiftsTemplate">
                                @foreach($shiftTemplates as $shiftKey => $shiftTemplate)
                                    @include('studylog.shiftTemplates',['shiftKey' => $shiftKey, 'shiftTemplate' => $shiftTemplate])
                                @endforeach
                            </div>
                            <div type="button" id="add_new_shift" class="text-primary cursor-pointer text-start">Thêm ca
                                học mới
                            </div>
                        </div>
                        <div class="row g-4">
                            <div id="cardsTemplate">
                                @foreach($cardsTemplate as $cardKey => $cardTemplate)
                                    @include('studylog.cardsTemplate',['cardKey' => $cardKey, 'cardTemplate' => $cardTemplate])
                                @endforeach
                            </div>
                            <div class="row justify-content-center align-items-center mt-3">
                                <div class="col-md-6 form-floating form-floating-outline">
                                    <select type="text" id="valid_card_id" name="card_id"
                                            class="form-control selectpicker">
                                        <option value="">Chọn thẻ học</option>
                                        @foreach($validCardList as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="valid_card_id">Chọn thẻ học chưa gán lớp</label>
                                </div>
                                <div id="add_new_card" type="button"
                                     class="col-md-6 text-primary cursor-pointer text-start">Thêm thẻ học vào lớp
                                </div>
                            </div>
                        </div>
                        @if($crudBag->getParam('classroom_schedule_id')!==null)
                            <input type="hidden" name="classroom_schedule_id"
                                   value="{{$crudBag->getParam('classroom_schedule_id')}}">
                        @endif
                        <div class="mt-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" name="title" id="content" value="{{old('title')??''}}"/>
                                <label for="content">Tiêu đề</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="video" id="content"
                                               value="{{old('video')??''}}"/>
                                        <label for="content">Link video</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="link" id="content"
                                               value="{{old('link')??''}}"/>
                                        <label for="content">Link tài liệu</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="audio" id="content"
                                               value="{{old('audio')??''}}"/>
                                        <label for="content">Link audio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="image" type="file" id="content"
                                               value="{{old('image')??''}}"/>
                                        <label for="content">Link ảnh chụp lớp học</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control h-px-200" name="content"
                                          id="content">{{old('content')??''}}</textarea>
                                <label for="content">Nội dung</label>
                            </div>
                        </div>
                        <button name="submit" value="true" type="submit" class="btn btn-primary btn-submit mt-5">Lưu thông tin điểm
                            danh
                        </button>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(".select2").select2();
        $(".selectpicker").selectpicker();
    </script>
    <script>
        const addNewShiftTemplate = () => {
            const lastShiftTemplateId = $(`div[class^='shift-template']`).last();
            const newId = parseInt(lastShiftTemplateId.attr('shift_id')) + 1
            axios.post("{{ route('shiftTemplate.static.add') }}", {
                    shift_id: newId,
                    _token: "{{ csrf_token() }}"
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                },
            ).then((response) => {
                $("#shiftsTemplate").append(response.data)
                $(".select2").select2();
                $(".selectpicker").selectpicker();
            })
        }

        const addNewCardTemplate = () => {
            const selectCardId = $("#valid_card_id").val();

            const lastCardTemplateId = $(`div[class^='card_template']`).last();
            const newId = parseInt(lastCardTemplateId.attr('card_key')) + 1

            axios.post("{{ route('cardTemplate.static.add') }}", {
                    card_key: newId,
                    card_id: selectCardId,
                    _token: "{{ csrf_token() }}"
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                },
            ).then((response) => {
                $("#cardsTemplate").append(response.data)
                $(".select2").select2();
                $(".selectpicker").selectpicker();
                $("#valid_card_id option:selected").remove();
                $("#valid_card_id").val('').trigger('change');
            })
        }

        $("#add_new_shift").click(() => {
            addNewShiftTemplate();
        })

        $("#add_new_card").click(() => {
            addNewCardTemplate();
        })

    </script>
@endpush
