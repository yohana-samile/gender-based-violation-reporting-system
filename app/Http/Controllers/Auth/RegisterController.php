<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Backend\UserRepository;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->middleware('guest');
    }

    public function signup(UserRequest $request){
        return $this->create($request);
    }

    protected function create(UserRequest $request) {
        $input = $request->validated();
        try {
            $user = $this->userRepository->store($input);
            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login success',
                    'url_destination' => '/login',
                ], 201);
            }
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to register user. Please try again.');
        }
        return view('auth.verify');
    }
}

