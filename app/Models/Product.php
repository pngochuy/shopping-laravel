<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // name, price, detail, image (tối đa 3 ảnh), category_id, brand_id, user_id, status, sale_price, company_profile
    protected $fillable = [
        'name', 'price', 'detail', 'image', 'category_id', 'brand_id', 'user_id', 'status', 'sale_price', 'company_profile'
    ];
}
