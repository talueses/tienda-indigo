<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $fillable = ['nombre', 'valor'];
    protected $table = "generales";
}
