<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'token' => $user->createToken($device)->plainTextToken
        ], Response::HTTP_CREATED);
    }
}
