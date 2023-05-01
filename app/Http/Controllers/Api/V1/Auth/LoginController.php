<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' =>  ['The provided credentials are incorrect.'],
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);
        
        $expiredAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));

        return response()->json([
            'token' => $user->createToken($device, expiresAt: $expiredAt)->plainTextToken
        ], Response::HTTP_CREATED);
    }
}
