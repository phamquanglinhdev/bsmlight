<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    const RENEW_TYPE = 'renew';
    const NEW_TYPE = 'new';

    protected $table = 'transactions';

    protected $guarded = ['id'];

    public const CARD_TRANSACTION_TYPE = 'card';
    public const ACTIVE_STATUS = 1;
    public const PENDING_STATUS = 0;
    public const CANCEL_STATUS = 2;

    public function affiliates(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_id', 'id');
    }

    public function Creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
