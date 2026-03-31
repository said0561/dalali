<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Hakikisha hii ipo

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'phone';
    }

    /**
     * Function hii inaitwa otomatiki baada ya mtumiaji kufanikiwa ku-login
     */
    protected function authenticated(Request $request, $user)
    {
        // 1. Super Admin (ID 1)
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }

        // 2. Regional Admin (ID 2)
        if ($user->role_id == 2) {
            return redirect()->route('admin.dashboard'); 
        }

        // 3. Dalali/Broker (ID 3)
        if ($user->role_id == 3) {
            if ($user->is_approved) {
                return redirect()->route('home'); 
            } else {
                return redirect()->route('approval.notice'); 
            }
        }

        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}