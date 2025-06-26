<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest as StoreRequest;
use App\Http\Requests\User\UpdateUserRequest as UpdateRequest;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\User;
use App\Repositories\Backend\UserRepository;
use Illuminate\Support\Facades\DB;

class UserCrudController extends Controller
{
    protected $user_repository;
    public function __construct() {
        $this->user_repository = new UserRepository();
        $this->middleware('access.routeNeedsPermission:all_functions', [
            'only' => ['index', 'fetchUser', 'fetchAdminUser', 'store', 'update', 'deleteUser']
        ]);
    }

    public function index()
    {
        return view('pages.backend.user.index');
    }

    public function fetchUser()
    {
        $users = $this->user_repository->getAllForDt();
        return response()->json([
            'data' => $users->map(function($user, $index) {
                return [
                    'DT_RowIndex' => $index + 1,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                    'is_super_admin' => $user->is_super_admin,
                    'uid' => $user->uid,
                    'show_url' => route('backend.show.user', $user->uid),
                ];
            })
        ]);
    }

    public function fetchAdminUser()
    {
        $users = $this->user_repository->getAdminUsers()->orderBy('name');
        return response(['data' => $users]);
    }

    public function create()
    {
        $data['roles'] = Role::query()->get();
        $data['adminRoleId'] = Role::getRoleByName('administration')->value('id');
        return view('pages.backend.user.create', $data);
    }

    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $user = $this->user_repository->store($validated);

            return redirect()->route('backend.show.user', $user->uid)->with('success', 'User Registered Successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating User: '.$e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $user)
    {
        $input = $request->all();
        try {
            $response = $this->user_repository->update($user, $input);
            if ($response === false) {
                return back()->with('error', 'Fail to update user');
            }
            return redirect()->back()->with('success', 'User Details Updated Successfully');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', '"Error occurred when updating user: '.$e->getMessage());
        }
    }

    public function deleteUser($user)
    {
        try {
            $response = $this->user_repository->delete($user);
            if ($response === false) {
                return back()->with('error', 'Error deleting user');
            }
            return redirect()->route('backend.user')->with('success', 'User Deleted Successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating User: '.$e->getMessage());
        }
    }

    public function profile($userId)
    {
        $user = User::with('roles', 'permissions')->where('uid', $userId)->first();
        return view('pages.backend.user.profile.profile', ['user' => $user]);
    }

    public function edit($userId)
    {
        $data['user'] = User::with('roles', 'permissions')->where('uid', $userId)->first();
        $data['roles'] = Role::getAllRoles();
        $data['permissions'] = Permission::getAllPermissions();
        return view('pages.backend.user.edit', $data);
    }

    public function activity($userId)
    {
        $user = User::with('roles', 'permissions')->where('uid', $userId)->first();
        $audits = DB::table('audits')
            ->leftJoin('users', 'audits.user_id', '=', 'users.id')
            ->select('audits.*',
                DB::raw("CASE
                    WHEN audits.user_type = 'App\Models\Access\User' THEN users.email
                    ELSE 'Guest User'
                END as user_email")
            )->where('users.id', $user->id)->orderByDesc('audits.created_at')->get();

        return view('pages.backend.user.activity', compact('user', 'audits'));
    }
}
