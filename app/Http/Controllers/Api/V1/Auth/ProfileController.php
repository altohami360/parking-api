<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request) {

        return response()->json($request->user()->only('name', 'email'));
    }

    public function update(UpdateUserRequest $request)
    {

        $user = auth()->user()->update($request->validated());

        return response()->json([
            $request->validated(),
            Response::HTTP_ACCEPTED
        ]);
    }
}
