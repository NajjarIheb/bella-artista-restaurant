<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        if (Auth::check()) {
            return redirect()->route('customer.orders');
        }

        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $response = Password::broker()->sendResetLink($request->only('email'));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => __('auth.resetMailError')])->withInput($request->only('email'));
        }

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', __('auth.resetSent'));
        }

        return back()->with('status', __('auth.resetSent'))->withInput($request->only('email'));
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (Auth::check()) {
            return redirect()->route('customer.orders');
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                Auth::login($user);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return redirect()->route('customer.orders')->with('success', __('auth.resetSuccess'));
        }

        $messages = [
            Password::INVALID_USER => __('auth.resetFailed'),
            Password::INVALID_TOKEN => __('auth.resetInvalidToken'),
            Password::INVALID_PASSWORD => __('auth.resetInvalidPassword'),
        ];

        $message = $messages[$response] ?? __('auth.resetFailed');

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $message]);
    }
}
