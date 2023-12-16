<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends User
{
    use HasFactory;

    const MALE = 0;
    const FEMALE = 1;
    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    public function profile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, "user_id", "id");
    }

    protected $appends = [
        'status',
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
        return 1;
    }

    public function getGradeAttribute()
    {
        return 1;
    }

    public function getLevelAttribute()
    {
        return 1;
    }

    public function getZaloPrivateChatAttribute()
    {
        return 1;
    }

    public function getStatusAttribute($value)
    {
        return $this->profile?->status;
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
