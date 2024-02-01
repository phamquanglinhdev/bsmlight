<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const ATTACHMENT_FILE = 'file';
    const ATTACHMENT_IMAGE = 'image';

    protected $table = 'posts';
    protected $guarded = ['id'];

    public const PUBLIC_TYPE = 'public';
    public const PRIVATE_TYPE = 'private';

    public const REACT_LIKE = 'like';
    public const REACT_LOVE = 'love';

    public const REACT_SMILE = 'smile';
}
