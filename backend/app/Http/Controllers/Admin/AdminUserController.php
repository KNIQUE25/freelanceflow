<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->userService->getUsers(
                search: $request->input('search'),
                perPage: 20
            )
        );
    }

    public function show(User $user)
    {
        return response()->json($this->userService->getUser($user));
    }

    public function getAllUsers()
    {
        return response()->json($this->userService->getAllUsers());
    }

    public function suspend(User $user)
    {
        $user = $this->userService->suspendUser($user);

        return response()->json([
            'message' => 'User suspended.',
            'user' => $user,
        ]);
    }

    public function activate(User $user)
    {
        $user = $this->userService->activateUser($user);

        return response()->json([
            'message' => 'User activated.',
            'user' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);

        return response()->json([
            'message' => 'User deleted.',
        ]);
    }
}