<?php

namespace App\Http\Controllers;

use App\Models\ClassroomSchedule;
use App\Models\ClassroomShift;
use App\Models\Supporter;
use App\Models\Teacher;
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
}
