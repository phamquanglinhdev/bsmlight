<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Host extends User
{
    use HasFactory;
    use SoftDeletes;

    const UNSELECT_BRANCH = "UNSELECT";
    protected $table = "users";
    protected $guarded = ["id"];

    public function profile(): HasOne
    {
        return $this->hasOne(HostProfile::class, "user_id", "id");
    }
}
