<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CheckProjectMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $projet = $request->route('projet') ?? $request->route('tache')?->projet;
        if (is_null($projet) || $projet->users()->where('user_id', auth()->user()->id)->doesntExist()) {
            return redirect()->route('projets.index');
        }
        return $next($request);
    }
}
