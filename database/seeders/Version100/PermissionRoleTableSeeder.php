<?php

use App\Models\Access\Permission;
use App\Models\Access\Role;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Auto generated seed file
     * developed by developer samile (samileking9@gmail.com))
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys("permission_role");
        $this->delete('permission_role');

        $this->assignPermissionsToRole('administration', Permission::query()->pluck('id')->toArray());
        $this->assignPermissionsToRole('case_worker', ['case_worker']);
        $this->assignPermissionsToRole('reporter', ['reporter']);
        $this->assignPermissionsToRole('law_enforcement', ['law_enforcement']);
        $this->enableForeignKeys('permission_role');
    }

    protected function assignPermissionsToRole($roleName, $permissionNames): void
    {
        $roleId = Role::query()->where('name', $roleName)->value('id');
        if (!$roleId) return;

        if (is_array($permissionNames)) {
            $permissionIds = ctype_digit(implode('', $permissionNames)) || is_int($permissionNames[0])
                ? $permissionNames
                : DB::table('permissions')
                    ->whereIn('name', $permissionNames)
                    ->pluck('id')
                    ->toArray();
        } else {
            $permissionIds = is_numeric($permissionNames)
                ? [$permissionNames]
                : DB::table('permissions')
                    ->where('name', $permissionNames)
                    ->pluck('id')
                    ->toArray();
        }

        $insertData = array_map(function($permissionId) use ($roleId) {
            return [
                'permission_id' => $permissionId,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $permissionIds);

        DB::table('permission_role')->insert($insertData);
    }
}
