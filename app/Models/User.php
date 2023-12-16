<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STUDENT_ROLE = 2;

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

        return "BSM-" . $branch . "-" . $code . "." . $uuid;
    }
}
