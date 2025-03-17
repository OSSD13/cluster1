<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'cat_name',
        'description',
        'created_by',
        'is_mandatory',
        'due_date',

    ];
}
