<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property int $verified_code
 * @property int $verified
 * @property string $password
 * @property mixed $uuid
 * @property int $role
 * @property mixed $branch
 * @property int $id
 * @property string $avatar
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const  STUDENT_ROLE = 2;
    public const  HOST_ROLE = 1;
    public const TEACHER_ROLE = 3;

    public const SUPPORTER_ROLE = 4;

    public const STAFF_ROLE = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function newUuid(string $branch, string $code): string
    {
        $newestId = User::query()->latest('id')?->first()?->id ?? 0;
        $uuid = $newestId < 1000
            ? sprintf('%04d', $newestId + 1)
            : sprintf('%07d', $newestId + 1);

        return $branch . "-" . $code . "." . $uuid;
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, "user_permission", "user_id", "permission_id");
    }

    public function StudyLogAccept(): HasMany{
        return $this->hasMany(StudyLogAccept::class, 'studylog_id', 'id');
    }

    public function getRoleLabel(): string
    {
        switch ($this->role) {
            case User::STUDENT_ROLE:
                return 'Hoc sinh';
            case User::HOST_ROLE:
                return 'HOST';
            case User::STAFF_ROLE:
                return 'Nhan vien';
            case User::TEACHER_ROLE:
                return 'Giao vien';
            case User::SUPPORTER_ROLE:
                return 'Tro giang';
            default:
                return '';
        }
    }
}
