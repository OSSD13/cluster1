<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cat_id',
        'status',
        'submited_by',
        'due_date',
    ];
}
