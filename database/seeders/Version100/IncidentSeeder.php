<?php

use App\Models\Incident;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    public function run()
    {
        Incident::factory()->count(5)->create(['reporter_id' => 1]);
    }
}
