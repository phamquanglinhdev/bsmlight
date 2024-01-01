<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkingShift extends Model
{
    use HasFactory;

    public const TEMPLATE = [
        'teacher_id' => '',
        'supporter_id' => '',
        'start_time' => '',
        'end_time' => '',
        'room' => '',
        'teacher_timestamp' => '',
        'supporter_timestamp' => '',
        'teacher_comment' => '',
        'supporter_comment' => '',
    ];
    const UNVERIFIED = 0;
    const VERIFIED = 1;

    public function Teacher(): BelongsTo
    {
       return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
    public function Supporter(): BelongsTo{
        return $this->belongsTo(Supporter::class, 'supporter_id', 'id');
    }
    public function Staff(): BelongsTo{
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }


    protected $table = 'working_shifts';
    protected $guarded = ['id'];

}
