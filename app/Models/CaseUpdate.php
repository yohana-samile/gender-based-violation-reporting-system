<?php

namespace App\Models;

use App\Models\Access\User;

class CaseUpdate extends BaseModel
{
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
