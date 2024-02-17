<?php

namespace App\Http\Controllers;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json(['users' => $users]);
    }

    public function userById(Request $request, $userId): JsonResponse
    {
        $user = $this->userRepository->findUserById($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    public function register(Request $request)
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Send registration confirmation email using SendGrid
        Mail::to($user->email)->send(new RegistrationConfirmation($user));

        // Registration successful
        return response()->json(['message' => 'Registration successful! Please check your email for confirmation.', 'user' => $user], 201);
    }

    // User Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check if the credentials are valid
        if ($token = JWTAuth::attempt($credentials)) {
            // Authentication successful, return the JWT token
            return response()->json(['token' => $token]);
        }

        // Authentication failed
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }


    
}
