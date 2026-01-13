<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
  public function showLoginForm()
  {
    return view('user.auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::validate($credentials)) {
      $user = User::where('email', $request->email)->first();

      // Status Check
      if ($user->role === 'user') {
        if ($user->status === 'pending') {
          return back()->withErrors(['email' => 'Your account is pending approval.']);
        } elseif ($user->status === 'rejected') {
          return back()->withErrors(['email' => 'Your account has been rejected.']);
        }
      }

      if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $role = auth()->user()->role;

        if ($role === 'admin') {
          return redirect()->intended(route('admin.dashboard'));
        } elseif ($role === 'user') {
          return redirect()->intended(route('user.dashboard'));
        }

        return redirect()->intended('/');
      }
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  public function showRegisterForm()
  {
    return view('user.auth.register');
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'phone_number' => ['required', 'string', 'max:20'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'password' => Hash::make($request->password),
      'role' => 'user',
    ]);

    // Auth::login($user);

    return redirect()->route('login')->with('success', 'Registration successful! Your account is pending approval.');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
