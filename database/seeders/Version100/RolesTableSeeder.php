<?php

use App\Models\Access\Role;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    public function run() {
        $exists = Role::query()->count();
        if($exists == 0){
            $roles = [
                ['name' => 'administration', 'display_name' => 'Administration', 'description' => 'Administrative access', 'isadmin' => 1],
                ['name' => 'case_worker', 'display_name' => 'Case Worker', 'description' => 'deal with all reported case', 'isadmin' => 1],
                ['name' => 'reporter', 'display_name' => 'Reporter', 'description' => 'report any case', 'isadmin' => 0],
                ['name' => 'law_enforcement', 'display_name' => 'Law Enforcement', 'description' => 'enforce laws to any reported case', 'isadmin' => 0],
            ];

            foreach ($roles as $role) {
                Role::updateOrCreate(
                    ['name' => $role['name']],
                    array_merge($role, [
                        'isactive' => 1,
                        'guard_name' => 'api',
                        'uid' => Str::uuid(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ])
                );
            }
        }
        $this->alterIdSequence('roles');
    }
}
