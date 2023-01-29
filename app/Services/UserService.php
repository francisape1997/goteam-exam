<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(private User $user) {}

    public function list()
    {
        return $this->user->whereNot('id', auth()->user()->id)->with('selections')->paginate();
    }

    public function show()
    {
        return User::where('id', auth()->user()->id)->with('selections')->first();
    }

    public function store($request)
    {
        return $this->user->create($request->validated());
    }

    public function update($request)
    {
        $user = $this->user->where('id', $request->user()->id)->firstOrFail();

        $user->update($request->validated());

        return $user;
    }
}
