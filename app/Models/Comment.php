<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Lọc cột dữ liệu trong model có thể xử lí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'blog_id',
        'content',
        'parent_comment_id',
    ];
}
