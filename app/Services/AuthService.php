<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthService
{
    public function login($request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            $access = $user->createToken('Personal Access Token');

            return [
                'token' => $access->plainTextToken,
            ];
        }

        abort(403, 'Invalid Credentials');
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
