<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 */
class Comment extends Model
{
    use HasFactory;

    const TEXT_TYPE = 0;
    const IMAGE_TYPE = 1;
    const ATTACHMENT_TYPE = 2;
    const STUDY_LOG_COMMENT = "studylog";
    const CARD_COMMENT = "card";
    const LOG_TYPE = 2;

    protected $table = 'comments';
    protected $guarded = ['id'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
