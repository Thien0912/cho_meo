<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCoin;
use Illuminate\Support\Facades\DB;  // Để sử dụng giao dịch

class ChatController extends Controller
{
    // Phương thức để xử lý upload ảnh và nhận diện giống chó/mèo
    public function handleUpload(Request $request)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $userId = Auth::id();  // Lấy ID người dùng đang đăng nhập

            // Sử dụng giao dịch để trừ xu người dùng
            DB::beginTransaction();  // Bắt đầu giao dịch

            try {
                // Trừ 10 coins của người dùng ngay lập tức
                $coinChange = UserCoin::create([
                    'user_id' => $userId,
                    'coins_change' => -1,
                    'reason' => 'chat',
                    'created_at' => now()
                ]);

                // Kiểm tra nếu việc tạo UserCoin thành công
                if (!$coinChange) {
                    // Nếu không tạo được bản ghi trong bảng UserCoin, rollback giao dịch
                    DB::rollBack();
                    return response()->json([
                        'detail' => 'Không thể trừ xu cho người dùng.'
                    ]);
                }

                // Commit giao dịch sau khi đã trừ xu thành công
                DB::commit();

                // Sau khi trừ xu, có thể tiếp tục xử lý ảnh (gửi ảnh đi phân tích giống chó/mèo)
                return response()->json([
                    'message' => 'Xu đã được trừ thành công. Tiến hành xử lý ảnh.'
                ]);
            } catch (\Exception $e) {
                // Nếu có lỗi trong quá trình trừ xu, rollback giao dịch
                DB::rollBack();
                return response()->json([
                    'detail' => 'Lỗi khi trừ xu: ' . $e->getMessage()
                ]);
            }
        } else {
            // Nếu người dùng chưa đăng nhập
            return response()->json([
                'detail' => 'Bạn cần đăng nhập để thực hiện thao tác này.'
            ]);
        }
    }
}
