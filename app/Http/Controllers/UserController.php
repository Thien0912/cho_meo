<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Thêm import DB

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1', // Xác thực giá trị 0 hoặc 1 từ form
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status == '1' ? 'active' : 'blocked', // Ánh xạ 1 -> active, 0 -> blocked
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Log::info('Update request received', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1', // Xác thực giá trị 0 hoặc 1 từ form
        ]);

        // Ánh xạ status từ 0/1 sang blocked/active
        $status = $request->status == '1' ? 'active' : 'blocked';

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $status,
        ]);

        // Xóa token nếu tài khoản bị khóa
        if ($status === 'blocked') {
            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}