<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;

use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function list()
    {
        return response($this->userService->list());
    }

    public function show()
    {
        return response($this->userService->show());
    }

    public function update(UpdateUserRequest $request)
    {
        return response($this->userService->update($request));
    }
}
