<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $created_at
 */
class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $guarded = ['id'];

    protected $appends = [
        'distance_time'
    ];

    public function getDistanceTimeAttribute(): string
    {
        $dateInterval = Carbon::parse($this->created_at);

        return $dateInterval->diffForHumans(Carbon::now());
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userAvatar()
    {
        return $this->User()->first()?->avatar;
    }
}
