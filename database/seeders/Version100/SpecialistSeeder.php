<?php

use App\Models\Specialist;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class SpecialistSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    public function run()
    {
        $count = Specialist::query()->count('id');
        if ($count == 0) {
            $specialists = [
                ['name' => 'Child Protection', 'description' => 'Specializes in cases involving minors'],
                ['name' => 'Domestic Violence', 'description' => 'Specializes in domestic abuse cases'],
                ['name' => 'Sexual Violence', 'description' => 'Specializes in sexual assault cases'],
                ['name' => 'Psychological Abuse', 'description' => 'Specializes in emotional and psychological abuse'],
                ['name' => 'Elder Abuse', 'description' => 'Specializes in cases involving elderly victims'],
                ['name' => 'Human Trafficking', 'description' => 'Specializes in trafficking cases'],
            ];

            foreach ($specialists as $specialist) {
                Specialist::create($specialist);
            }
        }
    }
}
