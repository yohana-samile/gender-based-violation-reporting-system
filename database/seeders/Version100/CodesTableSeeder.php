<?php

use App\Models\System\Code;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class CodesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Auto generated seed file
     * developed by developer samile (samileking9@gmail.com)
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys("codes");
        $this->delete('codes');

        $codes = [
            ['name' => 'User Logs', 'lang' => 'user_log', 'is_system_defined' => 1],
            ['name' => 'Auth User Type', 'lang' => 'auth_user_type', 'is_system_defined' => 1],
            ['name' => 'Gender', 'lang' => 'gender', 'is_system_defined' => 0],
            ['name' => 'Marital Status', 'lang' => 'marital_status', 'is_system_defined' => 0],
            ['name' => 'Case Status', 'lang' => 'case_status', 'is_system_defined' => 1],
            ['name' => 'Case Vulnerability', 'lang' => 'case_vulnerability', 'is_system_defined' => 1],
            ['name' => 'Case type', 'lang' => 'case_type', 'is_system_defined' => 1],
        ];

        foreach ($codes as $code) {
            Code::updateOrCreate(['name' => $code['name']], [
                'lang' => $code['lang'],
                'is_system_defined' => $code['is_system_defined'],
            ]);
        }
        $this->enableForeignKeys("codes");
    }
}
