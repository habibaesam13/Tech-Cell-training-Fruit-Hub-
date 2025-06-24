<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function Register(Request $request)
    {
        $validate = validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:20'
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => 0,

                "message" => "validation Erorr",
                "data" => $validate->errors()->all()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "password" => bcrypt($request->password),
        ]);

        $response = [];
        $response["token"] = $user->createToken('authToken')->plainTextToken;
        $response["name"] = $user->name;
        $response["email"] = $user->email;
        return response()->json([
            "status" => 1,
            "message" => "User has been registerd successfully",
            "data" => $response
        ], 201);
    }

    public function Login(Request $request)
    {
        $validate = validator::make($request->all(), [
            "email" => 'required|email',
            "password" => 'required|string'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "status" => 0,
                "message" => "invalid email or password ",
                "data" => null
            ], 401);
        }
        $user =  User::where("email", $request->email)->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            "status" => 1,
            "message" => "logged in successfully.",
            "data" => $user,
            $token
        ], 200);
    }
    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "logged out successfully."
        ]);
    }
}
