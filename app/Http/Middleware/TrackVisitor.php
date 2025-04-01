<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $today = Carbon::today()->toDateString();

        // Kiểm tra nếu user đăng nhập thì dùng ID, nếu không thì dùng IP
        $user = $request->user();
        $identifier = $user ? 'user_' . $user->id : 'ip_' . $request->ip();

        $cacheKey = 'visited_' . $today . '_' . $identifier;

        if (!Cache::has($cacheKey)) {
            // Kiểm tra xem có bản ghi nào cho user hoặc IP trong hôm nay chưa
            $visitor = Visitor::where('date', $today)->where('identifier', $identifier)->first();

            if ($visitor) {
                // Nếu đã có, chỉ tăng số lượt
                $visitor->increment('count');
            } else {
                // Nếu chưa có, tạo mới
                Visitor::create([
                    'date'       => $today,
                    'identifier' => $identifier,
                    'count'      => 1
                ]);
            }

            // Lưu vào cache để tránh đếm lại trong cùng ngày
            Cache::put($cacheKey, true, now()->endOfDay());
        }

        return $next($request);
    }
}
