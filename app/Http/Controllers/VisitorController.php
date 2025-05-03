<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function getTransactions()
    {
        // Lấy dữ liệu thu nhập trong 7 ngày gần nhất với status = 'approved' dựa trên updated_at
        $transactions = Transaction::select(
                                DB::raw('DATE(updated_at) as date'), // Dựa trên updated_at để lấy ngày
                                DB::raw('SUM(amount) as total_income')  // Tổng thu nhập
                            )
                            ->where('status', 'approved')  // Chỉ lấy giao dịch đã phê duyệt
                            ->where('updated_at', '>=', Carbon::now()->subDays(7))  // Lấy dữ liệu trong 7 ngày gần nhất
                            ->groupBy(DB::raw('DATE(updated_at)'))  // Nhóm theo ngày cập nhật
                            ->orderBy('date', 'asc')  // Sắp xếp theo ngày
                            ->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json($transactions);
    }
}
