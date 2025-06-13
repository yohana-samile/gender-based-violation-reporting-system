<?php

namespace App\Models;

class Evidence extends BaseModel
{
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
