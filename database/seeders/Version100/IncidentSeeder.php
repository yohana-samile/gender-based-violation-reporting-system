<?php

use App\Models\Incident;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    public function run()
    {
        $count = Incident::query()->count();
        if($count == 0) {
            Incident::factory()->count(10)->create(['reporter_id' => 1]);
        }
    }
}
