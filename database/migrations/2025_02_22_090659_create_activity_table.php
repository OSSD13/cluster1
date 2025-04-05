<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id('act_id');
            $table->string('act_title')->varchar(100);
            $table->text('act_description');
            $table->unsignedBigInteger('act_cat_id');
            $table->date('act_date');  // เพิ่มคอลัมน์ act_date เพื่อเก็บวันที่ทำกิจกรรม

            // สถานะกิจกรรมรองรับการส่งกลับเป็นขั้นตอน
            $table->enum('status', ['Saved','Edit','Sent','Approve_by_province','unapproved_by_central','Approve_by_central'])->default('Saved');
            $table->unsignedBigInteger('act_submit_by');
            $table->unsignedBigInteger('act_save_by');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();

            // Foreign Keys
            $table->foreign('act_cat_id')->references('cat_id')->on('categories')->onDelete('cascade');
            $table->foreign('act_submit_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('act_save_by')->references('user_id')->on('users')->onDelete('cascade');

        });

        Schema::create('var_images', function (Blueprint $table) {
            $table->id('img_id');
            $table->unsignedBigInteger('img_act_id');
            $table->string('img_path');
            $table->string('img_name');
            //$table->timestamp('img_uploaded_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('img_uploaded_at');


            // Foreign Keys
            $table->foreign('img_act_id')->references('act_id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity'); // ใช้ชื่อตารางให้ตรงกัน
    }
};
