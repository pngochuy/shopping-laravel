<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * The attributes that are mass assignable.
     * Lọc cột dữ liệu trong model có thể xử lí.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country'
    ];
}
