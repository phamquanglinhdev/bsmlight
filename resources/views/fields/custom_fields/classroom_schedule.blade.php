@php use App\Helper\Fields; @endphp
@php

    /** @var Fields $field */
    $schedules = $field->getAttributes()['value']['schedules'];

    $teacherList = $field->getAttributes()['value']['teacher_list'];
    $supporterList = $field->getAttributes()['value']['supporter_list'];
@endphp
<div class="" id="render">
    @foreach($schedules as $scheduleKey => $schedule)
        <div class="mt-4 p-3 border rounded w-100 position-relative">
            <span class="mdi mdi-calendar bg-primary text-white p-1 rounded-circle"
                  style="position: absolute; top: -0.6rem; left: -0.6rem;"></span>
            <div class="row mb-3">
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        <select name="schedules[{{$scheduleKey}}][week_day]" id="basic-default-name" class="form-select"
                                aria-label="Default select example">
                            <option value="2" {{$schedule['week_day'] == 2 ? 'selected' : ''}}>Thứ 2</option>
                            <option value="3" {{$schedule['week_day'] == 3 ? 'selected' : ''}}>Thứ 3</option>
                            <option value="4" {{$schedule['week_day'] == 4 ? 'selected' : ''}}>Thứ 4</option>
                            <option value="5" {{$schedule['week_day'] == 5 ? 'selected' : ''}}>Thứ 5</option>
                            <option value="6" {{$schedule['week_day'] == 6 ? 'selected' : ''}}>Thứ 6</option>
                            <option value="7" {{$schedule['week_day'] == 7 ? 'selected' : ''}}>Thứ 7</option>
                            <option value="8" {{$schedule['week_day'] == 8 ? 'selected' : ''}}>Chủ nhật</option>
                        </select>
                        <label for="basic-default-name">Chọn thứ</label>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        <input type="time" class="form-control" name="schedules[{{$scheduleKey}}][start]"
                               value="{{$schedule['start_time']}}">
                        <label for="basic-default-name">Bắt đầu</label>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        <input type="time" class="form-control" name="schedules[{{$scheduleKey}}][end]"
                               value="{{$schedule['end_time']}}">
                        <label for="basic-default-name">Kết thức</label>
                    </div>
                </div>
            </div>
            <div class="position-relative" id="shifts_schedule_{{$scheduleKey}}">
                @foreach($schedule['shifts'] as $shift)
                    <div class="position-relative mt-4">
                        <span class="mdi mdi-clock-time-five bg-primary text-white p-1 rounded-circle"
                              style="position: absolute; top: -0.5rem; left: -0.5rem;"></span>
                        <div class="p-2 row border mb-3 rounded mx-1">

                            <div class="col-md-6 col-12">
                                <div class="form-floating form-floating-outline mb-3 mt-2">
                                    <select class="form-select selectpicker w-100"
                                            name="schedules[{{$scheduleKey}}][shifts][{{$loop->index}}][teacher_id]"
                                            data-live-search="true">
                                        @foreach($teacherList as $teacherKey => $teacher)
                                            <option
                                                value="{{$teacherKey}}" {{$teacherKey == $shift['teacher_id'] ? 'selected' : ''}}>{{$teacher}}</option>
                                        @endforeach
                                    </select>
                                    <label for="basic-default-name">Chọn giáo viên</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating form-floating-outline mb-3 mt-2">
                                    <select class="form-select selectpicker w-100"
                                            name="schedules[{{$scheduleKey}}][shifts][{{$loop->index}}][teacher_id]"
                                            data-live-search="true">
                                        @foreach($supporterList as $supporterKey => $supporter)
                                            <option
                                                value="{{$supporterKey}}" {{$supporterKey == $shift['supporter_id'] ? 'selected' : ''}}>{{$supporter}}</option>
                                        @endforeach
                                    </select>
                                    <label for="basic-default-name">Chọn trợ giảng</label>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="time" class="form-control">
                                    <label for="basic-default-name">Thời gian bắt đầu</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="time" class="form-control">
                                    <label for="basic-default-name">Thời gian kết thúc</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control">
                                    <label for="basic-default-name">Phòng học</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="">
                <div class="add_shift text-primary d-flex align-items-center cursor-pointer" id="{{$scheduleKey}}">
                    <span class="small">Thêm ca học mới</span>
                </div>
            </div>
        </div>
    @endforeach


</div>
<div class="my-2 mt-4">
    <div class="text-primary d-flex align-items-center cursor-pointer" id="add_schedule">
        <span class="mdi mdi-plus bg-primary text-white p-1 rounded-circle me-2"></span>
        <span>Thêm lịch học mới</span>
    </div>
</div>

@push("after_scripts")
    <script>
        $("#add_schedule").click((e) => {
            appendNewSchedule();
        })

        $(".add_shift").click((e) => {
            const id = e.currentTarget.id;
            appendNewShift(id);
        })

        const appendNewSchedule = () => {
            $('#render').append('<div>hihi</div>');
        }

        const appendNewShift = (id) => {
            $(`#shifts_schedule_${id}`).append("<div>hihi</div>")
        }
    </script>
@endpush
