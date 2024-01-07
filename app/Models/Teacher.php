<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Teacher extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "users";
    protected $guarded = ["id"];

    const INTERNAL_SOURCE = 1;
    const EXTERNAL_SOURCE = 2;
    protected $appends = [
        'teacher_source'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('role', function (Builder $builder) {
            $builder->where('role', User::TEACHER_ROLE);
        });
        static::addGlobalScope('branch', function (Builder $builder) {
            $builder->where('branch', Auth::user()->{'branch'});
        });
    }

    public function profile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class, "user_id", "id");
    }

    /**
     * @return int
     */
    public function getTeacherSourceAttribute(): int
    {
        $profile = $this->profile()->first();

        return $profile->teacher_source ?? Teacher::INTERNAL_SOURCE;
    }

    public function getCustomField(string $name)
    {
        $extraInformation = $this->profile?->extra_information;
        if (!$extraInformation) {
            return null;
        }
        $extraInformation = json_decode($extraInformation, true);
        return $extraInformation[$name] ?? null;
    }
}
