<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'cat_id'; // ระบุ Primary Key
    public $timestamps = false;

    protected $fillable = ['cat_name', 'description', 'cat_ismandatory', 'expiration_date', 'created_by', 'status'];

    /**
     * ความสัมพันธ์กับ User1 (ผู้สร้างหมวดหมู่)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'cat_id');
    }

    /**
     * ความสัมพันธ์กับกิจกรรมที่ใช้หมวดหมู่นี้
     */
    // public function activities()
    // {
    //     return $this->hasMany(Activity::class, 'category_id');
    // }
    // Category Model
    public function activities()
    {
        return $this->hasMany(Activity::class, 'act_cat_id', 'cat_id');
    }
}
