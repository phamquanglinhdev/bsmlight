<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Helper\DesktopNotification;
use App\Helper\ListViewModel;
use App\Helper\Object\NotificationObject;
use App\Helper\StudyLogShowViewModel;
use App\Models\Branch;
use App\Models\Card;
use App\Models\CardLog;
use App\Models\Classroom;
use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\Comment;
use App\Models\Host;
use App\Models\Staff;
use App\Models\StudyLog;
use App\Models\StudyLogAccept;
use App\Models\Supporter;
use App\Models\Teacher;
use App\Models\User;
use App\Models\WorkingShift;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use function Symfony\Component\String\b;

class StudyLogController extends Controller
{
    public function list(Request $request)
    {
        $crudBag = new CrudBag();
        $crudBag->setLabel('Điểm danh');
        $crudBag->setEntity('studylog');
        $crudBag->setSearchValue($request->get('search'));
        $crudBag = $crudBag->handleColumns($request, $crudBag);
        $query = StudyLog::query();

        $query = $crudBag->handleQuery($request, $query);

        $listViewModel = new ListViewModel($query->paginate($request->get('perPage') ?? 10));

        return view('list', [
            'crudBag' => $crudBag,
            'listViewModel' => $listViewModel
        ]);
    }

    /**
     */

    public function store(Request $request, $step = 1): View|RedirectResponse
    {
        return $this->create($request, $step);
    }

    public function create(Request $request, $step = 1): View|RedirectResponse
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

        switch ($step) {
            case 1:
                return $this->selectClassroom($request, $crudBag);
            case 2:
                return $this->selectStudyLogDay($request, $crudBag);
            case 3:
                return $this->selectSchedule($request, $crudBag);
            case 4:
                return $this->startCreate($request, $crudBag);
            case 5:
                return $this->finalStore($request, $crudBag);
            default:
                abort(404);
        }
    }

    private function selectClassroom(Request $request, CrudBag $crudBag): View
    {
        $request->merge(['studylog_day', null]);
        $request->merge(['classroom_id', null]);
        $request->merge(['classroom_schedule_id', null]);

        $crudBag->setParam('step', 1);

        return \view('studylog.create', [
            'crudBag' => $crudBag,
        ]);
    }

    private function selectStudyLogDay(Request $request, CrudBag $crudBag): View
    {
        if (!$request->get('classroom_id')) {
            return $this->selectClassroom($request, $crudBag);
        }

        $request->merge(['studylog_day', null]);
        $request->merge(['classroom_schedule_id', null]);

        $crudBag->setParam('classroom_id', $request->get('classroom_id'));
        $allSchedules = ClassroomSchedule::query()->where('classroom_id', $request->get('classroom_id'))->get()->map(function (ClassroomSchedule $schedule) {
            return $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time;
        });

        $crudBag->setParam('allSchedules', $allSchedules);

        $crudBag->setParam('step', 2);

        return \view('studylog.create', [
            'crudBag' => $crudBag,
        ]);
    }

    private function selectSchedule(Request $request, CrudBag $crudBag): View
    {
        if (!$request->get('classroom_id')) {
            return $this->selectClassroom($request, $crudBag);
        }

        if (!$request->get('studylog_day')) {
            return $this->selectStudyLogDay($request, $crudBag);
        }

        $request->merge(['classroom_schedule_id', null]);

        $crudBag->setParam('classroom_id', $request->get('classroom_id'));
        $allSchedules = ClassroomSchedule::query()->where('classroom_id', $request->get('classroom_id'))->get()->map(function (ClassroomSchedule $schedule) {
            return $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time;
        });

        $crudBag->setParam('allSchedules', $allSchedules);

        $crudBag->setParam('studylog_day', $request->get('studylog_day'));

        $weekDay = Carbon::parse($request->get('studylog_day'))->weekday();

        $weekDay == 0 ? $weekDay = 8 : $weekDay += 1;

        $classroom = Classroom::query()->where('id', $request->get('classroom_id'))->first();

        $listSchedule = $classroom->Schedules()->where('week_day', $weekDay)->get()->mapWithKeys(function (ClassroomSchedule $schedule) {
            return [$schedule->id => $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time];
        });

        $crudBag->setParam('listSchedule', $listSchedule);

        $crudBag->setParam('step', 3);

        return \view('studylog.create', [
            'crudBag' => $crudBag,
        ]);
    }

    private function startCreate(Request $request, CrudBag $crudBag)
    {
        if (!$request->get('classroom_id')) {
            return $this->selectClassroom($request, $crudBag);
        }

        if (!$request->get('studylog_day')) {
            return $this->selectStudyLogDay($request, $crudBag);
        }

        if (!$request->get('classroom_schedule_id')) {
            return $this->selectSchedule($request, $crudBag);
        }

        $crudBag->setParam('classroom_id', $request->get('classroom_id'));
        $allSchedules = ClassroomSchedule::query()->where('classroom_id', $request->get('classroom_id'))->get()->map(function (ClassroomSchedule $schedule) {
            return $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time;
        });

        $crudBag->setParam('allSchedules', $allSchedules);

        $crudBag->setParam('studylog_day', $request->get('studylog_day'));

        $weekDay = Carbon::parse($request->get('studylog_day'))->weekday();

        $weekDay == 0 ? $weekDay = 8 : $weekDay += 1;
        /**
         * @var Classroom $classroom
         */
        $classroom = Classroom::query()->where('id', $request->get('classroom_id'))->first();

        $listSchedule = $classroom->Schedules()->where('week_day', $weekDay)->get()->mapWithKeys(function (ClassroomSchedule $schedule) {
            return [$schedule->id => $schedule->getWeekStringAttribute() . ': ' . $schedule->start_time . ' - ' . $schedule->end_time];
        });

        $crudBag->setParam('listSchedule', $listSchedule);

        $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
        if ($request->get('classroom_schedule_id')) {
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
                        'duration' => 0,
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
                        'duration' => Carbon::parse($shift->start_time)->diffInMinutes($shift->end_time),
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

            $crudBag->setParam('cardsTemplates', $cardsTemplate);

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

        $crudBag->setParam('step', 4);

        return \view('studylog.create', [
            'crudBag' => $crudBag,
        ]);
    }

    private function finalStore(Request $request, CrudBag $crudBag): RedirectResponse|View
    {
        $listCardLogStatus = [
            0 => 'Đi học, đúng giờ',
            1 => 'Đi học, muộn',
            2 => 'Đi học, sớm',
            3 => 'Vắng, có phép',
            4 => 'Vắng, không phép',
            5 => 'Không điểm danh',
        ];

        $crudBag->setParam('step', 4);

        $cardsTemplates = [];
        $shiftTemplates = [];

        foreach ($request->get('shifts') as $key => $shift) {
            $files = $request->file('shifts')[$key] ?? [];
            if (! empty($files)) {
                $request->merge([
                    "shifts" => [
                        $key => array_merge($shift, [
                            'teacher_timestamp' => uploads($files['teacher_timestamp'] ?? null),
                            'supporter_timestamp' => uploads($files['supporter_timestamp'] ?? null),
                        ])
                    ]
                ]);
            }
        }

        foreach ($request->get('shifts') as $key => $shift) {
            $dataShift = json_decode($shift['template'], true);
            $shiftTemplates[$key] = array_replace($dataShift, $shift);
        }

        foreach ($request->get('cardlogs') as $key => $cardlog) {
            $dataCard = json_decode($cardlog['template'], true);
            $cardsTemplates[$key] = array_replace($dataCard, $cardlog);
        }

        $crudBag->setParam('cardsTemplates', $cardsTemplates);
        $crudBag->setParam('shiftTemplates', $shiftTemplates);
        $crudBag->setParam('listCardLogStatus', $listCardLogStatus);
        $crudBag->setParam('classroom_id', $request->get('classroom_id'));
        $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
        $crudBag->setParam('studylog_day', $request->get('studylog_day'));

        $validate = Validator::make($request->all(), [
            'shifts.*.teacher_timestamp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'shifts.*.supporter_timestamp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validate->fails()) {
            return \view('studylog.create', [
                'crudBag' => $crudBag,
            ])->withErrors($validate);
        }

        $validate = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'studylog_day' => 'required',
            'classroom_schedule_id' => 'required|exists:classroom_schedules,id',
            'shifts' => 'array|required',
            'shifts.*.start_time' => 'required',
            'shifts.*.end_time' => 'required',
            'shifts.*.room' => 'required|string',
            'shifts.*.teacher_id' => 'required|exists:users,id',
            'shifts.*.supporter_id' => 'required|exists:users,id',
            'shifts.*.teacher_comment' => 'string|nullable',
            'shifts.*.supporter_comment' => 'string|nullable',
            'cardlogs' => 'array|required',
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
            'created_by' => Auth::id(),
            'classroom_id' => $request->get('classroom_id'),
            'classroom_schedule_id' => $request->get('classroom_schedule_id'),
            'shifts' => $shiftTemplates,
            'studylog_day' => Carbon::parse($request->get('studylog_day'))->toDateString(),
            'title' => $request->get('title') ?? 'Buổi học ngày ' . Carbon::parse($request->get('studylog_day'))->isoFormat('DD/MM/YYYY'),
            'content' => $request->get('content') ?? '',
            'image' => $request->get('image'),
            'video' => $request->get('video'),
            'file' => $request->get('file'),
            'link' => $request->get('link'),
            'status' => StudyLog::DRAFT_STATUS,
            'notes' => $request->get('notes'),
        ];
        DB::transaction(function () use ($cardsTemplates, $dataToCreateStudyLog, $request, $shiftTemplates) {
            /**
             * @var StudyLog $studyLog
             */
            $studyLog = StudyLog::query()->create($dataToCreateStudyLog);

            foreach ($cardsTemplates as $cardLog) {
                /**
                 * @var Card $card
                 */
                $card = Card::query()->find($cardLog['card_id']);

                $dataToCreateCardLog = [
                    'card_id' => $cardLog['card_id'],
                    'student_id' => $cardLog['student_id'],
                    'studylog_id' => $studyLog['id'],
                    'day' => $cardLog['day'] == 'on' ? 1 : 0,
                    'fee' => $cardLog['day'] == 'on' ? $card->getDailyFeeAttribute() : 0,
                    'active' => CardLog::UNVERIFIED,
                    'status' => $cardLog['status'],
                    'reason' => '',
                    'teacher_note' => $cardLog['teacher_note'] ?? '',
                    'supporter_note' => $cardLog['supporter_note'] ?? '',
                ];

                CardLog::query()->create($dataToCreateCardLog);
            }

            foreach ($shiftTemplates as $shiftTemplate) {
                $dataToCreateWorkingShift = [
                    'staff_id' => $shiftTemplate['staff_id'] ?? Auth::user()->id,
                    'teacher_id' => $shiftTemplate['teacher_id'],
                    'supporter_id' => $shiftTemplate['supporter_id'],
                    'room' => $shiftTemplate['room'] ?? '',
                    'teacher_timestamp' => $shiftTemplate['teacher_timestamp'],
                    'supporter_timestamp' => $shiftTemplate['supporter_timestamp'],
                    'start_time' => $shiftTemplate['start_time'],
                    'end_time' => $shiftTemplate['end_time'],
                    'studylog_id' => $studyLog['id'],
                    'status' => WorkingShift::UNVERIFIED,
                    'teacher_comment' => $shiftTemplate['teacher_comment'],
                    'supporter_comment' => $shiftTemplate['supporter_comment'],
                ];

                WorkingShift::query()->create($dataToCreateWorkingShift);
            }
        });

        return redirect()->to('studylog/list')->with('success', "Thêm mới thành công");
    }

    public function show(int $id): View
    {
        /**
         * @var StudyLog $studyLog
         */

        $studyLog = StudyLog::query()->where('id', $id)->first();

        switch ($studyLog['status']) {
            case StudyLog::CANCELED :
                if (!$studyLog['created_by'] == Auth::id()) {
                    abort(403);
                }
                break;
            case StudyLog::DRAFT_STATUS :
            case StudyLog::WAITING_CONFIRM :
            case StudyLog::WAITING_ACCEPT:
            case StudyLog::ACCEPTED:
            case StudyLog::REFUSED:
                $existStudent = $studyLog->CardLogs()->where('student_id', Auth::id());
                if ($existStudent) {
                    break;
                }
                $existOther = $studyLog->WorkingShifts()
                    ->where('staff_id', Auth::id())
                    ->orWhere('teacher_id', Auth::id())
                    ->orWhere('supporter_id', Auth::id());
                if ($existOther) {
                    break;
                }
                if ($studyLog['created_by'] == Auth::id()) {
                    break;
                }

                if (Auth::user()->{'role'} === User::HOST_ROLE) {
                    break;
                }

                abort(403);
            default:
                abort(403);
        }

        $this->handleSwitchToWaitingAccept($studyLog);

        $cardLogs = CardLog::query()->where('studylog_id', $id)->get();

        $relationUsers = $studyLog->getAcceptedUsers();

        $comments = Comment::query()->where('object_id', $id)->where('object_type', Comment::STUDY_LOG_COMMENT)
            ->orderBy('created_at', 'DESC')->get();

        $studyLogShowViewModel = new StudyLogShowViewModel(
            studyLog: $studyLog,
            cardLogs: $cardLogs,
            workingShifts: WorkingShift::query()->where('studylog_id', $id)->get(),
            comments: $comments,
            studyLogAcceptedUsers: $relationUsers
        );

        return \view('studylog.show', [
            'studyLogShowViewModel' => $studyLogShowViewModel
        ]);
    }

    public function submit(int $id): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        if ($studyLog['created_by'] !== Auth::id()) {
            abort(403);
        }

        StudyLog::query()->where('id', $id)->update([
            'status' => StudyLog::WAITING_CONFIRM
        ]);

        StudyLogAccept::query()->create([
            'user_id' => Auth::id(),
            'studylog_id' => $id,
            'accepted_time' => Carbon::now(),
            'accepted_by_system' => 0,
            'accepted_by' => 0,
        ]);

        return redirect()->back()->with('success', "Gửi lên thành công");
    }

    public function cancel(int $id): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        if ($studyLog['created_by'] !== Auth::id()) {
            abort(403);
        }

        StudyLog::query()->where('id', $id)->update([
            'status' => StudyLog::CANCELED
        ]);

        return redirect()->back()->with('success', "Huỷ thành công");
    }

    public function recover(int $id): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        if ($studyLog['created_by'] !== Auth::id()) {
            abort(403);
        }

        StudyLog::query()->where('id', $id)->update([
            'status' => StudyLog::DRAFT_STATUS
        ]);

        return redirect()->back()->with('success', "Khôi phục thành công");
    }

    public function confirm(int $id): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        $relationUsers = array_map(function ($user) {
            return $user->getUserId();
        }, $studyLog->getAcceptedUsers());

        if (!in_array(Auth::id(), $relationUsers)) {
            abort(403);
        }

        StudyLogAccept::query()->updateOrCreate([
            'studylog_id' => $id,
            'user_id' => Auth::id()
        ], [
            'studylog_id' => $id,
            'user_id' => Auth::id(),
            'accepted_time' => Carbon::now(),
            'accepted_by_system' => 0
        ]);

        $this->handleSwitchToWaitingAccept($studyLog);

        return redirect()->back()->with('success', "Đã xác nhận");
    }

    public function confirmUser(int $id, int $forUser): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        $relationUsers = array_map(function ($user) {
            return $user->getUserId();
        }, $studyLog->getAcceptedUsers());

        if (!in_array($forUser, $relationUsers)) {
            abort(403);
        }

        StudyLogAccept::query()->updateOrCreate([
            'studylog_id' => $id,
            'user_id' => $forUser
        ], [
            'studylog_id' => $id,
            'user_id' => $forUser,
            'accepted_time' => Carbon::now(),
            'accepted_by_system' => 0,
            'accepted_by' => Auth::user()->{'uuid'} . "-" . Auth::user()->{'name'}
        ]);

        $this->handleSwitchToWaitingAccept($studyLog);

        return redirect()->back()->with('success', "Đã xác nhận");
    }

    private function handleSwitchToWaitingAccept(StudyLog $studyLog): void
    {
        $relationUsers = $studyLog->getAcceptedUsers();

        foreach ($relationUsers as $relationUser) {
            if (!$relationUser->isAccepted()) {
                return;
            }
        }

        StudyLog::query()->where('id', $studyLog['id'])->update([
            'status' => StudyLog::WAITING_ACCEPT
        ]);
    }

    public function accept(int $id): RedirectResponse
    {
        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->first();

        DB::transaction(fn() => [
            $studyLog->update([
                'status' => StudyLog::ACCEPTED
            ]),

            $this->handleActiveStudyLog($studyLog)
        ]);

        return redirect()->back()->with('success', "Đã xác nhận");
    }

    public function reject(int $id): RedirectResponse
    {
        StudyLog::query()->where('id', $id)->update([
            'status' => StudyLog::REFUSED
        ]);

        return redirect()->back()->with('success', "Đã từ chối");
    }

    private function handleActiveStudyLog(StudyLog $studyLog): bool
    {
        $studyLog->CardLogs()->update([
            'status' => CardLog::VERIFIED
        ]);

        $studyLog->WorkingShifts()->update([
            'status' => WorkingShift::VERIFIED
        ]);

        return true;
    }

    public function edit(int $id): View
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

        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::query()->where('id', $id)->firstOrFail();

        $listClassrooms = Classroom::query()->withoutGlobalScopes(['relation'])->get()->mapWithKeys(function (Classroom $classroom) {
            return [$classroom['id'] => $classroom['uuid'] . ' - ' . $classroom['name']];
        })->toArray();
        $crudBag->setParam('listClassroom', $listClassrooms);

        $crudBag->setParam('classroom_id', $studyLog->getAttributeValue('classroom_id'));

        $crudBag->setParam('studylog_day', $studyLog->getAttributeValue('studylog_day'));

        $listSchedule = ClassroomSchedule::query()->where('classroom_id', $studyLog->getAttributeValue('classroom_id'))->get()->mapWithKeys(
            function (ClassroomSchedule $item) {
                return [$item->id => $item->getWeekStringAttribute() . ": " . $item->start_time . " - " . $item->end_time];
            }
        )->toArray();

        $crudBag->setParam('listSchedule', $listSchedule);

        $crudBag->setParam('classroom_schedule_id', $studyLog->getAttributeValue('classroom_schedule_id'));


        $shiftsTemplates = $studyLog->WorkingShifts()->get()->map(function (WorkingShift $workingShift) {
            return [
                'teacher_id' => $workingShift->getAttributeValue('teacher_id'),
                'supporter_id' => $workingShift->getAttributeValue('supporter_id'),
                'start_time' => $workingShift->getAttributeValue('start_time'),
                'end_time' => $workingShift->getAttributeValue('end_time'),
                'duration' => Carbon::parse($workingShift->start_time)->diffInMinutes($workingShift->end_time),
                'room' => $workingShift->getAttributeValue('room'),
                'teacher_timestamp' => $workingShift->getAttributeValue('teacher_timestamp'),
                'supporter_timestamp' => $workingShift->getAttributeValue('supporter_timestamp'),
                'teacher_comment' => $workingShift->getAttributeValue('teacher_comment'),
                'supporter_comment' => $workingShift->getAttributeValue('supporter_comment'),
            ];
        })->toArray();

        $crudBag->setParam('shiftTemplates', $shiftsTemplates);

        $listCardLogStatus = [
            0 => 'Đi học, đúng giờ',
            1 => 'Đi học, muộn',
            2 => 'Đi học, sớm',
            3 => 'Vắng, có phép',
            4 => 'Vắng, không phép',
            5 => 'Không điểm danh',
        ];

        $crudBag->setParam('listCardLogStatus', $listCardLogStatus);

        $cardsTemplate = $studyLog->CardLogs()?->get()->map(function (CardLog $cardLog) {
            return [
                'card_id' => $cardLog->card_id,
                'card_uuid' => $cardLog->Card()->first()->uuid,
                'student_id' => $cardLog->Card()->first()->Student()->first()->id,
                'student_uuid' => $cardLog->Card()->first()->Student()->first()->uuid,
                'student_name' => $cardLog->Card()->first()->Student()->first()->name,
                'student_avatar' => $cardLog->Card()->first()->Student()->first()->avatar,
                'attended_days' => $cardLog->Card()->first()->attended_days + $cardLog->Card()->first()->van,
                'can_use_day' => $cardLog->Card()->first()->can_use_day,
                'day' => $cardLog->day,
                'status' => $cardLog->status,
                'reason' => '',
                'teacher_note' => $cardLog->teacher_note,
                'supporter_note' => $cardLog->supporter_note,
            ];
        });

        $newCardTemplate = Card::query()->where('classroom_id', $studyLog->classroom_id)->get()->map(function (Card $card) {
            return [
                'card_id' => $card->id,
                'card_uuid' => $card->uuid,
                'student_id' => $card->Student()->first()->id,
                'student_uuid' => $card->Student()->first()->uuid,
                'student_name' => $card->Student()->first()->name,
                'student_avatar' => $card->Student()->first()->avatar,
                'attended_days' => $card->attended_days + $card->van,
                'can_use_day' => $card->can_use_day,
                'day' => 1,
                'status' => 0,
                'reason' => '',
                'teacher_note' => '',
                'supporter_note' => '',
            ];
        });

        $collection1 = new Collection($cardsTemplate);
        $collection2 = new Collection($newCardTemplate);
        $result = $collection1->concat($collection2)->groupBy('card_id')->map(function ($group) {
            return $group->first(); // Chọn phần tử đầu tiên của mỗi nhóm
        })->values()->all();

        $crudBag->setParam('studylog_id', $studyLog->id);
        $crudBag->setParam('video', $studyLog->video);
        $crudBag->setParam('audio', $studyLog->audio);
        $crudBag->setParam('file', $studyLog->file);
        $crudBag->setParam('link', $studyLog->link);
        $crudBag->setParam('notes', $studyLog->notes);
        $crudBag->setParam('title', $studyLog->title);
        $crudBag->setParam('content', $studyLog->content);


        $crudBag->setParam('cardsTemplates', $result);

        return view('studylog.edit', [
            'crudBag' => $crudBag,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function update(Request $request, int $id): RedirectResponse|View
    {


        $modifyAttributes = [];

        $crudBag = new CrudBag();

        $listCardLogStatus = [
            0 => 'Đi học, đúng giờ',
            1 => 'Đi học, muộn',
            2 => 'Đi học, sớm',
            3 => 'Vắng, có phép',
            4 => 'Vắng, không phép',
            5 => 'Không điểm danh',
        ];


        $crudBag->setParam('step', 4);

        $cardsTemplates = [];
        $shiftTemplates = [];

        $shifts = [];

        $validate = Validator::make($request->all(), [
            'shifts.*.teacher_timestamp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'shifts.*.supporter_timestamp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        foreach ($request->get('shifts') as $key => $shift) {
            $files = $request->file('shifts')[$key] ?? [];

            if (isset($files['teacher_timestamp'])) {
                $teacherTimestamp = uploads($files['teacher_timestamp']);
            }else {
                $teacherTimestamp = $shift['alt_teacher_timestamp'];
            }

            if (isset($files['supporter_timestamp'])) {
                $supporterTimestamp = uploads($files['supporter_timestamp']);
            }else {
                $supporterTimestamp = $shift['alt_supporter_timestamp'];
            }


            $shifts[$key] = array_merge($shift, [
                'teacher_timestamp' => $teacherTimestamp,
                'supporter_timestamp' => $supporterTimestamp,
            ]);
        }

        $request->merge([
            'shifts' => $shifts
        ]);

        foreach ($request->get('shifts') as $key => $shift) {
            $dataShift = json_decode($shift['template'], true);
            $shiftTemplates[$key] = array_replace($dataShift, $shift);
        }

        foreach ($request->get('cardlogs') as $key => $cardlog) {
            $dataCard = json_decode($cardlog['template'], true);
            $cardsTemplates[$key] = array_replace($dataCard, $cardlog);
        }

        $crudBag->setParam('cardsTemplates', $cardsTemplates);
        $crudBag->setParam('shiftTemplates', $shiftTemplates);
        $crudBag->setParam('listCardLogStatus', $listCardLogStatus);
        $crudBag->setParam('classroom_id', $request->get('classroom_id'));
        $crudBag->setParam('classroom_schedule_id', $request->get('classroom_schedule_id'));
        $crudBag->setParam('studylog_day', $request->get('studylog_day'));


        request()->session()->flash('shiftTemplates', $shiftTemplates);

        /**
         * @var StudyLog $studyLog
         */
        $studyLog = StudyLog::where('id', $id)->firstOrFail();

        $validate = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'studylog_day' => 'required',
            'classroom_schedule_id' => 'required',
            'shifts' => 'array|required',
            'shifts.*.start_time' => 'required',
            'shifts.*.end_time' => 'required',
            'shifts.*.room' => 'string|nullable',
            'shifts.*.teacher_id' => 'required|exists:users,id',
            'shifts.*.supporter_id' => 'required|exists:users,id',
            'shifts.*.teacher_comment' => 'string|nullable',
            'shifts.*.supporter_comment' => 'string|nullable',
            'shifts.*.supporter_timestamp' => 'required',
            'shifts.*.teacher_timestamp' => 'required',
            'cardlogs' => 'array|required',
            'cardlogs.*.student_id' => 'required|exists:users,id',
            'cardlogs.*.card_id' => 'required|integer',
            'cardlogs.*.day' => 'string',
            'cardlogs.*.status' => 'integer|in:0,1,2,3,4,5',
            'cardlogs.*.teacher_note' => 'string|nullable',
            'cardlogs.*.supporter_note' => 'string|nullable',
        ]);

        if ($validate->fails()) {

            return redirect()->back()->withErrors($validate);
        }

        $this->handleCheckModify(
            $studyLog,
            $request->input(),
            [
                'title',
                'content',
                'image',
                'video',
                'file',
                'link',
                'notes',
            ], $modifyAttributes);

        $oldCardLog = $studyLog->CardLogs()->get()->toArray();

        $this->handleCheckModifyCardLog($oldCardLog, $cardsTemplates, $modifyAttributes);

        $oldWorkingShift = $studyLog->WorkingShifts()->get()->toArray();

        $this->handleCheckModifyWorkingShift($oldWorkingShift, $shiftTemplates, $modifyAttributes);

        $dataToUpdateStudyLog = [
            'title' => $request->get('title') ?? 'Buổi học ngày ' . Carbon::parse($request->get('studylog_day'))->isoFormat('DD/MM/YYYY'),
            'content' => $request->get('content') ?? '',
            'image' => $request->get('image'),
            'video' => $request->get('video'),
            'file' => $request->get('file'),
            'link' => $request->get('link'),
            'notes' => $request->get('notes'),
        ];

        DB::transaction(function () use ($modifyAttributes, $studyLog, $cardsTemplates, $dataToUpdateStudyLog, $request, $shiftTemplates) {
            $studyLog->update($dataToUpdateStudyLog);

            $studyLog->CardLogs()->delete();

            foreach ($cardsTemplates as $cardLog) {
                /**
                 * @var Card $card
                 */
                $card = Card::query()->find($cardLog['card_id']);

                $dataToCreateCardLog = [
                    'card_id' => $cardLog['card_id'],
                    'student_id' => $cardLog['student_id'],
                    'studylog_id' => $studyLog['id'],
                    'day' => $cardLog['day'] == 'on' ? 1 : 0,
                    'fee' => $cardLog['day'] == 'on' ? $card->getDailyFeeAttribute() : 0,
                    'active' => CardLog::UNVERIFIED,
                    'status' => $cardLog['status'],
                    'reason' => '',
                    'teacher_note' => $cardLog['teacher_note'] ?? '',
                    'supporter_note' => $cardLog['supporter_note'] ?? '',
                ];

                CardLog::query()->create($dataToCreateCardLog);
            }

            $studyLog->WorkingShifts()->delete();

            foreach ($shiftTemplates as $shiftTemplate) {
                $dataToCreateWorkingShift = [
                    'staff_id' => Auth::id(),
                    'teacher_id' => $shiftTemplate['teacher_id'],
                    'supporter_id' => $shiftTemplate['supporter_id'],
                    'room' => $shiftTemplate['room'] ?? '',
                    'teacher_timestamp' => $shiftTemplate['teacher_timestamp'],
                    'supporter_timestamp' => $shiftTemplate['supporter_timestamp'],
                    'start_time' => $shiftTemplate['start_time'],
                    'end_time' => $shiftTemplate['end_time'],
                    'studylog_id' => $studyLog['id'],
                    'status' => WorkingShift::UNVERIFIED,
                    'teacher_comment' => $shiftTemplate['teacher_comment'],
                    'supporter_comment' => $shiftTemplate['supporter_comment'],
                ];

                WorkingShift::query()->create($dataToCreateWorkingShift);
            }

//            Comment::query()->create([
//                'user_id' => Auth::id(),
//                'object_type' => Comment::STUDY_LOG_COMMENT,
//                'object_id' => $studyLog->id,
//                'content' => 'Chỉnh sửa thông tin buổi học',
//                'type' => Comment::LOG_TYPE
//            ]);

            Comment::query()->create([
                'user_id' => Auth::id(),
                'object_type' => Comment::STUDY_LOG_COMMENT,
                'object_id' => $studyLog->id,
                'content' => json_encode($modifyAttributes),
                'type' => Comment::ATTRIBUTES_MODIFY_TYPE
            ]);
        });

        $collectedWorkingShiftUser = $this->collectWorkingShiftUser($shiftTemplates);

        $collectedWorkingShiftUser[] = $studyLog['created_by'];

        $staff = Staff::query()->where('branch', Auth::user()->{'branch'})->pluck('id')->toArray();

        $collectedWorkingShiftUser = array_merge($collectedWorkingShiftUser, $staff);

        $collectedWorkingShiftUser[] = Branch::query()->where('uuid', Auth::user()->{'branch'})->first()->host_id;

        DesktopNotification::sendNotification(new NotificationObject(
            title: Auth::user()->{'name'} . ' đã cập nhật thông tin buổi học',
            body: Auth::user()->{'name'} . ' đã cập nhật thông tin buổi học ' . $studyLog->getSupportIdAttribute(),
            user_ids: $collectedWorkingShiftUser,
            thumbnail: '',
            ref: url('studylog/show/' . $studyLog->id),
            attributes: []
        ));


        return redirect()->to('studylog/show/' . $studyLog->id)->with('success', "Cập nhật thành công");
    }

    /**
     * @param $old
     * @param $new
     * @param array $attributes
     * @param $modifyAttributes
     * @return void
     */
    private function handleCheckModify($old, $new, array $attributes, &$modifyAttributes)
    {
        foreach ($attributes as $attribute) {
            $inputValue = $new[$attribute] ?? null;
            if ($old[$attribute] != $inputValue) {
                $modifyAttributes[] = [
                    'name' => $attribute,
                    'old' => $old[$attribute],
                    'new' => $inputValue
                ];
            }
        }
    }

    private function handleCheckModifyCardLog(array $oldCardLog, array $cardsTemplates, array &$modifyAttributes)
    {
        foreach ($oldCardLog as $oldCard) {
            foreach ($cardsTemplates as $cardsTemplate) {
                if ($cardsTemplate['card_id'] == $oldCard['card_id']) {
                    $cardsTemplate['day'] = $cardsTemplate['day'] == 'on' ? 1 : 0;
                    $this->handleCheckModify($oldCard, $cardsTemplate, [
                        'day',
                        'status',
                        'teacher_note',
                        'supporter_note',
                    ],
                        $modifyAttributes['card_log'][$cardsTemplate['card_id']]
                    );
                }
            }
        }
    }

    private function handleCheckModifyWorkingShift(array $oldWorkingShift, array $shiftTemplates, array &$modifyAttributes)
    {
        foreach ($shiftTemplates as $key => $shiftTemplate) {
            if (isset($oldWorkingShift[$key])) {
                $shiftTemplate['staff_id'] = $shiftTemplate['staff_id'] ?? Auth::id();
                $this->handleCheckModify($oldWorkingShift[$key], $shiftTemplate, [
                    'staff_id',
                    'supporter_id',
                    'teacher_id',
                    'room',
                    'start_time',
                    'end_time',
                    'teacher_timestamp',
                    'supporter_timestamp',
                    'teacher_comment',
                    'supporter_comment',
                    'status'
                ], $modifyAttributes['working_shift'][$key + 1]);
            }
        }
    }

    private function collectWorkingShiftUser(array $shiftTemplates): array
    {
        $userIds = [];

        foreach ($shiftTemplates as $shiftTemplate) {
            $userIds[] = $shiftTemplate['teacher_id'];
            $userIds[] = $shiftTemplate['supporter_id'];
            $userIds[] = $shiftTemplate['staff_id'] ?? Auth::id();
        }

        return $userIds;
    }
}
