<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->query('question', ''); // Lấy câu hỏi từ query string

        // Kiểm tra nếu câu hỏi trống
        if (empty($question)) {
            return response()->json(['error' => 'Câu hỏi không được để trống'], 400);
        }

        try {
            $response = Http::timeout(120)->get('http://localhost:8080/chatbot/ask', [
                'question' => $question,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Lấy số token đã sử dụng từ response của FastAPI
                $tokensUsed = $data['tokens_used'] ?? 0;

                // Lưu số token vào cache (hoặc database nếu cần)
                $totalTokensUsed = Cache::get('total_tokens_used', 0) + $tokensUsed;
                Cache::put('total_tokens_used', $totalTokensUsed, now()->addMinutes(60));

                // Trả về dữ liệu từ FastAPI và số token đã sử dụng
                return response()->json([
                    'response' => $data['response'],
                    'tokens_used' => $tokensUsed,
                    'total_tokens_used' => $totalTokensUsed,  // Trả về tổng số token đã sử dụng
                ]);
            } else {
                return response()->json([
                    'error' => 'Lỗi khi gọi API FastAPI',
                    'status_code' => $response->status(),
                    'message' => $response->body(),
                ], 500);
            }
        } catch (\Exception $e) {
            // Xử lý các lỗi ngoại lệ nếu có
            return response()->json(['error' => 'Lỗi kết nối đến FastAPI: ' . $e->getMessage()], 500);
        }
    }
}
