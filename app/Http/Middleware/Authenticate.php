<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectToWithGuards($request, $guards)
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return string
     */
    protected function redirectToWithGuards($request, $guards)
    {
        if (! $request->expectsJson()) {
            $guard = $guards[0];
            if ($guard === 'admin' && $this->auth->guard($guard)) {
                return route('admin.login');
            } elseif ($guard === 'client' && $this->auth->guard($guard)) {
                return route('login');
            }
        }
    }
}
