<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\UserCoin;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            // Lấy thông tin user hiện tại
            $user = Auth::user();
            
            // Lấy tổng số coins từ bảng user_coins
            $totalCoins = UserCoin::where('user_id', $user->id)->sum('coins_change');
        } else {
            // Nếu người dùng chưa đăng nhập, gán tổng coins là 0
            $totalCoins = 0;
        }
        
        // Chia sẻ tổng số coins này với tất cả các view
        view()->share('totalCoins', $totalCoins);
    }

    // Phương thức AJAX để lấy số xu của người dùng
    public function getUserCoins()
    {
        if (Auth::check()) {
            // Lấy tổng số xu của người dùng
            $user = Auth::user();
            $totalCoins = UserCoin::where('user_id', $user->id)->sum('coins_change');
            return response()->json([
                'totalCoins' => $totalCoins
            ]);
        }

        return response()->json([
            'error' => 'User not authenticated.'
        ]);
    }
}
