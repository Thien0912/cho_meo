<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function getVisitors()
    {
        // Lấy dữ liệu truy cập trong 7 ngày gần nhất
        $visitors = Visitor::where('date', '>=', Carbon::now()->subDays(7))
                           ->orderBy('date', 'asc')
                           ->get();
        return response()->json($visitors);
    }
}
