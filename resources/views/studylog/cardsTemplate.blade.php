@php
    /**
     * @var array $cardTemplate
     * @var int $cardKey
     * @var array $listCardLogStatus
     */
@endphp
<div class="card_template" card_key="{{$cardKey}}">
    <input type="hidden" name="cardlogs[{{$cardKey}}][template]" value="{{json_encode($cardTemplate)}}">
    <div class="border p-3">
        <div class="row">
            <div class="col-md-4">
                <div class="border rounded p-2">
                    <div class="mb-2">
                        <div class="mb-1">Thẻ học : <span
                                class="text-white badge bg-primary">{{$cardTemplate['card_uuid']}}</span></div>
                        <div class="mb-2 small">
                            <span class="text-primary">Đã dùng: {{$cardTemplate['attended_days']}}</span> |
                            <span class="text-success">Còn lại: {{$cardTemplate['can_use_day']}}</span>
                        </div>
                        <div class="d-flex">
                            <div>
                                <img style="width: 2.5rem;height: 2.5rem" class="rounded-circle me-2"
                                     src="{{$cardTemplate['student_avatar']}}">
                            </div>
                            <div>
                                <div class="fw-bold">{{$cardTemplate['student_name']}}</div>
                                <div class="small">{{$cardTemplate['student_uuid']}}</div>
                            </div>
                        </div>
                        <input type="hidden" name="cardlogs[{{$cardKey}}][card_id]"
                               value="{{$cardTemplate['card_id']}}"/>
                        <input type="hidden" name="cardlogs[{{$cardKey}}][student_id]"
                               value="{{$cardTemplate['student_id']}}"/>
                    </div>
                    <div class="mb-3">
                        <label class="switch">
                            <input name="cardlogs[{{$cardKey}}][day]" type="checkbox" class="switch-input is-valid" checked/>
                            <span class="switch-toggle-slider">
                                                        <span class="switch-on"></span>
                                                        <span class="switch-off"></span>
                                                   </span>
                            <span class="switch-label">Trừ buổi học</span>
                        </label>
                    </div>
                    <div class="form-floating form-floating-outline ">
                        <select id="cardlogs[{{$cardKey}}][status]" class="selectpicker w-100"
                                name="cardlogs[{{$cardKey}}][status]">
                            @foreach($listCardLogStatus as $key => $value)
                                <option value="{{$key}}" {{old()['cards.'.$cardKey.'.status']??$key == $cardTemplate['status'] ? 'selected' : ''}}>{{$value}}</option>
                            @endforeach
                        </select>
                        <label for="cardlogs[{{$cardKey}}][status]">Trạng thái</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                                                <textarea id="cardlogs[{{$cardKey}}][teacher_note]"
                                                          name="cardlogs[{{$cardKey}}][teacher_note]"
                                                          class="h-px-200 form-control">{{old('cardlogs.'.$cardKey.'.teacher_note')??$cardTemplate['teacher_note']}}</textarea>
                    <label for="cardlogs[{{$cardKey}}][teacher_note]">Lời nhắn của giáo viên cho HS/PHHS</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                                                <textarea id="cardlogs[{{$cardKey}}][supporter_note]"
                                                          name="cardlogs[{{$cardKey}}][supporter_note]"
                                                          class="h-px-200 form-control">{{old('cardlogs.'.$cardKey.'.supporter_note')??$cardTemplate['supporter_note']}}</textarea>
                    <label for="cardlogs[{{$cardKey}}][supporter_note]">Lời nhắn của giáo viên cho HS/PHHS</label>
                </div>
            </div>
        </div>
    </div>
</div>
