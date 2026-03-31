<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Hakikisha user ameingia
        if (auth()->check()) {
            
            // 2. Kama ni broker na hajawa approved
            // Na kama hajaribu kufungua ukurasa wa notice wenyewe
            if (auth()->user()->role->name === 'broker' && !auth()->user()->is_approved) {
                
                if (!$request->is('approval-notice*') && !$request->is('logout')) {
                    return redirect()->route('approval.notice');
                }
            }
        }

        return $next($request);
    }
}