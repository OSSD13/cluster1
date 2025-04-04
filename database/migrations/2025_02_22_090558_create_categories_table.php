<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('cat_id');
            $table->string('cat_name', 100)->unique();
            $table->boolean('cat_ismandatory')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('cat_year_id');
            $table->enum('status', ['pending', 'published'])->default('pending');
            $table->date('expiration_date')->nullable(); // เพิ่มคอลัมน์ expiration_date

            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('cat_year_id')->references('year_id')->on('years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
