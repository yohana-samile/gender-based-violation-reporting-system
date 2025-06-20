<?php
namespace App\Http\Controllers\Gbv;
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
        return view('pages.user.index');
    }

    public function fetchUser()
    {
        $users = $this->user_repository->getAllForDt();
        return response(['data' => $users]);
    }

    public function fetchAdminUser()
    {
        $users = $this->user_repository->getAdminUsers()->orderBy('name');
        return response(['data' => $users]);
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = $this->user_repository->store($validated);
            return redirect()->route('gbv.user.show', $user->id)->with('success', 'User Registered Successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating User: '.$e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $user)
    {
        $input = $request->all();
        $status = 200;
        $message = "User Details Updated Successfully";
        DB::beginTransaction();

        try {
            $response = $this->user_repository->update($user, $input);
            if ($response === false) {
                return response()->json([
                    'status' => 403,
                    'message' => "Fail to update user",
                ], 403);
            }

            DB::commit();
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 500;
            $message = "Server Error, Try Again";
            \Log::error("Error occurred when updating user: ", ['exception' => $th]);

            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 500);
        }
    }

    public function deleteUser($user)
    {
        $status = 200;
        $message = "User Deleted Successfully";
        $destination = route('gbv.user');
        DB::beginTransaction();

        try {
            $response = $this->user_repository->delete($user);
            if ($response === false) {
                return response()->json([
                    'status' => 403,
                    'message' => "Fail to delete user",
                ], 403);
            }

            DB::commit();
            return response()->json([
                'status' => $status,
                'message' => $message,
                'url_destination' => $destination
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 500;
            $message = "Server Error, Try Again";
            \Log::error("Error occurred when deleting user: ", ['exception' => $th]);

            return response()->json([
                'status' => $status,
                'message' => $message,
            ], 500);
        }
    }

    public function profile($userId)
    {
        $user = User::with('roles', 'permissions')->findOrFail($userId);
        return view('pages.user.profile', ['user' => $user]);
    }

    public function edit($userId)
    {
        $data['user'] = User::with('roles', 'permissions')->findOrFail($userId);
        $data['roles'] = Role::getAllRoles();
        $data['permissions'] = Permission::getAllPermissions();
        return view('pages.user.edit', $data);
    }

    public function activity($userId)
    {
        $user = User::with('roles', 'permissions')->findOrFail($userId);
        $audits = DB::table('audits')
            ->leftJoin('users', 'audits.user_id', '=', 'users.id')
            ->select('audits.*',
                DB::raw("CASE
                    WHEN audits.user_type = 'App\Models\User' THEN users.email
                    ELSE 'Guest User'
                END as user_email")
            )->where('users.id', $userId)->orderByDesc('audits.created_at')->get();

        return view('pages.user.activity', compact('user', 'audits'));
    }
}
