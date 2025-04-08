<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    //
    protected $table = "provinces";
    protected $primaryKey = "pvc_id";
    protected $fillable = ['pvc_name'];
    public $timestamps = false;
    public function users()
    {
        return $this->hasMany(User::class, 'province', 'pvc_id');
    }
}
