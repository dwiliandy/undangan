<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::latest()->get();
    return view('admin.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.users.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'role' => ['required', Rule::in(['admin', 'user'])],
      'status' => ['required', Rule::in(['pending', 'active', 'rejected'])],
      'event_quota' => ['required', 'integer', 'min:0'],
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'status' => $request->status,
      'event_quota' => $request->event_quota,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    // Check for quick approve to skip full validation of other fields if needed
    $request->validate([
      'name' => ['sometimes', 'required', 'string', 'max:255'],
      'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'phone_number' => ['sometimes', 'required', 'string', 'max:20'],
      'role' => ['sometimes', 'required', Rule::in(['admin', 'user'])],
      'status' => ['required', Rule::in(['pending', 'active', 'rejected'])],
      'event_quota' => ['required', 'integer', 'min:0'],
      // Password validation removed as admin cannot change password
    ]);

    $previousStatus = $user->status;

    if ($request->has('name')) $user->name = $request->name;
    if ($request->has('email')) $user->email = $request->email;
    if ($request->has('phone_number')) $user->phone_number = $request->phone_number;
    if ($request->has('role')) $user->role = $request->role;
    $user->status = $request->status;
    $user->event_quota = $request->event_quota;

    // Password update logic removed

    $user->save();

    // Send WhatsApp Notification if approved
    if ($previousStatus === 'pending' && $user->status === 'active') {
      \App\Services\WhatsAppService::sendMessage($user->phone_number, "Selamat! Akun Anda telah disetujui. Silakan login.");
    }

    if ($request->has('quick_approve')) {
      return redirect()->back()->with('success', 'User approved successfully.');
    }

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    if ($user->id === auth()->id()) {
      return back()->with('error', 'You cannot delete yourself.');
    }

    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
  }
}
