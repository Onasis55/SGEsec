<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Autenticacion personalizada
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('cuenta', $request->cuenta)->first();

            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return $user;
            }
        });

        // Escuchar evento Login para redirigir según rol
        Event::listen(Login::class, function ($event) {
            $user = $event->user;
            if ($user->rol->clave === 'admin') {
                session()->put('url.intended', '/administrador/dashboard');
            }
            else if ($user->rol->clave === 'estudiante') {
                session()->put('url.intended', '/estudiante/dashboard');
            }
            else if ($user->rol->clave === 'tutor') {
                session()->put('url.intended', '/tutor/dashboard');
            }
            elseif (in_array($user->rol->clave, ['profesortitular', 'profesorsustituto'])) {
                session()->put('url.intended', '/profesor/dashboard');
            } else {
            session()->put('url.intended', '/dashboard');
            }
        });
    }
}
