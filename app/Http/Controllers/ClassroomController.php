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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
//        $crudBag->addColumn([
//            'name' => 'classroom_schedule',
//            'label' => 'Lịch học',
//            'type' => 'render',
//        ]);
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
//        $crudBag->addColumn([
//            'name' => 'days',
//            'label' => 'Danh sách các ngày trong tháng',
//            'type' => 'text',
//        ]);

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
        $crudBag = new CrudBag();

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
            'class' => 'col-10 mb-3'
        ]);

        $crudBag->addFields([
            'name' => 'name',
            'type' => 'text',
            'required' => true,
            'label' => 'Tên lớp học',
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
                'value' => null
            ]);
        }


        $crudBag->addFields([
            'name' => 'card_ids',
            'type' => 'select-multiple',
            'label' => 'Gắn thẻ học',
            'options' => Card::query()->get()->mapwithkeys(function (Card $card) {
                return [$card->id => $card->uuid . '-' . $card->student?->name ?? 'Chưa gắn học sinh'];
            })->all(),
            'class' => 'col-10 mb-3',
            'value' => json_encode([1])
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
                    'schedules' => [
                        ClassroomSchedule::TEMPLATE
                    ]
                ],
            ],
            'class' => 'col-10'
        ]);

        $crudBag->setAction('classroom.store');
        $crudBag->setEntity('classroom');
        $crudBag->setLabel('Lớp học');

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
            'schedules.*.shifts.*.room' => 'required',
            'card_ids' => 'array',
        ]);

        $dataToCreateClassroom = [
            'name' => $request->get('name'),
            'avatar' => $request->get('avatar'),
            'uuid' => Classroom::generateUUID(),
            'book' => 'template'
        ];

        $schedules = $request->get('schedules');
        $cardIds = $request->get('card_ids');


        DB::transaction(function () use ($dataToCreateClassroom, $schedules, $cardIds) {
            $classroom = Classroom::query()->create($dataToCreateClassroom);

            foreach ($schedules as $schedule) {

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
                    $classroomShift->room = $shift['room'];

                    $classroomShift->save();
                }
            }

            foreach ($cardIds as $cardId) {
                $card = Card::query()->find($cardId);

                $card->classroom_id = $classroom->id;

                $card->save();
            }
        });

        return redirect()->to('/classroom/list')->with('success', 'Tạo lớp học thành công');
    }
}
