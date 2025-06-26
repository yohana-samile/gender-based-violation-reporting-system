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
            $email = "ameena@gbv.com";
            $name = "Ameena Amina";
            $role = "administration";
            $password = 12345678;

            if($count == 0) {
                $user = $userRepo->query()->updateOrCreate(['email' => $email],[
                    "name" => $name,
                    "is_active" => true,
                    "is_super_admin" => true,
                    "email_verified_at" => now(),
                    "email" => $email,
                    "password" => Hash::make($password),
                ]);

                $role = Role::getRoleByName($role);
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
                $permission = Permission::getPermissionByName('all_functions');
                if ($permission) {
                    $user->permissions()->sync([$permission->id]);
                }
            }
            else{
                $user = User::getUserIdByEmail($email);
                $role = Role::getRoleByName($role);
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
