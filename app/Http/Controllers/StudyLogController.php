<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\ListViewModel;
use App\Models\Card;
use App\Models\Classroom;
use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\StudyLog;
use App\Models\Supporter;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

    /**
     * @throws ValidationException
     */
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
        } else{
            $crudBag->setParam('classroom_id', $request->get('classroom_id'));
            $allSchedules = ClassroomSchedule::query()->where('classroom_id', $request->get('classroom_id'))->get()->map(function (ClassroomSchedule $schedule) {
                return $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time;
            });

            $crudBag->setParam('allSchedules', $allSchedules);
            if (!$request->get('studylog_day')) {
                $crudBag->setParam('step', 2);
            } else {
                $crudBag->setParam('studylog_day', $request->get('studylog_day'));
                $classroom = Classroom::query()->where('id', $request->get('classroom_id'))->first();

                $listSchedule = $classroom->Schedules()->get()->mapWithKeys(function (ClassroomSchedule $schedule) {
                    return [$schedule->id => $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time];
                });

                $crudBag->setParam('listSchedule', $listSchedule);

                if (!$request->get('classroom_schedule_id')) {
                    $crudBag->setParam('step', 3);
                }else{
                    $crudBag->setParam('step', 4);
                    $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
                    if ( $request->get('classroom_schedule_id')) {
                        $validCardList = Card::query()->where('classroom_id', null)->where('student_id', '!=', null)->where('card_status', Card::STATUS_ACTIVE)
                            ->get()->mapwithkeys(function (Card $card) {
                                return [$card->id => $card->uuid . '-' . $card->student?->name ?? 'Chọn gắn học sinh'];
                            })->all();
                        $crudBag->setParam('validCardList', $validCardList);

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

                        $cardsTemplate = $classroom->Cards()?->get()->map(function (Card $card) {
                            return [
                                'card_id' => $card->id,
                                'card_uuid' => $card->uuid,
                                'student_id' => $card->student_id,
                                'student_uuid' => $card->student?->uuid,
                                'student_name' => $card->student?->name,
                                'student_avatar' => $card->student?->avatar,
                                'attended_days' => $card->attended_days + $card->van,
                                'can_use_day' => $card->can_use_day,
                                'day' => 0,
                                'status' => null,
                                'reason' => '',
                                'teacher_note' => '',
                                'supporter_note' => '',
                            ];
                        });
                        $crudBag->setParam('cardsTemplate', $cardsTemplate);

                        $listCardLogStatus = [
                            0 => 'Đi học, đúng giờ',
                            1 => 'Đi học, muộn',
                            2 => 'Đi học, sớm',
                            3 => 'Vắng, có phép',
                            4 => 'Vắng, không phép',
                            5 => 'Không điểm danh',
                        ];

                        $crudBag->setParam('listCardLogStatus', $listCardLogStatus);
                        $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
                    }
                }

            }
        }

        if ($request->get('submit')) {

            $cardsTemplates = [];
            $shiftTemplates = [];
            foreach ($request->get('shifts') as $key => $shift) {
                $dataShift = json_decode($shift['template'], true);
                $shiftTemplates[$key] = array_replace($dataShift, $shift);

            }

            foreach ($request->get('cardlogs') as $key => $cardlog) {
                $dataCard = json_decode($cardlog['template'], true);
                $cardsTemplates[$key] = array_replace($dataCard, $cardlog);
            }

            $crudBag->setParam('cardsTemplate', $cardsTemplates);
            $crudBag->setParam('shiftTemplates', $shiftTemplates);
            $validate = Validator::make($request->all(), [
                'classroom_id' => 'required|exists:classrooms,id',
                'classroom_schedule_id' => 'required|exists:classroom_schedules,id',
                'shifts' => 'array|required',
                'shifts.*.start_time' => 'required',
                'shifts.*.end_time' => 'required',
                'shifts.*.room' => 'required|string',
                'shifts.*.teacher_id' => 'required|exists:users,id',
                'shifts.*.supporter_id' => 'required|exists:users,id',
                'shifts.*.teacher_comment' => 'string|nullable',
                'shifts.*.supporter_comment' => 'string|nullable',
                'shifts.*.teacher_timestamp' => 'file|required',
                'shifts.*.supporter_timestamp' => 'file|required',
                'cardlogs' => 'array',
                'cardlogs.*.student_id' => 'required|exists:users,id',
                'cardlogs.*.card_id' => 'required|integer',
                'cardlogs.*.day' => 'string',
                'cardlogs.*.status' => 'integer|in:0,1,2,3,4,5',
                'cardlogs.*.teacher_note' => 'string|nullable',
                'cardlogs.*.supporter_note' => 'string|nullable',
            ]);

            if ($validate->fails()) {
                return \view('studylog.create', [
                    'crudBag' => $crudBag,
                ])->withErrors($validate);
            }

            $dataToCreateStudyLog = [
              'created_by' => auth()->user()->{'id'},
              'classroom_id' => $request->get('classroom_id'),
              'classroom_schedule_id' => $request->get('classroom_schedule_id'),
              'shifts' => $shiftTemplates,
            ];
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
