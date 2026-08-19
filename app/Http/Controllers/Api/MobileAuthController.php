<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class MobileAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The supplied credentials are incorrect.'],
            ]);
        }

        if (! $user->is_approved) {
            return response()->json([
                'message' => 'Your account is pending administrator approval.',
            ], 403);
        }

        $token = $user->createToken($credentials['device_name'] ?? 'COTS Tracker')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userPayload($user),
        ]);
    }

    public function googleConfig(): JsonResponse
    {
        return response()->json([
            'client_id' => config('services.google.client_id'),
        ]);
    }

    public function googleLogin(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_token' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);
        $google = Http::timeout(10)->get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $data['id_token'],
        ]);
        abort_unless($google->successful(), 401, 'Google authentication failed.');
        $profile = $google->json();
        abort_unless(
            ($profile['aud'] ?? null) === config('services.google.client_id') &&
            in_array($profile['email_verified'] ?? false, [true, 'true', 1, '1'], true) &&
            ! empty($profile['email']),
            401,
            'The Google identity token is not valid for this application.'
        );

        $user = User::where('email', $profile['email'])->first();
        if (! $user) {
            $user = User::create([
                'name' => $profile['name'] ?? $profile['email'],
                'email' => $profile['email'],
                'google_id' => $profile['sub'],
                'password' => Hash::make(uniqid('google_', true)),
                'role_id' => 2,
                'is_approved' => Setting::isAutoApproveEnabled(),
            ]);
        } else {
            $user->update(['google_id' => $profile['sub']]);
        }
        if (! $user->is_approved) {
            return response()->json([
                'message' => 'Your account is pending administrator approval.',
            ], 403);
        }

        return response()->json([
            'token' => $user->createToken($data['device_name'] ?? 'COTS Tracker Google')->plainTextToken,
            'user' => $this->userPayload($user),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $this->userPayload($request->user())]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Signed out.']);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $this->userPayload($user->fresh()),
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = $request->user();
        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }
        $user->update(['password' => $data['password']]);

        return response()->json(['message' => 'Password updated successfully.']);
    }

    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
        ];
    }
}
