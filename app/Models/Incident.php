<?php
namespace App\Models;

use App\Models\Access\User;
use Illuminate\Support\Facades\Cache;

class Incident extends BaseModel
{
    protected $casts = [
        'occurred_at' => 'datetime',
        'is_anonymous' => 'boolean'
    ];

    protected static function booted()
    {
        static::created(function () {
            Cache::forget('dashboard_metrics');
        });

        static::updated(function () {
            Cache::forget('dashboard_metrics');
        });

        static::deleted(function () {
            Cache::forget('dashboard_metrics');
        });
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function victims()
    {
        return $this->hasMany(Victim::class);
    }

    public function perpetrators()
    {
        return $this->hasMany(Perpetrator::class);
    }

    public function evidence()
    {
        return $this->hasMany(Evidence::class);
    }

    public function updates()
    {
        return $this->hasMany(CaseUpdate::class, 'incident_id');
    }

    public function statusModel()
    {
        return $this->belongsTo(Status::class, 'status', 'slug');
    }

    public function supportServices()
    {
        return $this->belongsToMany(SupportService::class, 'incident_service')
            ->withPivot('notes')
            ->withTimestamps();
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
}
