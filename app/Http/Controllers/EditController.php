<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EditController extends Controller
{
    public function __construct()
    {
        // Đảm bảo người dùng đã đăng nhập
        $this->middleware('auth');
    }

    public function edit()
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
        
        return view('edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');

        if ($user->save()) {
            return redirect()->route('edit')->with('success', 'Thông tin của bạn đã được cập nhật!');
        } else {
            return redirect()->route('edit')->with('error', 'Có lỗi xảy ra khi cập nhật thông tin!');
        }

        return redirect()->route('edit')->with('success', 'Thông tin của bạn đã được cập nhật!');
    }
}
