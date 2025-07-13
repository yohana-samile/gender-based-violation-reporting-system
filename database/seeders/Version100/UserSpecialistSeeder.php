<?php

use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\User;
use App\Models\Specialist;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class UserSpecialistSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    public function run()
    {
        $specialists = Specialist::all();

        $users = User::query()->where('is_specialist', true)->get();
        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create(['is_specialist' => true]);
        }

        $roleNames = ['law_enforcement', 'reporter'];
        $permissionNames = ['law_enforcement', 'reporter'];

        $roles = Role::whereIn('name', $roleNames)->get();
        $permissions = Permission::whereIn('name', $permissionNames)->get();

        foreach ($users as $user) {
            $specializations = $specialists->random(rand(1, 3))->pluck('id');
            $user->specializations()->sync($specializations);
            $user->roles()->sync($roles->pluck('id')->toArray());
            $user->permissions()->sync($permissions->pluck('id')->toArray());
        }
    }
}
