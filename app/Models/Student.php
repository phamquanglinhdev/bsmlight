<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Student extends User
{
    use HasFactory;
    use SoftDeletes;

    const MALE = 1;
    const FEMALE = 2;
    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('role', function ($builder) {
            $builder->where('role', User::STUDENT_ROLE);
        });

        static::addGlobalScope('branch', function ($builder) {
            $builder->where('branch', Auth::user()->{'branch'});
        });
    }

    public function profile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, "user_id", "id");
    }

    protected $appends = [
        'gender',
        'english_name',
        'school',
        'facebook',
        'address',
        'user_ref',
        'extra_information',
        'cards',
        'private_chat',
        'zalo_private_chat',
        'birthday',
        'age',
        'grade',
        'level',
        'sibling'
    ];

    public function getSiblingAttribute(): array
    {
        return [
            [
                'id' => 1,
                'uuid' => 'BSM-CN.0001-NguyenThiA'
            ],
            [
                'id' => 2,
                'uuid' => 'BSM-CN.0002-NguyenThiB'
            ],
        ];
    }

    public function getAgeAttribute(): int
    {
        $birthday = Carbon::parse($this->profile?->birthday);

        if ($birthday) {
            return $birthday->diffInYears(Carbon::now());
        }

        return 0;
    }

    public function getGradeAttribute(): string
    {
        $age = $this->getAgeAttribute();
        if ($age <= 3) {
            return "--";
        }
        if ($age <= 5) {
            return "Lớp $age tuổi";
        }
        if ($age <= 17) {
            return "Lớp " . $age - 5;
        }
        return "Khác";
    }

    public function getLevelAttribute(): string
    {
        $age = $this->getAgeAttribute();
        if ($age <= 3) {
            return '--';
        }

        if ($age <= 5) {
            return 'Mầm non';
        }
        if ($age <= 10) {
            return 'Tiểu học';
        }
        if ($age <= 14) {
            return "THCS";
        }
        if ($age <= 17) {
            return "THPT";
        }

        if ($age <= 21) {
            return "Cao Đẳng - Đại Học";
        }

        return 'Người đi làm';
    }

    public function getZaloPrivateChatAttribute(): int
    {
        return 1;
    }


    public function getGenderAttribute($value)
    {
        return $this->profile?->gender;
    }

    public function getEnglishNameAttribute($value)
    {
        return $this->profile?->english_name;
    }

    public function getSchoolAttribute($value)
    {
        return $this->profile?->school;
    }

    public function getFacebookAttribute($value)
    {
        return $this->profile?->facebook;
    }

    public function getAddressAttribute($value)
    {
        return $this->profile?->address;
    }

    public function getUserRefAttribute($value)
    {
        return $this->profile?->user_ref;
    }

    public function getExtraInformationAttribute($value)
    {
        return $this->profile?->extra_information;
    }

    public function getBirthdayAttribute()
    {
        if (!$this->profile?->birthday) {
            return '';
        }
        return Carbon::parse($this->profile?->birthday)->isoFormat('DD-MM-YYYY');
    }

    public function getCardsAttribute(): array
    {
        return [
            [
                'id' => 1,
                'uuid' => 'BSM-B.000-StudyCard.0001'
            ],
            [
                'id' => 2,
                'uuid' => 'BSM-B.000-StudyCard.0001'
            ]
        ];
    }

    public function getPrivateChatAttribute(): string
    {
        return "";
    }
}
