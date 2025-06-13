<?php

namespace App\Models;

class Victim extends BaseModel
{
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
