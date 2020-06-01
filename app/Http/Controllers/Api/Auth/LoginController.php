<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 10;
    protected $decayMinutes = 5;

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'refresh']]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            $this->incrementLoginAttempts($request);

            return response()->json(
                ['error' => 'Unauthorized'], 
                Response::HTTP_UNAUTHORIZED
            );
        }

        $this->clearLoginAttempts($request);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'favNotes' => $user->favNotes()->pluck('note_id')
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $user = auth()->user();
        return response()->json([
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        
        return response()->json([
            "error" => [Lang::get('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
            "remain_seconds" => $seconds,
        ], Response::HTTP_TOO_MANY_REQUESTS);
    }
}
