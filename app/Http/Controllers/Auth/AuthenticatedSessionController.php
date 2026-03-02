<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        $intended = (string) session()->get('url.intended', '');
        $intendedPath = (string) parse_url($intended, PHP_URL_PATH);

        $courseIdForCheckout = null;
        if (preg_match('#^/courses/(\d+)/checkout$#', $intendedPath, $m)) {
            $courseIdForCheckout = (string) $m[1];
        }

        if ($intendedPath !== '' && (Str::startsWith($intendedPath, ['/admin', '/dashboard']))) {
            return view('auth.login');
        }

        $previous = (string) url()->previous();
        $previousPath = (string) parse_url($previous, PHP_URL_PATH);

        if (is_null($courseIdForCheckout) && preg_match('#^/courses/(\d+)/checkout$#', $previousPath, $m)) {
            $courseIdForCheckout = (string) $m[1];
        }

        $isUnsafePrevious = $previousPath === ''
            || Str::startsWith($previousPath, ['/login', '/register', '/forgot-password', '/admin', '/dashboard'])
            || preg_match('#^/courses/\d+/checkout$#', $previousPath)
            || preg_match('#^/checkout/orders/\d+$#', $previousPath);

        $target = '';

        if (! is_null($courseIdForCheckout)) {
            $target = url('/courses/' . $courseIdForCheckout);
        } elseif (! $isUnsafePrevious) {
            $target = $previous;
        }

        if ($target === '') {
            $target = route('home');
        }

        return redirect()->to($target)->with('auth_modal', 'login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        if ($user && ($user->must_change_password ?? false)) {
            try {
                if (method_exists($user, 'hasRole') && $user->hasRole('mentor')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'ok' => true,
                            'redirect' => route('profile.edit'),
                            'message' => 'must-change-password',
                        ]);
                    }

                    return redirect()->route('profile.edit')->with('status', 'must-change-password');
                }
            } catch (\Throwable $e) {
                // If role check fails for any reason, continue normal flow.
            }
        }

        if ($request->expectsJson()) {
            $redirectTo = '';
            $redirectToRaw = trim((string) $request->input('redirect_to', ''));

            if ($redirectToRaw !== '') {
                if (Str::startsWith($redirectToRaw, ['/']) && ! Str::startsWith($redirectToRaw, ['//'])) {
                    $redirectTo = $redirectToRaw;
                } elseif (filter_var($redirectToRaw, FILTER_VALIDATE_URL)) {
                    $host = (string) parse_url($redirectToRaw, PHP_URL_HOST);
                    if ($host !== '' && strcasecmp($host, (string) $request->getHost()) === 0) {
                        $path = (string) (parse_url($redirectToRaw, PHP_URL_PATH) ?? '/');
                        $query = (string) parse_url($redirectToRaw, PHP_URL_QUERY);
                        $fragment = (string) parse_url($redirectToRaw, PHP_URL_FRAGMENT);
                        $redirectTo = $path
                            . ($query !== '' ? ('?' . $query) : '')
                            . ($fragment !== '' ? ('#' . $fragment) : '');
                    }
                }
            }

            if ($redirectTo === '') {
                $redirectTo = (string) $request->session()->pull('url.intended', route('dashboard', absolute: false));
            }

            return response()->json([
                'ok' => true,
                'redirect' => $redirectTo,
                'message' => __('frontend.login_success'),
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
