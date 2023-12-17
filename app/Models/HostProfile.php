<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HostProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "hosts_profiles";
    protected $guarded = ["id"];
}
