@php use App\Helper\Fields; @endphp
@php

    /** @var Fields $field */
    $schedules = old('schedules') ?? $field->getAttributes()['value']['schedules'];

    $teacherList = $field->getAttributes()['value']['teacher_list'];
    $supporterList = $field->getAttributes()['value']['supporter_list'];
@endphp
<div class="" id="render">
    @foreach($schedules as $scheduleKey => $schedule)
        @include('fields.custom_fields.schedule',['schedule' => $schedule,'scheduleKey' => $scheduleKey,'teacherList' => $teacherList,'supporterList' => $supporterList])
    @endforeach
</div>
<div class="my-2 mt-4">
    <div class="text-primary d-flex align-items-center cursor-pointer" id="add_schedule">
        <span class="mdi mdi-plus bg-primary text-white p-1 rounded-circle me-2"></span>
        <span>Thêm lịch học mới</span>
    </div>
</div>

@push("after_scripts")
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $("#add_schedule").click((e) => {
            appendNewSchedule();
        })

        const appendNewSchedule = () => {

            let newScheduleId;

            const lastSchedule = $("div[id^='schedule-']").last();
            if(lastSchedule.length) {
                const lastScheduleId = lastSchedule.attr('id');
               newScheduleId = parseInt(lastScheduleId.split('-').pop()) + 1;
            }else {
               newScheduleId = 0;
            }



            axios.post('{{url('/static/schedule')}}', {
                id: newScheduleId,
                _token: '{{csrf_token()}}'
            }, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .then(function (response) {
                    // Xử lý kết quả thành công
                    $(`#render`).append(response.data);
                    $(".selectpicker").selectpicker();
                })
                .catch(function (error) {
                    // Xử lý lỗi
                    console.error(error);
                });

        }

        const appendNewShift = (id) => {

            let getLastItemInClass = $(`#schedule-${id} div[class^='position-relative shift']`).last();

            const lastShiftId = getLastItemInClass.attr('data_shift_key');
            const newShiftId = parseInt(lastShiftId) + 1;

            axios.post('{{url('/static/shift')}}', {
                schedule_id: id,
                shift_id: newShiftId || 0,
                _token: '{{csrf_token()}}'
            }, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .then(function (response) {
                    $(`#shifts_schedule_${id}`).append(response.data);
                    $(".selectpicker").selectpicker();
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        const removeSchedule = (id) => {
            const result = confirm('Bạn có chắc chắn muốn xóa lịch học này ?')

            if(result){
                $(`#schedule-${id}`).remove();
            }
        }

        const removeShift = (id,scheduleId) => {
            const result = confirm(' có chắc chắn muốn xóa ca học không ?')

            if(result){
                $(`#shift_${id}_schedule_${scheduleId}`).remove();
            }
        }
    </script>
@endpush
