<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($input);

        $response = [
            'massage' => 'User register successfully',
            'data' => $user
        ];

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {

        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where('email', $input['email'])->first();

        $isLoginSuccess = ($input['email'] === $user->email && Hash::check($input['password'], $user->password));

        if (!$isLoginSuccess) {
            $error = [
                'massage' => 'Login failed, emai or password not recognized',
            ];

            return response()->json($error, 401);
        } else {
            $token = $user->createToken('authToken');

            $response = [
                'message' => "Login successfully !",
                'data' => $user,
                'token' => $token->plainTextToken,
            ];

            return response()->json($response, 200);
        }
    }
}
