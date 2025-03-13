<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_name',
        'description',
        'created_by',
        'is_mandatory',
        'due_date',
        
    ];
}
