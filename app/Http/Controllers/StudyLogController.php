<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Classroom;
use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\StudyLog;
use App\Models\Supporter;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudyLogController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setLabel('Điểm danh');
        $crudBag->setEntity('studylog');
        $crudBag->setSearchValue($request->get('search'));

        $query = StudyLog::query();

        $listViewModel = new ListViewModel($query->paginate($request->get('perPage') ?? 10));

        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listViewModel
        ]);
    }

    public function create(Request $request): View
    {
        $crudBag = new CrudBag();
        $listTeacher = Teacher::query()->get(['id', 'name', 'uuid'])->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->uuid . ' - ' . $teacher->name];
        });
        $crudBag->setParam('listTeacher', $listTeacher);
        $listSupporter = Supporter::query()->get(['id', 'name', 'uuid'])->mapWithKeys(function ($supporter) {
            return [$supporter->id => $supporter->uuid . ' - ' . $supporter->name];
        });
        $crudBag->setParam('listSupporter', $listSupporter);
        $crudBag->setEntity('studylog');

        $listClassroom = Classroom::query()->get(['id', 'name', 'uuid'])->mapWithKeys(function ($classroom) {
            return [$classroom->id => $classroom->uuid . ' - ' . $classroom->name];
        })->all();
        $crudBag->setParam('listClassroom', $listClassroom);

        if (!$request->get('classroom_id')) {
            $crudBag->setParam('step', 1);
        } else {
            $crudBag->setParam('classroom_id', $request->get('classroom_id'));
            $classroom = Classroom::query()->where('id', $request->get('classroom_id'))->first();

            $listSchedule = $classroom->Schedules()->get()->mapWithKeys(function (ClassroomSchedule $schedule) {
                return [$schedule->id => $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time];
            });

            $crudBag->setParam('listSchedule', $listSchedule);

            if (!$request->get('classroom_schedule_id')) {
                $crudBag->setParam('step', 2);
            } else {
                $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
                /**
                 * @var ClassroomSchedule $schedule
                 */
                $schedule = ClassroomSchedule::query()->where('id', $request->get('classroom_schedule_id'))->where('classroom_id', $request->get('classroom_id') ?? '')->first();
                if (!$schedule) {
                    $shiftTemplates = [
                        [
                            'teacher_id' => '',
                            'supporter_id' => '',
                            'start_time' => '',
                            'end_time' => '',
                            'room' => '',
                            'teacher_timestamp' => '',
                            'supporter_timestamp' => '',
                            'teacher_comment' => '',
                            'supporter_comment' => '',
                        ]
                    ];
                } else {
                    $shiftTemplates = $schedule->Shifts()->get()->map(function (ClassroomShift $shift) {
                        return [
                            'teacher_id' => $shift->student_id,
                            'supporter_id' => $shift->supporter_id,
                            'start_time' => $shift->start_time,
                            'end_time' => $shift->end_time,
                            'room' => $shift->room,
                            'teacher_timestamp' => '',
                            'supporter_timestamp' => '',
                            'teacher_comment' => '',
                            'supporter_comment' => '',
                        ];
                    });
                }

                $crudBag->setParam('shiftTemplates', $shiftTemplates);

                $crudBag->setParam('step', 3);
            }
        }

        return \view('studylog.create', [
            'crudBag' => $crudBag,
        ]);
    }

    public function store(Request $request): View|RedirectResponse
    {
        return $this->create($request);
    }
}
