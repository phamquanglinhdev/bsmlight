@php
    /**
     *  @param array $scheduleKey
 * @param array $teacherList
 * @param array $supporterList
 * @param array $shift
 * @param int $shiftKey
     */
@endphp
<div class="position-relative shift" id="shift_{{$shiftKey}}_schedule_{{$scheduleKey}}" data_shift_key="{{$shiftKey}}">
    <div class="position-relative mt-4">
                        <span class="mdi mdi-clock-time-five bg-primary text-white p-1 rounded-circle"
                              style="position: absolute; top: -0.5rem; left: -0.5rem;"></span>
        <span onclick="removeShift({{$shiftKey}},{{$scheduleKey}})"
              class="mdi mdi-trash-can cursor-pointer bg-danger text-white p-1 rounded-circle"
              style="position: absolute; top: -0.5rem; right: -0.5rem;"></span>
        <div class="p-2 row border mb-3 rounded mx-1">

            <div class="col-md-6 col-12">
                <div class="form-floating form-floating-outline mb-3 mt-2">
                    <select class="form-select selectpicker w-100"
                            name="schedules[{{$scheduleKey}}][shifts][{{$shiftKey}}][teacher_id]"
                            data-live-search="true">
                        @foreach($teacherList as $teacherKey => $teacher)
                            <option
                                    value="{{$teacherKey}}" {{(old('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.teacher_id') == ($shift['teacher_id']??null) || $teacherKey == ($shift['teacher_id']??null)) ? 'selected' : ''}}>{{$teacher}}</option>
                        @endforeach
                    </select>
                    <label for="basic-default-name">Chọn giáo viên</label>
                    @error('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.teacher_id')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating form-floating-outline mb-3 mt-2">
                    <select class="form-select selectpicker w-100"
                            name="schedules[{{$scheduleKey}}][shifts][{{$shiftKey}}][supporter_id]"
                            data-live-search="true">
                        @foreach($supporterList as $supporterKey => $supporter)
                            <option
                                    value="{{$supporterKey}}" {{(old('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.supporter_id') == ($shift['supporter_id']??null) || $supporterKey == ($shift['supporter_id']??null)) ? 'selected' : ''}}>{{$supporter}}</option>
                        @endforeach
                    </select>
                    <label for="basic-default-name">Chọn trợ giảng</label>
                    @error('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.supporter_id')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="time" name="schedules[{{$scheduleKey}}][shifts][{{$shiftKey}}][start_time]"
                           value="{{old('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.start_time') ?? $shift['start_time']}}"
                           class="form-control">
                    <label for="basic-default-name">Thời gian bắt đầu</label>
                    @error('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.start_time')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-floating form-floating-outline mb-3">
                    <input name="schedules[{{$scheduleKey}}][shifts][{{$shiftKey}}][end_time]" type="time"
                           value="{{old('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.end_time') ?? $shift['end_time']}}"
                           class="form-control">
                    <label for="basic-default-name">Thời gian kết thúc</label>
                    @error('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.end_time')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-floating form-floating-outline mb-3">
                    <input name="schedules[{{$scheduleKey}}][shifts][{{$shiftKey}}][room]" type="text"
                           value="{{old('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.room') ?? $shift['room']}}"
                           class="form-control">
                    <label for="basic-default-name">Phòng học</label>
                    @error('schedules.'.$scheduleKey.'.shifts.'.$shiftKey.'.room')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
