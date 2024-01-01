<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardLog extends Model
{
    use HasFactory;

    const UNVERIFIED = 0;
    const VERIFIED = 1;

    protected $table = 'card_logs';
    protected $guarded = ['id'];

    public function Student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function Card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }

    public function StatusList(): array
    {
        return [
            0 => 'Đi học, đúng giờ',
            1 => 'Đi học, muộn',
            2 => 'Đi học, sớm',
            3 => 'Vắng, có phép',
            4 => 'Vắng, không phép',
            5 => 'Không điểm danh',
        ];
    }
}
