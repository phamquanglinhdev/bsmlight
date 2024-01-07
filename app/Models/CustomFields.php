<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $initValue
 * @property mixed|null $entity_type
 * @property mixed $type
 */
class CustomFields extends Model
{
    use HasFactory;


    protected $table = 'custom_fields';
    protected $guarded = ['id'];

    public const ENTITY_STUDENT = 'student';
    public const ENTITY_TEACHER = 'teacher';
    public const ENTITY_STAFF = 'staff';
    public const ENTITY_SUPPORTER = 'supporter';
    public const TEXT_TYPE = 0;
    public const NUMBER_TYPE = 2;

    public const DATE_TYPE = 3;
    public const DATETIME_TYPE = 4;

    public const SELECT_TYPE = 5;

    public static function backgroundType()
    {
        return [
            self::TEXT_TYPE => 'bg-success',
            self::NUMBER_TYPE => 'bg-primary',
            self::DATE_TYPE => 'bg-info',
            self::DATETIME_TYPE => 'bg-warning',
            self::SELECT_TYPE => 'bg-danger',
        ];
    }

    public static function convertedType()
    {
        return [
            self::TEXT_TYPE => 'text',
            self::NUMBER_TYPE => 'number',
            self::DATE_TYPE => 'date',
            self::DATETIME_TYPE => 'datetime',
            self::SELECT_TYPE => 'select',
        ];
    }


    public function convertInitValue(): mixed
    {
        if (!$this->initValue) {
            return null;
        }

        $initValue = json_decode($this->initValue);

        switch ($initValue->type) {
            case 'user_list':
                return User::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (User $user) {
                    return [$user->id => $user->uuid . "-" . $user->name];
                })->toArray();
            case 'teacher_list':
                return Teacher::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Teacher $teacher) {
                    return [$teacher->id => $teacher->uuid . "-" . $teacher->name];
                })->toArray();
            case 'student_list':
                return Student::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Student $student) {
                    return [$student->id => $student->uuid . "-" . $student->name];
                })->toArray();
            case 'classroom_list':
                return Classroom::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Classroom $classroom) {
                    return [$classroom->id => $classroom->uuid . "-" . $classroom->name];
                });
            case 'supporter_list':
                return Supporter::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Supporter $supporter) {
                    return [$supporter->id => $supporter->uuid . "-" . $supporter->name];
                })->toArray();
            case 'staff_list':
                return Staff::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Staff $staff) {
                    return [$staff->id => $staff->uuid . "-" . $staff->name];
                })->toArray();
            case 'card_list':
                return Card::query()->where('branch', Auth::user()->{'branch'})->get()->mapWithKeys(function (Card $card) {
                    return [$card->id => $card->uuid . "-" . $card->name];
                })->toArray();
            default:
                return [];
        }
    }

    public static function listSource(): array
    {
        return [
            'user_list' => 'Tất cả người dùng trong chi nhánh',
            'teacher_list' => 'Tất cả giáo viên trong chi nhánh',
            'student_list' => 'Tất cả học sinh trong chi nhánh',
            'classroom_list' => 'Tất cả lớp học trong chi nhánh',
            'supporter_list' => 'Tất cả trợ giảng trong chi nhánh',
            'staff_list' => 'Tất cả nhân viên trong chi nhánh',
            'card_list' => 'Tất cả thẻ học trong chi nhánh',
        ];
    }

    public static function listType(): array
    {
        return [
            self::TEXT_TYPE => 'Dạng chữ',
            self::NUMBER_TYPE => 'Dạng số',
            self::DATE_TYPE => 'Dạng ngày',
            self::DATETIME_TYPE => 'Dạng ngày giờ',
            self::SELECT_TYPE => 'Dạng danh sách chọn',
        ];
    }

    public static function listEntityType(): array
    {
        return [
            self::ENTITY_STUDENT => 'Học sinh',
            self::ENTITY_TEACHER => 'Giáo viên',
            self::ENTITY_STAFF => 'Nhân viên',
            self::ENTITY_SUPPORTER => 'Trợ giảng',
        ];
    }

    public static function backgroundEntityType(): array
    {

        return [
            self::ENTITY_STUDENT => 'bg-success',
            self::ENTITY_TEACHER => 'bg-primary',
            self::ENTITY_STAFF => 'bg-info',
            self::ENTITY_SUPPORTER => 'bg-warning',
        ];
    }
}
