<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Verify the user's email address (supports guest verification).
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $userId = (string) $request->route('id');
        $hash = (string) $request->route('hash');

        /** @var \App\Models\User|null $user */
        $user = User::query()->find($userId);
        if (! $user) {
            return redirect()->route('verification.notice')->with('status', 'verification-invalid');
        }

        // Match Laravel's default hash: sha1(email)
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.notice')->with('status', 'verification-invalid');
        }

        if (! $user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
