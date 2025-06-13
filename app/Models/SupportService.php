<?php

namespace App\Models;

class SupportService extends BaseModel
{
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_service')
            ->withPivot('notes')
            ->withTimestamps();
    }
}
