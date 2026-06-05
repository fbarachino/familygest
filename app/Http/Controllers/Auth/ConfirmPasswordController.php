<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConfirmPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showConfirmForm(): View
    {
        return view('adminlte::auth.passwords.confirm');
    }

    public function confirm(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'string']]);

        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors(['password' => [__('auth.password')]]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended('/');
    }
}
