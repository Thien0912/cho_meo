<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CoinController extends Controller
{
    // Hiển thị lịch sử coins
    public function showCoinHistory()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $coinHistory = DB::table('user_coins')
            ->join('users', 'user_coins.user_id', '=', 'users.id')
            ->select('user_coins.*', 'users.name', 'users.email')
            ->orderBy('user_coins.created_at', 'desc')
            ->get();

        return view('admin.users.coin_history', compact('coinHistory'));
    }

    // Hiển thị form cập nhật coins
    public function addCoinsForm()
    {
        $users = User::all();
        return view('admin.users.add_coins', compact('users'));
    }

    // Xử lý cộng/trừ coins
    public function processAddCoins(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'coins_change' => 'required|integer',
            'reason' => 'required|string',
        ]);

        DB::table('user_coins')->insert([
            'user_id' => $request->user_id,
            'coins_change' => $request->coins_change,
            'reason' => $request->reason,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.coin_history')->with('success', 'Coins đã được cập nhật!');
    }
}
