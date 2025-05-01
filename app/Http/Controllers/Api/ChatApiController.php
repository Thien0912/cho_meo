<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCoin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatApiController extends Controller
{
    public function handleUpload(Request $request)
    {
        // Kiểm tra xem người dùng có đăng nhập không
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'detail' => 'Bạn cần đăng nhập.'
            ], 401);
        }

        $userId = Auth::guard('sanctum')->id();

        // Kiểm tra số dư xu
        $userCoinBalance = UserCoin::where('user_id', $userId)->sum('coins_change');
        if ($userCoinBalance < 1) {
            return response()->json(['detail' => 'Số dư xu không đủ.'], 400);
        }

        try {
            DB::beginTransaction();

            UserCoin::create([
                'user_id' => $userId,
                'coins_change' => -1,
                'reason' => 'chat',
                'created_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Xu đã được trừ thành công. Tiến hành xử lý ảnh.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['detail' => 'Lỗi khi trừ xu: ' . $e->getMessage()], 500);
        }
    }
}