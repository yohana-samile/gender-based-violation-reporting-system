<?php

use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
    {
        use \Database\DisableForeignKeys, \Database\TruncateTable;
        public function run(): void
        {
            $this->disableForeignKeys("users");
            $userRepo = new \App\Repositories\Access\UserRepository();
            $count = $userRepo->query()->count();
            if($count == 0) {
                $user = $userRepo->query()->updateOrCreate(['email' => 'samileking9@gmail.com'],[
                    "name" => "King Samile",
                    "is_active" => true,
                    "is_super_admin" => true,
                    "email_verified_at" => now(),
                    "email" => "samileking9@gmail.com",
                    "password" => Hash::make('12345678'),
                ]);

                $role = Role::getRoleByName('Administration');
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
                $permission = Permission::getPermissionByName('all_functions');
                if ($permission) {
                    $user->permissions()->sync([$permission->id]);
                }
            }
            else{
                $user = User::getUserIdByEmail('samileking9@gmail.com');
                $role = Role::getRoleByName('Administration');
                $permission = Permission::getPermissionByName('all_functions');

                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
                if ($permission) {
                    $user->permissions()->sync([$permission->id]);
                }
            }
            $this->enableForeignKeys("users");
        }
    }
