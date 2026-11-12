<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request){
        $user = User::create($request->all());
        return response()->json(['token'=>$user->createToken('api')->plainTextToken], 201);
    }
    public function login(AuthUserRequest $request){
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['token' => $user->createToken('api')->plainTextToken], 200);
        } else {
            return response()->json(['errors' => ["password" => ["Неверный логин или пароль"]]]);
        }
    }
}
