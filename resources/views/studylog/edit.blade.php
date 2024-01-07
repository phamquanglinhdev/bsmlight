@php
    use App\Helper\CrudBag;use Illuminate\Support\Carbon;
        /**
         * @var CrudBag $crudBag
         */

        $listSupporter = $crudBag->getParam('listSupporter') ?? [];
        $listTeacher =  $crudBag->getParam('listTeacher') ?? [];
        $cardsTemplates =  $crudBag->getParam('cardsTemplates') ?? [];
        $listCardLogStatus = $crudBag->getParam('listCardLogStatus') ?? [];
        $validCardList = $crudBag->getParam('validCardList') ?? [];
        $shiftTemplates = old('shiftTemplates')??session('shiftTemplates') ?? $crudBag->getParam('shiftTemplates') ?? [];
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
                        @if($crudBag->getParam('step') > 1)
                            <span class="mdi mdi-check-decagram text-primary"></span>
                        @endif
                        <span class="bs-stepper-label">
                        <span
                                class="bs-stepper-number {{$crudBag->getParam('step') == 1 ? " fw-bold text-primary" :''}}">01</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Lớp điểm danh</span>
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
                        @if($crudBag->getParam('step') > 2)
                            <span class="mdi mdi-check-decagram text-primary"></span>
                        @endif
                        <span class="bs-stepper-label">
                        <span
                                class="bs-stepper-number {{$crudBag->getParam('step') == 2 ? " fw-bold text-primary" :''}}">02</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Ngày học</span>
                            <span class="bs-stepper-subtitle">
                                  @if($crudBag->getParam('studylog_day')!==null && $crudBag->getParam('studylog_day')!=='')
                                    {{$crudBag->getParam('studylog_day')}}
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
                        @if($crudBag->getParam('step') > 3)
                            <span class="mdi mdi-check-decagram text-primary"></span>
                        @endif
                        <span class="bs-stepper-label">
                        <span
                                class="bs-stepper-number {{$crudBag->getParam('step') == 3 ? " fw-bold text-primary" :''}}">03</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Buổi học</span>
                            <span class="bs-stepper-subtitle">
                                  @if($crudBag->getParam('classroom_schedule_id')!==null && $crudBag->getParam('classroom_schedule_id')!=='')
                                    {{$listSchedule[$crudBag->getParam('classroom_schedule_id')] ?? 'Buổi học khác'}}
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
                        @if($crudBag->getParam('step') > 4)
                            <span class="mdi mdi-check-decagram text-primary"></span>
                        @endif
                        <span class="bs-stepper-label">
                        <span
                                class="bs-stepper-number {{$crudBag->getParam('step') == 4 ? " fw-bold text-primary" :''}}">04</span>
                        <span class="d-flex flex-column gap-1 ms-2">
                            <span class="bs-stepper-title">Điểm danh</span>
                            <span class="bs-stepper-subtitle">Tiến hành điểm danh</span>
                        </span>
                    </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form id="studylog_form"
                      enctype="multipart/form-data"
                      action="{{route('studylog.update',$crudBag->getParam('studylog_id'))}}" method="post">
                    @csrf
                    <input value="{{$crudBag->getParam('classroom_id')}}" type="hidden"
                           name="classroom_id">
                    <input value="{{$crudBag->getParam('studylog_day')}}" type="hidden"
                           name="studylog_day">
                    <input value="{{$crudBag->getParam('classroom_schedule_id')}}" type="hidden"
                           name="classroom_schedule_id">
                    <div id="" class="">
                        <div class="row g-4 mb-4">
                            <div id="shiftsTemplate">
                                @foreach($shiftTemplates as $shiftKey => $shiftTemplate)
                                    @include('studylog.shiftTemplates',['shiftKey' => $shiftKey, 'shiftTemplate' => $shiftTemplate])
                                @endforeach
                            </div>
                            <div type="button" id="add_new_shift"
                                 class="text-primary cursor-pointer text-start">Thêm ca
                                học mới
                            </div>
                        </div>
                        <div class="row g-4">
                            <div id="cardsTemplate">
                                @foreach($cardsTemplates as $cardKey => $cardTemplate)
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
                                     class="col-md-6 text-primary cursor-pointer text-start">Thêm thẻ học vào
                                    lớp
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="video" id="content"
                                               value="{{old('video')??$crudBag->getParam('video')}}"/>
                                        <label for="content">Link video</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="link" id="content"
                                               value="{{old('link')??$crudBag->getParam('link')}}"/>
                                        <label for="content">Link tài liệu</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="audio" id="content"
                                               value="{{old('audio')?? $crudBag->getParam('audio')}}"/>
                                        <label for="content">Link audio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input class="form-control" name="image" type="file" id="content"
                                               value="{{old('image')?? $crudBag->getParam('image')}}"/>
                                        <label for="content">Link ảnh chụp lớp học</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" name="title" id="content"
                                       value="{{old('title')?? $crudBag->getParam('title')}}"/>
                                <label for="content">Tiêu đề bài học (tối đa 100 ký tự)</label>
                            </div>
                            <div class="form-floating form-floating-outline">

                                <textarea class="form-control h-px-200" name="content"
                                          id="content">{{old('content')?? $crudBag->getParam('content')}}</textarea>
                                <label for="content">Nội dung bài học (không giới hạn ký tự)</label>
                            </div>
                        </div>
                        <button name="submit" value="true" type="submit"
                                class="btn btn-primary btn-submit mt-5">Lưu thông tin điểm
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
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/select2/select2.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/select2/select2.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <script src="{{asset('/demo/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function sendPrevForm() {
            const form = document.getElementById('studylog_form');
            form.action = '{{route('studylog.store', ['step' => $crudBag->getParam('step') - 1])}}';
            form.submit()
        }

        $(document).ready(() => {
            $(".select2").select2();
            $(".selectpicker").selectpicker();
        })
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
                    classroom_id: "{{ $crudBag->getParam('classroom_id') }}",
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
