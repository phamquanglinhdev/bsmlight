<?php

use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

#SCOPE

function defineScope(): array
{
    return [
        User::HOST_ROLE => [
            'student',
            'teacher',
            'supporter',
            'staff',
            'classroom',
            'card',
            'transaction',
            'inventory',
            'studylog',
            'custom_field',
        ],
        User::STUDENT_ROLE => [

        ],
        User::TEACHER_ROLE => [

        ],
        User::STAFF_ROLE => [
            'student',
            'teacher',
            'supporter',
            'studylog',
            'transaction',
            'classroom',
            'card',
        ],
        User::SUPPORTER_ROLE => [

        ]
    ];
}

function definePermission(): array
{
    return [
        User::HOST_ROLE => [

        ],
        User::TEACHER_ROLE => [
            'create studylog',
            'list student',
            'show student',
            'list studylog',
            'create studylog',
            'edit studylog',
            'list studylog',
            'list classroom',
            'show classroom',
        ],
        User::SUPPORTER_ROLE => [
            'create studylog',
            'list student',
            'show student',
            'list studylog',
            'create studylog',
            'edit studylog',
            'list studylog',
            'list classroom',
            'show classroom',
        ],
        User::STUDENT_ROLE => [
            'list transaction',
            'show card',
            'list card',
            'list studylog',
            'list classroom',
            'show classroom'
        ],
        User::STAFF_ROLE => [

        ]
    ];
}

if (!function_exists('check_permission')) {
    function check_permission(string $key): bool
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->{'id'})->first();

        $role = $user->role;

        $myScope = defineScope()[$role];

        $module = explode(' ', $key)[1];

        if (in_array($module, $myScope)) {
            return true;
        }

        if (in_array($key, definePermission()[$role])) {
            return true;
        }

        $permission = Permission::query()->where('key', $key)->first();

        if (!$permission) {
            return false;
        }

        if (in_array($permission['module'], defineScope()[$role])) {
            return true;
        }

        if (in_array($key, definePermission()[$role])) {
            return true;
        }

        if ($user->permissions()->where('key', $key)->first()) {
            return true;
        }

        return false;
    }
}

if (!function_exists('force_permission')) {
    function force_permission($permissionName): bool
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->{'id'})->first();
        if ($user->role === User::HOST_ROLE) {
            return true;
        }
        $permission = Permission::query()->where('key', $permissionName)->first();

        if (!$permission) {
            return false;
        }

        if ($user->permissions()->where('key', $permissionName)->first()) {
            return true;
        }

        return false;
    }
}

if (!function_exists('uploads')) {
    function uploads(\Illuminate\Http\UploadedFile $file): string
    {
        $fileName = Str::random(10) . "_" . $file->getClientOriginalName();

        return "uploads/" . $file->storeAs('', $fileName, 'upload');
    }
}

if (!function_exists('is_module')) {
    function is_module(string $module): string
    {
        $currentUrl = Route::current()->uri();

        return str_contains($currentUrl, $module);
    }
}

if (!function_exists('excel_date')) {
    function excel_date($excelDate): Carbon
    {
        try {
            $timestamp = ($excelDate - 25569) * 86400;

            return Carbon::createFromTimestamp($timestamp);
        }catch (Exception $exception) {
            try {
                return Carbon::createFromFormat("d/m/Y", $excelDate);
            }catch (Exception $exception) {
                return Carbon::now();
            }
        }
    }
}

