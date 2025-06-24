<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function Register(Request $request)
    {
        $validate = validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:20'
        ]);
        if ($validate->fails()) {
            return $this->errorResponse($validate->errors()->all(), 422);
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
        return $this->successResponse($response, "User has been registerd successfully", 201);
    }

    public function Login(Request $request)
    {
        $validate = validator::make($request->all(), [
            "email" => 'required|email',
            "password" => 'required|string'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return  $this->errorResponse("invalid email or password ", 401);
        }
        $user =  User::where("email", $request->email)->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;
        return $this->successResponse(["user" => $user, "token" => $token], "logged in successfully.");
    }
    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([], "logged out successfully.");
    }
}
