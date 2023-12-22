@php
    /**
 * @var array $schedule
 * @var int $scheduleKey
 * @var array $teacherList
 * @var array $supporterList
     */
@endphp
<div class="mt-4 p-3 border rounded w-100 position-relative" id="schedule-{{$scheduleKey}}">
            <span class="mdi mdi-calendar bg-primary text-white p-1 rounded-circle"
                  style="position: absolute; top: -0.6rem; left: -0.6rem;"></span>
    <span onclick="removeSchedule({{$scheduleKey}})"
          class="mdi mdi-cancel cursor-pointer bg-danger text-white p-1 rounded-circle"
          style="position: absolute; top: -0.6rem; right: -0.6rem;"></span>
    <div class="row mb-3">
        <div class="col-md-4 col-12">
            <div class="form-floating form-floating-outline">
                <select name="schedules[{{$scheduleKey}}][week_day]" id="basic-default-name" class="form-select"
                        aria-label="Default select example">
                    <option
                        value="2" {{old('schedules.'.$scheduleKey.'week_day') == 2 || $schedule['week_day'] == 2 ? 'selected' : ''}}>
                        Thứ 2
                    </option>
                    <option
                        value="3" {{old('schedules.'.$scheduleKey.'week_day') == 3 || $schedule['week_day'] == 3 ? 'selected' : ''}}>
                        Thứ 3
                    </option>
                    <option
                        value="4" {{old('schedules.'.$scheduleKey.'week_day') == 4 || $schedule['week_day'] == 4 ? 'selected' : ''}}>
                        Thứ 4
                    </option>
                    <option
                        value="5" {{old('schedules.'.$scheduleKey.'week_day') == 5 || $schedule['week_day'] == 5 ? 'selected' : ''}}>
                        Thứ 5
                    </option>
                    <option
                        value="6" {{old('schedules.'.$scheduleKey.'week_day') == 6 || $schedule['week_day'] == 6 ? 'selected' : ''}}>
                        Thứ 6
                    </option>
                    <option
                        value="7" {{old('schedules.'.$scheduleKey.'week_day') == 7 || $schedule['week_day'] == 7 ? 'selected' : ''}}>
                        Thứ 7
                    </option>
                    <option
                        value="8" {{old('schedules.'.$scheduleKey.'week_day') == 8 || $schedule['week_day'] == 8 ? 'selected' : ''}}>
                        Chủ nhật
                    </option>
                </select>
                <label for="basic-default-name">Chọn thứ</label>
                @error('schedules.'.$scheduleKey.'.week_day')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-floating form-floating-outline">
                <input type="time" class="form-control" name="schedules[{{$scheduleKey}}][start_time]"
                       value="{{old('schedules.'.$scheduleKey.'.start_time') ?? $schedule['start_time']}}">
                <label for="basic-default-name">Bắt đầu</label>
                @error('schedules.'.$scheduleKey.'.start_time')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-floating form-floating-outline">
                <input type="time" class="form-control" name="schedules[{{$scheduleKey}}][end_time]"
                       value="{{old('schedules.'.$scheduleKey.'.end_time') ?? $schedule['end_time']}}">
                <label for="basic-default-name">Kết thức</label>
                @error('schedules.'.$scheduleKey.'.end_time')
                <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div id="shifts_schedule_{{$scheduleKey}}">
        @foreach($schedule['shifts'] as $shiftKey => $shift)
            @include('fields.custom_fields.shift',[
    'scheduleKey' => $scheduleKey,
    'teacherList' => $teacherList,
    'supporterList' => $supporterList,
    'shift' => $shift,
    'shiftKey' => $loop->iteration])
        @endforeach
    </div>

    <div class="">
        <div onclick="appendNewShift({{$scheduleKey}})"
             class="add_shift text-primary d-flex align-items-center cursor-pointer" id="{{$scheduleKey}}">
            <span class="small">Thêm ca học mới</span>
        </div>
    </div>
</div>
