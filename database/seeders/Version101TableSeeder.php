<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\DisableForeignKeys;

/**
 * Class AccessTableSeeder.
 */
class Version101TableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $this->call(CodesTableSeeder::class);
        $this->call(CodeValuesTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(SupportServicesSeeder::class);

        $this->call(IncidentSeeder::class);
        DB::commit();
    }
}
