<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;
use App\Traits\Encryptable;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use Encryptable;

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

        try {
            if (!Auth::attempt([
                'email' => self::encrypt(['email' => $request->email]),
                'password' => $request->password
            ])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $user = Auth::user();
            $token = $user->retriveNotExpiredToken();

            if (empty($token)) {
                $jwt = self::encrypt($JWT_PAYLOAD);
                $token = $user->createToken('access_token', $jwt, ['*'], \DateTime::createFromFormat('Y-m-d H:i:s', $expiredToken->format('Y-m-d H:i:s')));
            }

            $user->useToken();

        } catch (\Exception $e) {
            Log::critical("could_not_create_token " . $e->getMessage());
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {

        if (Auth::attempt([
            'email' => self::encrypt(['email' => $request->email]),
            'password' => $request->password
        ])) {
            return $this->authenticate($request);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
    
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
    
            return $this->authenticate($request);

        } catch(ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 500);

        }

        
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
