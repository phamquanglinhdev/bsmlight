<?php

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        ]
    ];
}

function definePermission(): array
{
    return [
        User::TEACHER_ROLE => [
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
        ],

    ];
}

if (!function_exists('check_permission')) {
    function check_permission($key): bool
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', Auth::user()->{'id'})->first();

        $role = $user->role;

        $permission = Permission::query()->where('key', $key)->first();

        if (!$permission) {
            abort(404);
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

        $permission = Permission::query()->where('key', $permissionName)->first();

        if (!$permission) {
            abort(404);
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


