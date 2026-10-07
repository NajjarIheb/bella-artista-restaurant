<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return response()->json(['redirect' => route('customer.orders')]);
        }

        $validated = $request->validate([
            'credential' => 'required|string',
        ]);

        try {
            $payload = $this->verifyGoogleIdToken($validated['credential']);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => __('auth.googleError')], 401);
        }

        $user = User::where('email', $payload['email'])
            ->orWhere('google_id', $payload['sub'])
            ->first();

        if ($user && $user->isAdmin()) {
            return response()->json(['message' => __('auth.googleError')], 403);
        }

        if (!$user) {
            $user = User::create([
                'name' => $payload['name'] ?? $payload['email'],
                'email' => $payload['email'],
                'google_id' => $payload['sub'],
                'password' => Hash::make(Str::random(40)),
                'role' => 'customer',
            ]);
        } elseif (!$user->google_id) {
            $user->forceFill(['google_id' => $payload['sub']])->save();
        }

        Auth::login($user);
        session()->regenerate();

        return response()->json(['redirect' => route('customer.orders')]);
    }

    private function verifyGoogleIdToken(string $credential)
    {
        $clientId = config('services.google.client_id');

        if (!$clientId) {
            throw new \RuntimeException('Google client is not configured.');
        }

        try {
            $keys = Cache::remember('google_oauth_certs', 3600, function () {
                $response = Http::get('https://www.googleapis.com/oauth2/v3/certs');

                return $response->json();
            });

            $payload = JWT::decode($credential, JWK::parseKeySet($keys));
        } catch (\Throwable $e) {
            throw new \RuntimeException('Invalid Google ID token.', 0, $e);
        }

        $validIssuers = ['https://accounts.google.com', 'accounts.google.com'];

        if (!in_array($payload->iss, $validIssuers, true)) {
            throw new \RuntimeException('Invalid token issuer.');
        }

        if ($payload->aud !== $clientId) {
            throw new \RuntimeException('Invalid token audience.');
        }

        if (empty($payload->email)) {
            throw new \RuntimeException('Missing email claim.');
        }

        return (array) $payload;
    }
}
