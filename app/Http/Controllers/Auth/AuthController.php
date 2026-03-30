<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        auth()->login($user);

        return redirect()->route('home');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return redirect()->back()->with(['errors', 'Неверные данные!']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
