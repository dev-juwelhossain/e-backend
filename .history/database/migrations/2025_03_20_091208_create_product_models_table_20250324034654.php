<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_models', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('select_category')->nullable();
            $table->string('availability')->nullable();
            $table->string('regular_price')->nullable();
            $table->string('selling_price')->nullable();
            $table->string('product_description')->nullable();
            $table->string('p_short_des')->nullable();
            $table->string('product_image')->nullable();
            $table->string('image_gallary')->nullable();
            $table->string('select_sub_category')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_models');
    }
};
