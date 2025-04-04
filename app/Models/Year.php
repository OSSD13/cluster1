<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    //
    protected $table = "years";
    protected $primaryKey = "year_id";
    protected $fillable = ['year_name'];
    public $timestamps = false;

}
