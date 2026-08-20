<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(['user' => auth()->user()->load('businessProfile')]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();
        $emailChanged = isset($data['email']) && $data['email'] !== $user->email;
        $user->fill($data);
        if ($emailChanged) $user->email_verified_at = null;
        $user->save();
        return response()->json(['user' => $user->fresh()->load('businessProfile')]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }
        $user->password = $request->new_password;
        $user->save();
        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();
        auth()->logout();
        $request->session()->invalidate();
        $user->delete();
        return response()->json(['message' => 'Account deleted.']);
    }
}
