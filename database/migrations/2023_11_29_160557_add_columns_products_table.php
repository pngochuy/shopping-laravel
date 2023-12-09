<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Kiểu dữ liệu unsigned được sử dụng để chỉ định rằng cột không chứa giá trị âm và chỉ chứa các giá trị không âm (tức là số nguyên không dấu)
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // name, price, detail, image (tối đa 3 ảnh), category_id, brand_id, user_id, status, sale_price, company_profile
            $table->string('name')->after('id');
            // $table->decimal('price', 10, 2)->after('name'); // 10 chữ số (8 chữ số trước dấu thập phân và 2 chữ số sau dấu thập phân)
            $table->integer('price')->after('name');
            $table->string('detail')->after('price');
            $table->string('image')->after('detail');
            $table->integer('category_id')->after('image');
            $table->integer('brand_id')->after('category_id');
            $table->boolean('status')->after('brand_id')->default(0)->comment = '0:new 1:sale';
            $table->integer('sale_price')->after('status')->default(0);
            $table->string('company_profile')->after('sale_price');
            $table->integer('user_id')->after('company_profile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
