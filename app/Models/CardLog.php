<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardLog extends Model
{
    use HasFactory;

    const UNVERIFIED = 0;
    const VERIFIED = 1;

    protected $table = 'card_logs';
    protected $guarded = ['id'];
}
