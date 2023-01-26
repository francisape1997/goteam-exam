<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            ...$user->toArray(),
            'token' => ($user->createToken('Personal Access Token'))->plainTextToken,
        ]);
    }
}
