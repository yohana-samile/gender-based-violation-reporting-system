<?php

namespace App\Models;

class Specialist extends BaseModel
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
