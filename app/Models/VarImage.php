<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarImage extends Model
{
    use HasFactory;

    protected $table = 'var_images'; // กำหนดชื่อของตาราง
    protected $primaryKey = 'img_id'; // กำหนด primary key ของตาราง

    // กำหนดฟิลด์ที่สามารถบันทึกข้อมูลได้
    protected $fillable = [
        'img_act_id',
        'img_path',
        'img_name',
        'img_uploaded_at',
    ];

    /**
     * ความสัมพันธ์กับ Activity (กิจกรรมที่เกี่ยวข้องกับรูปภาพ)
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'img_act_id', 'act_id');
    }
    // ใน Activity model
public function images()
{
    return $this->hasMany(VarImage::class, 'img_act_id');
}
}
