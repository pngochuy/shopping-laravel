<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * - Mặc định mapping đến bảng có tên blogs trong databse. (Nên ko cần ghi blogs)
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable.
     * Lọc cột dữ liệu trong model có thể xử lí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image',
        'description',
        'content'
    ];
}
