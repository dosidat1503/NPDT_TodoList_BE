<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    { 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = DB::table('users')
            ->select('id', 'name', 'email')  
            ->where('email', $request->email)
            ->first();

        return response()->json([
            'access_token' => $token, 
            'expires_in_AccessToken' => JWTAuth::factory()->getTTL() * 60,
            'expires_in_RefreshToken' => env('JWT_REFRESH_TTL', 60) * 60,
            'refresh_token' => $this->createRefreshToken(),
            'user' => $user
        ]);
    }
 
    protected function createRefreshToken()
    {
        return JWTAuth::claims(['refresh' => true])->fromUser(Auth::user());
    }

    public function refresh(Request $request)
    {
        
        try {
            // Lấy refresh token từ request
            $refreshToken = $request->input('refreshToken');

            if (!$refreshToken) {
                return response()->json(['error' => 'Refresh token is required'], 400);
            }

            // Làm mới access token bằng refresh token
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();

            // Trả về access token mới
            return response()->json([
                'access_token' => $newAccessToken, 
                'expires_in' => JWTAuth::factory()->getTTL() * 60, // TTL từ cấu hình (phút thành giây)
            ]);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token'], 500);
        }
    } 

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
