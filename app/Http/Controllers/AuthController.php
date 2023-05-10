<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    /**
     * make authentication for API user
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $expiredToken = new \DateTime();
        $expiredToken->modify('+ 7 days');
        
        $JWT_PAYLOAD = [
            'user' => $request->user,
            'email' => $request->email,
            'password' => $request->password,
            'domain' => env('APP_URL')
        ];

        $credentials = $request->only('email', 'password');

        try {
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            
            $user = Auth::user();
            $token = $user->retriveNotExpiredToken();
            
            if(empty($token)) {
                $jwt = JWT::encode($JWT_PAYLOAD, env('JWT_SECRET','no_secret'), 'HS256');
                $token = $user->createToken('access_token',$jwt, ['*'],\DateTime::createFromFormat('Y-m-d H:i:s',$expiredToken->format('Y-m-d H:i:s')));
            }

        } catch (\Exception $e) {
            Log::critical("could_not_create_token ".$e->getMessage());
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $this->authenticate($request);

        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        return $this->authenticate($request);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
