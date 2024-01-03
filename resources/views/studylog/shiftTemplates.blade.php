@php
    /**
     * @var int $shiftKey
 * @var array $shiftTemplate
 * @var array $listTeacher
 * @var array $listSupporter
     */
@endphp
<div class="shift-template" shift_id="{{$shiftKey}}">
    <input type="hidden" name="shifts[{{$shiftKey}}][template]" value="{{json_encode($shiftTemplate)}}">
    <div class="border rounded p-4 position-relative mt-5">
                                    <span style="position: absolute; top: -1rem; left: -1rem; cursor: pointer;"
                                          class="rounded p-1 small text-white bg-primary zindex-5">
                                        Ca học {{$shiftKey + 1}}
                                    </span>
        <span style="position: absolute; top: -0.75rem; right: -0.75rem; cursor: pointer;"
              class="badge badge-danger fw-bold"
              onclick="removeShift({{$shiftKey}})"
        >
                                        <span class="mdi mdi-close text-danger fw-bold"></span>
                                    </span>
        <div class="row">
            <div class="col-md-2 col-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <input
                        id="shifts[{{$shiftKey}}][start_time]"
                        onchange="calDuration('{{$shiftKey}}')"
                        value="{{old('shifts.'.$shiftKey.'.start_time')??$shiftTemplate['start_time']}}"
                        name="shifts[{{$shiftKey}}][start_time]" type="time"
                        class="form-control">
                    <label for="shifts[{{$shiftKey}}][start_time]">Thời gian bắt đầu ca học</label>
                    @error('shifts.'.$shiftKey.'.start_time')
                    <div class="small mt-1 text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <input
                        onchange="calDuration('{{$shiftKey}}')"
                        id="shifts[{{$shiftKey}}][end_time]"
                        value="{{old('shifts.'.$shiftKey.'.end_time')??$shiftTemplate['end_time']}}"
                        name="shifts[{{$shiftKey}}][end_time]" type="time"
                        class="form-control">
                    <label for="shifts[{{$shiftKey}}][end_time]">Thời gian kết thúc ca học</label>
                    @error('shifts.'.$shiftKey.'.end_time')
                    <div class="small mt-1 text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <input
                        id="shifts[{{$shiftKey}}][duration]"
                        value="{{old('shifts.'.$shiftKey.'.duration')??$shiftTemplate['duration']}}"
                        name="shifts[{{$shiftKey}}][duration]" type="number"
                        class="form-control" readonly>
                    <label for="shifts[{{$shiftKey}}][duration]">Thời lượng (phút) để tính lương</label>
                </div>
            </div>
            <div class="col-md-12 col-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <select
                        id="shifts[{{$shiftKey}}][teacher_id]"
                        name="shifts[{{$shiftKey}}][teacher_id]"
                        class="selectpicker w-100">
                        @foreach($listTeacher as $key => $value)
                            <option
                                value="{{$key}}" {{old('shifts.'.$shiftKey.'.teacher_id')==$key?'selected':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    <label for="shifts[{{$shiftKey}}][teacher_id]">Giáo viên</label>
                </div>
            </div>
            <div class="col-md-12 col-12 mb-3">
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
                    <label for="shifts[{{$shiftKey}}][teacher_timestamp]">Ảnh điểm danh giáo
                        viên *</label>
                    @error('shifts.'.$shiftKey.'.teacher_timestamp')
                    <div class="small mt-1 text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="file"
                           class="form-control selectpicker"
                           id="shifts[{{$shiftKey}}][supporter_timestamp]"
                           name="shifts[{{$shiftKey}}][supporter_timestamp]"
                           value="{{old('shifts.'.$shiftKey.'.supporter_timestamp')??$shiftTemplate['supporter_timestamp']}}"
                           placeholder="">
                    <label for="shifts[{{$shiftKey}}][supporter_timestamp]">Ảnh điểm danh
                        trợ giảng *</label>
                    @error('shifts.'.$shiftKey.'.supporter_timestamp')
                    <div class="small mt-1 text-danger">
                        {{ $message }}
                    </div>
                    @enderror
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
                    <label for="shifts[{{$shiftKey}}][teacher_comment]">Báo cáo của giáo viên cho Admin</label>
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
                    <label for="shifts[{{$shiftKey}}][supporter_comment]">Báo cáo của trợ giảng cho Admin</label>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function calDuration(sheetKey) {
        const startTime = document.getElementById(`shifts[${sheetKey}][end_time]`).value;
        const endTime =document.getElementById(`shifts[${sheetKey}][start_time]`).value;
        const date1 = new Date("2023-01-01 " + startTime);
        const date2 = new Date("2023-01-01 " + endTime);

        document.getElementById(`shifts[${sheetKey}][duration]`).value = (date1 - date2) / (1000 * 60);
    }
</script>
@push("after_scripts")
    <script>
        $(".selectpicker").selectpicker();
    </script>
@endpush
