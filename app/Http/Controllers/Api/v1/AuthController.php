<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!Auth::attempt($data)) {
            return response()->json('Login error!', 401);
        }

        /** @var User $user */
        $user = $request->user();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function user(Request $request){
        return $request->user()->only(['name', 'email']);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        /** @var User $user */
        $user = User::create($data);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'message' => 'You are logged out!'
        ], 200);
    }
}
