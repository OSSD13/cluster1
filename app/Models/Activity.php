<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';  // กำหนดชื่อของตาราง
    protected $primaryKey = 'act_id'; // กำหนด primary key ของตาราง

    // กำหนดฟิลด์ที่สามารถบันทึกข้อมูลได้
    protected $fillable = [
        'act_title',
        'act_description',
        'act_cat_id',
        'status',
        'act_submit_by',
        'act_save_by',
        'act_date', // เพิ่ม act_date เพื่อรองรับข้อมูลวันที่
    ];

    /**
     * ความสัมพันธ์กับ Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'act_cat_id', 'cat_id');
    }

    /**
     * ความสัมพันธ์กับ User (ผู้สร้างกิจกรรม)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'act_submit_by');
    }

    /**
     * ความสัมพันธ์กับ User (ผู้บันทึกกิจกรรม)
     */
    public function saver()
    {
        return $this->belongsTo(User::class, 'act_save_by');
    }

    /**
     * ความสัมพันธ์กับ VarImage (รูปภาพที่เกี่ยวข้องกับกิจกรรม)
     */
    public function images()
    {
        return $this->hasMany(VarImage::class, 'img_act_id');
    }
}