<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Backend\UserRepository;

class RegisterController extends Controller
{
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view("auth/register");
    }

    public function signup(UserRequest $request)
    {
        return $this->create($request);
    }

    protected function create(UserRequest $request)
    {
        $input = $request->validated();

        try {
            $user = $this->userRepository->store($input);

            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Registration successful',
                    'url_destination' => '/login',
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to register user. Please try again.'
            ], 500);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Registration failed'
        ], 400);
    }
}

