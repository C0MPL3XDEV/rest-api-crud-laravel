<?php /** @noinspection ALL */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) :JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
               'message'=>'The Provided Credentials are Incorrect'
            ], 401);
        }

        $token = $user->createToken($user->name."Auth-Token")->plainTextToken;

        return response()->json([
            'message'=>'Login Successful',
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }

    public function register(Request $request) :JsonResponse
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password, ['rounds' => 12]),
        ]);

        if ($user) {

            $token = $user->createToken($user->name."Auth-Token")->plainTextToken;

            return response()->json([
                'message'=>'Registration Successful',
                'token_type' => 'Bearer',
                'token' => $token
            ], 201);

        } else {
            return response()->json([
                'message' => "Something Went Wrong! :("
            ], 500);
        }
    }

    public function logout(Request $request) :JsonResponse
    {
        $user = User::where('id', $request->user()->id)->first();

        if ($user) {
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logged out Successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => "User Not Found!"
            ], 404);
        }
    }

    public function profile(Request $request) :JsonResponse
    {
        if ($request->user()) {

            return response()->json([
                'message'=>'Profile Fetched Successfully',
                'user' => $request->user()
            ], 200);

        } else {
            return response()->json([
                'message'=>'Not Authenticated'
            ], 401);
        }
    }
}

