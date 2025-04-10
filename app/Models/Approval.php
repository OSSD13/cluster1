<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'var_approvals';
    protected $primaryKey = 'apv_id';
    public $timestamps = false;

    protected $fillable = [
        'apv_act_id',
        'apv_approver',
        'apv_level',
        'apv_comment',
        'apv_date',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'apv_act_id', 'act_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'apv_approver', 'user_id');
    }

    public static function categoriesWithComments()
    {
        return \App\Models\Category::whereHas('activities.approvals', function ($query) {
            $query->whereNotNull('apv_comment');
        })->get();
    }
}
