<?php

namespace App\Repositories\Backend;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends  BaseRepository {
    const MODEL = User::class;
    public function store(array $input) {
        return DB::transaction(function() use($input) {
            $user = $this->createNewUser($input);
            if ($user->wasRecentlyCreated) {
                $this->assignRolesAndPermissions($user);
            }
            return true;
        });
    }

    protected function createNewUser(array $input)
    {
        return $this->query()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            "is_active" => true,
            "is_super_admin" => false,
            "email_verified_at" => now(),
        ]);
    }

    protected function assignRolesAndPermissions($user)
    {
        $role = Role::getRoleByName('reporter');
        if ($role) {
            $user->roles()->sync([$role->id]);
        }
        $permission = Permission::getPermissionByName('reporter');
        if ($permission) {
            $user->permissions()->sync([$permission->id]);
        }
    }

    public function update($userId, array $input){
        if (is_numeric($userId)) {
            $user = User::getUserIdById($userId);
        } else {
            $user = User::getUserIdByUid($userId);
        }
        if(!$user) {
            return false;
        }
        $user->name = $input['name'];
        $user->is_active = ($input['is_active'] ?? false) === 'on' || ($input['is_active'] ?? false) == 1 ? 1 : 0;

        if (!empty($input['email']) && $input['email'] !== $user->email) {
            $user->email = $input['email'];
            $user->email_verified_at = null;
        }

        if (!empty($input['password'])) {
            $user->password = $input['password'];
        }
        if (!empty($input['roles'])) {
            $roleIds = Role::query()->whereIn('name', (array) $input['roles'])->pluck('id')->toArray();
            $user->roles()->sync($roleIds);
        }

        if (!empty($input['permissions'])) {
            $permissionIds = Permission::query()->whereIn('name', (array) $input['permissions'])->pluck('id')->toArray();
            $user->permissions()->sync($permissionIds);
        }

        $user->save();
        return true;
    }

    public function delete($userId) {
        if (is_numeric($userId)) {
            $user = User::getUserIdById($userId);
        } else {
            $user = User::getUserIdByUid($userId);
        }
        if(!$user) {
            return false;
        }
        $this->renamingSoftDelete($user, 'email');
        $user->delete();
        return true;
    }

    public function getAllForDt() {
        return $this->query()->where('is_super_admin', false)->orderBy('created_at', 'desc')->get();
    }

    public function fetchUserByUid($userUid) {
        return $this->query()->where('uid', $userUid)->first();
    }

    public function getAdminUsers() {
        return $this->query()->where('admin_id', user_id())->orderBy('created_at', 'desc')->get();
    }
}
