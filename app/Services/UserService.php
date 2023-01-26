<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(private User $user) {}

    public function list()
    {
        return $this->user->paginate();
    }

    public function store($request)
    {
        return $this->user->create($request->validated());
    }

    public function update($request, $id)
    {
        $user = $this->user->where('id', $id)->firstOrFail();

        $user->update($request->validated());

        return $user;
    }
}
