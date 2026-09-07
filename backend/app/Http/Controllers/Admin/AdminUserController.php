<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount(['clients', 'invoices'])
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(20);
        return response()->json($users);
    }

    public function show(User $user)
    {
        $user->loadCount(['clients', 'invoices']);
        return response()->json($user);
    }

    public function suspend(User $user)
    {
        $user->update(['suspended_at' => now()]);
        return response()->json(['message' => 'User suspended.']);
    }

    public function activate(User $user)
    {
        $user->update(['suspended_at' => null]);
        return response()->json(['message' => 'User activated.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted.']);
    }
}