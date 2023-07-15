<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('auth.login');
    }

    public function enter(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Авторизация успешна
            return redirect()->route('rosters.index');
        } else {
            // Неверные учетные данные
            return back()->withErrors([
                'email' => 'Неверный email или пароль.',
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
