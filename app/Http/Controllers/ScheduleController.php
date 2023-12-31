<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\Supporter;
use App\Models\Teacher;
use App\Models\WorkingShift;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function staticAddSchedule(Request $request): View
    {
        $scheduleTemplate = ClassroomSchedule::TEMPLATE;

        $scheduleKey = $request->get('id') ?? 1;

        $teacherList = Teacher::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Teacher $teacher) {
            return [$teacher->id => $teacher->uuid . " - " . $teacher->name];
        })->all();

        $supporterList = Supporter::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Supporter $supporter) {
            return [$supporter->id => $supporter->uuid . " - " . $supporter->name];
        })->all();

        return view('fields.custom_fields.schedule', [
            'schedule' => $scheduleTemplate,
            'scheduleKey' => $scheduleKey,
            'teacherList' => $teacherList,
            'supporterList' => $supporterList
        ]);
    }

    public function staticAddShift(Request $request): View
    {
        return \view('fields.custom_fields.shift', [
            'teacherList' => Teacher::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Teacher $teacher) {
                return [$teacher->id => $teacher->uuid . " - " . $teacher->name];
            }),
            'supporterList' => Supporter::query()->get(['id', 'name', 'uuid'])->mapwithkeys(function (Supporter $supporter) {
                return [$supporter->id => $supporter->uuid . " - " . $supporter->name];
            }),
            'scheduleKey' => $request->get('schedule_id'),
            'shift' => ClassroomShift::TEMPLATE,
            'shiftKey' => $request->get('shift_id')
        ]);
    }

    public function staticAddShiftTemplate(Request $request): View
    {
        $listTeacher = Teacher::query()->get(['id', 'name', 'uuid'])->mapWithKeys(function ($teacher) {
            return [$teacher->id => $teacher->uuid . ' - ' . $teacher->name];
        });

        $listSupporter = Supporter::query()->get(['id', 'name', 'uuid'])->mapWithKeys(function ($supporter) {
            return [$supporter->id => $supporter->uuid . ' - ' . $supporter->name];
        });

        return \view('studylog.shiftTemplates', [
            'shiftKey' => $request->get('shift_id'),
            'shiftTemplate' => WorkingShift::TEMPLATE,
            'listTeacher' => $listTeacher,
            'listSupporter' => $listSupporter
        ]);
    }

    public function staticAddCardTemplate(Request $request): View
    {
        $listCardLogStatus = [
            0 => 'Đi học, đúng giờ',
            1 => 'Đi học, muộn',
            2 => 'Đi học, sớm',
            3 => 'Vắng, có phép',
            4 => 'Vắng, không phép',
            5 => 'Không điểm danh',
        ];

        $card = Card::find($request->get('card_id'));
        $card->update([
            'classroom_id' => $request->get('classroom_id'),
        ]);

        $cardTemplate = [
            'card_id' => $card->id,
            'card_uuid' => $card->uuid,
            'student_id' => $card->student_id,
            'student_uuid' => $card->student?->uuid,
            'student_name' => $card->student?->name,
            'student_avatar' => $card->student?->avatar,
            'attended_days' => $card->attended_days + $card->van,
            'can_use_day' => $card->can_use_day,
            'day' => 0,
            'fee' => 0,
            'status' => null,
            'reason' => '',
            'teacher_note' => '',
            'supporter_note' => '',
        ];
        /**
         * @var array $cardTemplate
         * @var int $cardKey
         * @var array $listCardLogStatus
         */
        return \view('studylog.cardsTemplate', [
            'cardTemplate' => $cardTemplate,
            'cardKey' => $request->get('card_key'),
            'listCardLogStatus' => $listCardLogStatus
        ]);
    }
}
