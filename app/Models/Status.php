<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['slug', 'name', 'color_class', 'text_color_class'];
}
