<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View|RedirectResponse
    {
        $intended = (string) session()->get('url.intended', '');
        $intendedPath = (string) parse_url($intended, PHP_URL_PATH);

        if ($intendedPath !== '' && (Str::startsWith($intendedPath, ['/admin', '/dashboard']))) {
            return view('auth.register');
        }

        $previous = (string) url()->previous();
        $previousPath = (string) parse_url($previous, PHP_URL_PATH);
        $isUnsafePrevious = $previousPath === ''
            || Str::startsWith($previousPath, ['/login', '/register', '/forgot-password', '/admin', '/dashboard']);

        $target = $isUnsafePrevious ? '' : $previous;
        if ($target === '') {
            $target = route('home');
        }

        return redirect()->to($target)->with('auth_modal', 'register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Default role assignment for new registrations
        $studentRole = Role::firstOrCreate(
            ['name' => 'student', 'guard_name' => 'web'],
            ['name' => 'student', 'guard_name' => 'web'],
        );
        $user->assignRole($studentRole);

        event(new Registered($user));

        Auth::login($user);

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
                'message' => __('frontend.register_success'),
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
