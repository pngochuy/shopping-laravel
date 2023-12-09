<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Lọc cột dữ liệu trong model có thể xử lí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userID',
        'blogID',
        'rate',
    ];
}
