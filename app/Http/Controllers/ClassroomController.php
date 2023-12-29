<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Card;
use App\Models\Classroom;
use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\Staff;
use App\Models\Supporter;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClassroomController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();

        $crudBag->setLabel('Lớp học');
        $crudBag->setEntity('classroom');
        $crudBag->setSearchValue('search');
        $crudBag = $this->handleFiltering($crudBag, $request);
        $crudBag = $this->handleStatistic($crudBag, $request);
        $crudBag = $this->handleColumn($crudBag, $request);
        $query = Classroom::query();
        $listModelView = new ListViewModel($query->paginate($request->get('perPage') ?? 10));
        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listModelView
        ]);
    }

    private function handleColumn($crudBag, $request)
    {
        $crudBag->addColumn([
            'name' => 'name',
            'label' => 'Lớp học',
            'type' => 'profile',
            'attributes' => [
                'identity' => 'id',
                'entity' => 'classroom',
                'address' => 'uuid',
                'avatar' => 'avatar',
            ]
        ]);
        /**
         * @property string $uuid # Mã lớp
         * @property string $name # Tên lớp
         * @property string $avatar #Ảnh lớp
         * @property string $broadcast_chat # Nhóm chat về nội dung dạy cho nội bộ
         * @property string|null $broadcast_teacher_chat # Nhóm chat thông báo cho PH
         * @property string|null $broadcast_student_chat # Nhóm chat thông báo cho HS
         * @property ClassroomSchedule[] $classroom_schedule # Lịch học
         * @property string $schedule_last_update # Ngày cập nhật gần nhất
         * #Lấy từ ca học
         * @property Teacher[] $teacher # Giáo viên phụ trách
         * @property Supporter[] $supporter # Trợ giảng phụ trách
         * @property Staff $staff # Nhân viên phụ trách
         * Phân tích lãi lỗ (popup ra bảng lịch sử theo từng tháng)
         * @property int $total_meetings # Số buổi lớp đã chạy trong tháng
         * @property int $days # Danh sách các ngày trong tháng
         * @property int $attended_days # Số buổi bị trừ khi điểm danh
         * @property int $student_attended # Tổng số buổi đi học của học sinh
         * @property int $student_left # Tổng số buổi vắng của học sinh
         * @property int $attendance # Sĩ số hs đi học trung bình/buổi
         * @property int $total_earned # Doanh thu thực tế
         * @property int $external_salary #lương giáo viên nước ngoài
         * @property int $internal_salary #lương giáo viên Việt Nam
         * @property int $supporter_salary #lương trợ giảng
         * @property int $gross # Lãi gộp
         * @property int $gross_percent # %lãi gộp
         */
        $crudBag->addColumn([
            'name' => 'broadcast_chat',
            'label' => 'Nhóm chat về nội dung dạy cho nội bộ',
            'type' => 'link',
        ]);
        $crudBag->addColumn([
            'name' => 'broadcast_teacher_chat',
            'label' => 'Nhóm chat thông báo cho PH',
            'type' => 'link',
        ]);
        $crudBag->addColumn([
            'name' => 'broadcast_student_chat',
            'label' => 'Nhóm chat thông báo cho HS',
            'type' => 'link',
        ]);
        $crudBag->addColumn([
            'name' => 'classroom_schedule',
            'label' => 'Lịch học',
            'type' => 'array',
            'attributes' => [
                'limit' => 5
            ]
        ]);
        $crudBag->addColumn([
            'name' => 'schedule_last_update',
            'label' => 'Ngày cập nhật gần nhất',
            'type' => 'text',
        ]);
        $crudBag->addColumn([
            'name' => 'total_meetings',
            'label' => 'Số buổi chạy của lớp',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'student_attended',
            'label' => 'Tổng số buổi đi học của học sinh',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'student_left',
            'label' => 'Tổng số buổi vắng của học sinh',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'avg_attendance',
            'label' => 'Sĩ số hs đi học trung bình/buổi',
            'type' => 'text',
        ]);

        $crudBag->addColumn([
            'name' => 'total_earned',
            'label' => 'Doanh thu thực tế',
            'type' => 'number',
        ]);

        $crudBag->addColumn([
            'name' => 'internal_salary',
            'label' => 'Chi lương giáo viên VN',
            'type' => 'number',
        ]);
        $crudBag->addColumn([
            'name' => 'external_salary',
            'label' => 'Chi lương giáo viên nước ngoài',
            'type' => 'number',
        ]);

        $crudBag->addColumn([
            'name' => 'supporter_salary',
            'label' => 'Chi lương trợ giảng',
            'type' => 'number',
        ]);

        $crudBag->addColumn([
            'name' => 'gross',
            'label' => 'Lãi gộp',
            'type' => 'number',
        ]);

        $crudBag->addColumn([
            'name' => 'gross_percent',
            'label' => '%lãi gộp',
            'attributes' => [
                'suffix' => '%',
            ],
            'type' => 'number',

        ]);

        $crudBag->addColumn([
            'name' => 'gross_status',
            'label' => 'Tình trạng lớp',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    'SOS' => 'SOS',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                ],
                'bg' => [
                    'SOS' => 'bg-danger-dark',
                    'A' => 'bg-danger',
                    'B' => 'bg-danger-light',
                    'C' => 'bg-green',
                    'D' => 'bg-success',
                    'E' => 'bg-purple',
                ]
            ]
        ]);

        return $crudBag;
    }

    private function handleFiltering(CrudBag $crudBag, Request $request): CrudBag
    {

        return $crudBag;
    }

    private function handleStatistic($crudBag, Request $request)
    {

        return $crudBag;
    }

    public function create()
    {
        $crudBag = $this->handleCreateOrEdit();

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    public function edit(int $id)
    {
        $crudBag = $this->handleCreateOrEdit($id);

        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        request()->session()->flash('schedules', $request->get('schedules'));

        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required',
            'schedules' => 'array',
            'schedules.*.week_day' => 'required',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
            'schedules.*.shifts' => 'array',
            'schedules.*.shifts.*.start_time' => 'required',
            'schedules.*.shifts.*.end_time' => 'required',
            'schedules.*.shifts.*.teacher_id' => 'required',
            'schedules.*.shifts.*.supporter_id' => 'integer|nullable',
            'schedules.*.shifts.*.room' => 'string|nullable',
            'card_ids' => 'array',
        ]);

        $factory = $this->classroomFactory($request->input());

        if (!empty($factory['errors'])) {

            return redirect()->back()->withErrors($factory['errors'])->with('schedules', $request->get('schedules'));
        }

        $request->merge(['schedules' => $factory['data']]);

        $dataToCreateClassroom = [
            'name' => $request->get('name'),
            'avatar' => $request->get('avatar'),
            'uuid' => Classroom::generateUUID(),
            'book' => 'template',
            'staff_id' => $request->get('staff_id') ?? Auth::user()->{'id'}
        ];

        $schedules = $request->get('schedules');
        $cardIds = $request->get('card_ids');


        DB::transaction(function () use ($dataToCreateClassroom, $schedules, $cardIds) {
            $classroom = Classroom::query()->create($dataToCreateClassroom);

            foreach ($schedules ?? [] as $schedule) {

                $classroomSchedule = new ClassroomSchedule();
                $classroomSchedule->classroom_id = $classroom->id;
                $classroomSchedule->week_day = $schedule['week_day'];
                $classroomSchedule->start_time = $schedule['start_time'];
                $classroomSchedule->end_time = $schedule['end_time'];

                $classroomSchedule->save();

                foreach ($schedule['shifts'] as $shift) {
                    $classroomShift = new ClassroomShift();
                    $classroomShift->classroom_schedule_id = $classroomSchedule->id;
                    $classroomShift->classroom_id = $classroom->id;
                    $classroomShift->start_time = $shift['start_time'];
                    $classroomShift->end_time = $shift['end_time'];
                    $classroomShift->teacher_id = $shift['teacher_id'];
                    $classroomShift->supporter_id = $shift['supporter_id'] ?? 0;
                    $classroomShift->room = $shift['room'] ?? '--';

                    $classroomShift->save();
                }
            }

            foreach ($cardIds ?? [] as $cardId) {
                $card = Card::query()->find($cardId);

                $card->classroom_id = $classroom->id;

                $card->save();
            }
        });

        return redirect()->to('/classroom/list')->with('success', 'Tạo lớp học thành công');
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        /**
         * @var Classroom $classroom
         */
        $classroom = Classroom::query()->where('id', $id)->firstOrFail();

        request()->session()->flash('schedules', $request->get('schedules'));

        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required',
            'schedules' => 'array',
            'schedules.*.week_day' => 'required',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
            'schedules.*.shifts' => 'array|required',
            'schedules.*.shifts.*.teacher_id' => 'required',
            'schedules.*.shifts.*.supporter_id' => 'integer|nullable',
            'schedules.*.shifts.*.room' => 'string|nullable',
            'card_ids' => 'array',
        ]);

        $factory = $this->classroomFactory($request->input());

        if (!empty($factory['errors'])) {

            return redirect()->back()->withErrors($factory['errors'])->with('schedules', $request->get('schedules'));
        }

        $request->merge(['schedules' => $factory['data']]);

        $dataToCreateClassroom = [
            'name' => $request->get('name'),
            'avatar' => $request->get('avatar'),
            'book' => 'template'
        ];

        $schedules = $request->get('schedules');
        $cardIds = $request->get('card_ids');


        DB::transaction(function () use ($dataToCreateClassroom, $schedules, $cardIds, $classroom) {

            $classroom->update(($dataToCreateClassroom));
            $classroom->Schedules()->delete();
            $classroom->Shifts()->delete();

            foreach ($schedules ?? [] as $schedule) {

                $classroomSchedule = new ClassroomSchedule();
                $classroomSchedule->classroom_id = $classroom->id;
                $classroomSchedule->week_day = $schedule['week_day'];
                $classroomSchedule->start_time = $schedule['start_time'];
                $classroomSchedule->end_time = $schedule['end_time'];

                $classroomSchedule->save();

                foreach ($schedule['shifts'] ?? [] as $shift) {
                    $classroomShift = new ClassroomShift();
                    $classroomShift->classroom_schedule_id = $classroomSchedule->id;
                    $classroomShift->classroom_id = $classroom->id;
                    $classroomShift->start_time = $shift['start_time'];
                    $classroomShift->end_time = $shift['end_time'];
                    $classroomShift->teacher_id = $shift['teacher_id'];
                    $classroomShift->supporter_id = $shift['supporter_id'] ?? 0;
                    $classroomShift->room = $shift['room'] ?? '--';

                    $classroomShift->save();
                }
            }

            $classroom->Cards()->update([
                'classroom_id' => null
            ]);

            foreach ($cardIds ?? [] as $cardId) {
                $card = Card::query()->find($cardId);

                $card->classroom_id = $classroom->id;

                $card->save();
            }
        });
        return redirect()->to('/classroom/list')->with('success', 'Sửa lớp học thanh cong');
    }

    private function handleCreateOrEdit($id = null): CrudBag
    {
        $crudBag = new CrudBag();
        if ($id) {
            /**
             * @var Classroom $classroom
             */
            $classroom = Classroom::query()->where('id', $id)->firstOrFail();
            $crudBag->setId($id);
        }

        $crudBag->addFields([
            'name' => 'avatar',
            'type' => 'avatar-select',
            'required' => false,
            'label' => 'Chọn ảnh lớp học',
            'options' => [
                'https://www.iconbunny.com/icons/media/catalog/product/4/0/4082.9-class-icon-iconbunny.jpg',
                'https://cdn-icons-png.flaticon.com/512/3352/3352938.png',
                'https://www.iconbunny.com/icons/media/catalog/product/4/0/4082.9-class-icon-iconbunny.jpg',
                'https://cdn-icons-png.flaticon.com/512/3352/3352938.png',
                'https://www.iconbunny.com/icons/media/catalog/product/4/0/4082.9-class-icon-iconbunny.jpg',
                'https://cdn-icons-png.flaticon.com/512/3352/3352938.png',
            ],
            'class' => 'col-10 mb-3',
            'value' => $classroom->avatar ?? 'https://www.iconbunny.com/icons/media/catalog/product/4/0/4082.9-class-icon-iconbunny.jpg',
        ]);

        $crudBag->addFields([
            'name' => 'name',
            'type' => 'text',
            'required' => true,
            'label' => 'Tên lớp học',
            'value' => $classroom->name ?? ''
        ]);

        if (Auth::user()->{'role'} === User::HOST_ROLE) {
            $crudBag->addFields([
                'name' => 'staff_id',
                'type' => 'select',
                'label' => 'Nhân viên phụ trách',
                'nullable' => true,
                'options' => Staff::query()->get()->mapwithkeys(function ($staff) {
                    return [$staff->id => $staff->uuid . " - " . $staff->name];
                })->all(),
                'value' => $classroom->staff_id ?? null,
            ]);
        }

        if ($id) {
            $cardList = Card::query()->where(function (Builder $query) use ($classroom) {
                $query->where('classroom_id', $classroom->id)->orWhere('classroom_id', null);
            })->where('student_id', '!=', null)->where('card_status', Card::STATUS_ACTIVE)
                ->get()->mapwithkeys(function (Card $card) {
                    return [$card->id => $card->uuid . '-' . $card->student?->name ?? 'Chọn gắn học sinh'];
                })->all();
        } else {

            $cardList = Card::query()->where('student_id', '!=', null)->where('classroom_id', null)
                ->where('card_status', Card::STATUS_ACTIVE)
                ->get()->mapwithkeys(function ($card) {
                    return [$card->id => $card->uuid . " - " . $card->name];
                })->all();
        }

        $crudBag->addFields([
            'name' => 'card_ids',
            'type' => 'select-multiple',
            'label' => 'Gắn thẻ học',
            'options' => $cardList,
            'class' => 'col-10 mb-3',
            'value' => isset($classroom) ? json_encode($classroom?->Cards()?->get()?->pluck('id')->toArray()) : []
        ]);

        $crudBag->addFields([
            'name' => 'card_schedules',
            'type' => 'custom_fields',
            'label' => 'Lịch học',
            'attributes' => [
                'view' => 'classroom_schedule',
                'value' => [
                    'teacher_list' => Teacher::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Teacher $teacher) {
                        return [$teacher->id => $teacher->uuid . " - " . $teacher->name];
                    })->all(),
                    'supporter_list' => Supporter::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Supporter $supporter) {
                        return [$supporter->id => $supporter->uuid . " - " . $supporter->name];
                    })->all(),
                    'schedules' => isset($classroom) ? $classroom->SchedulesFormat() : [ClassroomSchedule::TEMPLATE]
                ],
            ],
            'class' => 'col-10'
        ]);

        $crudBag->setAction($id ? 'classroom.update' : 'classroom.store');
        $crudBag->setEntity('classroom');
        $crudBag->setLabel('Lớp học');

        return $crudBag;
    }

    private function classroomFactory(array $dataValidate): array
    {
        $errors = [];
        $schedules = $dataValidate['schedules'];

        foreach ($schedules as $scheduleKey => $schedule) {
            $startTimeBound = Carbon::parse($schedule['start_time']);
            $endTimeBound = Carbon::parse($schedule['end_time']);

            if ($startTimeBound > $endTimeBound) {
                $errors["schedules.$scheduleKey.start_time"] = 'Thời gian bắt đầu không được lớn hơn thời gian kết thúc';
                break;
            }

            $shifts = $schedule['shifts'];

            if (count($shifts) == 1) {
                if ($shifts[1]['start_time'] == null) {
                    $schedules[$scheduleKey]['shifts'][1]['start_time'] = $schedule['start_time'];
                } else {
                    if ($schedule['start_time'] != $shifts[1]['start_time']) {
                        $errors["schedules.$scheduleKey.shifts.1.start_time"] = 'Thời gian bắt đầu ca không hợp lệ';
                        break;
                    }
                }
                if ($shifts[1]['end_time'] == null) {
                    $schedules[$scheduleKey]['shifts'][1]['end_time'] = $schedule['end_time'];
                } else {
                    if ($schedule['end_time'] != $shifts[1]['end_time']) {
                        $errors["schedules.$scheduleKey.shifts.1.end_time"] = 'Thời gian kết thúc ca không hợp lệ';
                    }
                }

            } else {
                $scheduleTimeBound = Carbon::parse($schedule['start_time'])->diffInMinutes(Carbon::parse($schedule['end_time']));
                $shiftTimeBound = 0;
                foreach ($shifts as $shiftKey => $shift) {
                    if ($shift['start_time'] == null) {
                        $errors["schedules.$scheduleKey.shifts.$shiftKey.start_time"] = 'Trường thời gian bắt đầu ca không được để trống';
                        break;
                    }

                    if ($shift['end_time'] == null) {
                        $errors["schedules.$scheduleKey.shifts.$shiftKey.end_time"] = 'Trường thời gian kết thúc ca không được để trống';
                        break;
                    }

                    $shiftStartTime = Carbon::parse($shift['start_time']);
                    $shiftEndTime = Carbon::parse($shift['end_time']);

                    if ($shiftStartTime > $shiftEndTime) {
                        $errors["schedules.$scheduleKey.shifts.$shiftKey.start_time"] =
                            "Thời gian bắt đầu không lớn hơn thời gian kết thúc";
                        break;
                    }

                    if ($shiftStartTime != $startTimeBound) {
                        $errors["schedules.$scheduleKey.shifts.$shiftKey.start_time"] =
                            "Vượt quá phạm vi ({$startTimeBound->isoFormat('HH:mm')} - {$endTimeBound->isoFormat('HH:mm')}) ";
                        break;
                    }
                    if ($shiftEndTime > $endTimeBound) {
                        $errors["schedules.$scheduleKey.shifts.$shiftKey.end_time"] = "Vượt quá phạm vi ({$startTimeBound->isoFormat('HH:mm')} - {$endTimeBound->isoFormat('HH:mm')}) ";
                        break;
                    }

                    $shiftTimeBound += $shiftStartTime->diffInMinutes($shiftEndTime);

                    if ($shiftTimeBound > $scheduleTimeBound) {
                        $errors["schedules.$scheduleKey.end_time"] = "Thời gian ca học vượt quá thời gian buổi học ({$shiftTimeBound} phút / {$scheduleTimeBound} phút)";
                    }

                    $startTimeBound = $shiftEndTime;
                }

                if (empty($errors)) {
                    if ($shiftTimeBound < $scheduleTimeBound) {
                        $errors["schedules.$scheduleKey.end_time"] = "Tổng thời gian ca học chưa đủ ({$shiftTimeBound} phút / {$scheduleTimeBound} phút)";
                    }
                }
            }
        }

        return [
            'errors' => $errors,
            'data' => $schedules
        ];
    }
}
