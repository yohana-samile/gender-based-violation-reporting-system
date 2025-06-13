<?php

namespace App\Models;

class Perpetrator extends BaseModel
{
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
