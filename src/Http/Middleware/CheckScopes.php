<?php

namespace Laravel\Passport\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Exceptions\InvalidScopesException;

class CheckScopes
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $scopes
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next, ...$scopes)
    {
        if (! $request->user() || ! $request->user()->token()) {
            throw new AuthenticationException;
        }

        foreach ($scopes as $scope) {
            if (! $request->user()->tokenCan($scope)) {
                throw new InvalidScopesException($scope);
            }
        }

        return $next($request);
    }
}
