<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LLMController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_base_url', 'http://api.chm.adhigtechn.com');
    }

    public function index()
    {
        try {
            $response = Http::get("{$this->apiBaseUrl}/config/config");
            if ($response->successful()) {
                $config = $response->json();
                // Loại bỏ dấu ngoặc kép từ các giá trị trong config, trừ SELECTED_LLM
                $cleanConfig = array_map(function ($value, $key) {
                    return $key === 'SELECTED_LLM' ? $value : preg_replace('/^"(.*)"$/', '$1', $value);
                }, $config, array_keys($config));
                return view('admin.llm.index', ['config' => $cleanConfig]);
            } else {
                Log::error('Failed to fetch config: ' . $response->body());
                return view('admin.llm.index', ['config' => [], 'error' => 'Không thể lấy dữ liệu cấu hình']);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching config: ' . $e->getMessage());
            return view('admin.llm.index', ['config' => [], 'error' => 'Lỗi khi kết nối tới API']);
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'KEY_API_GPT' => 'nullable|string',
            'GEMINI_API_KEY' => 'nullable|string',
            'OPENAI_LLM' => 'nullable|string',
            'GOOGLE_LLM' => 'nullable|string',
            'SELECTED_LLM' => 'nullable|in:openai,gemini',
        ]);

        // Lọc bỏ các giá trị null để gửi dữ liệu gọn gàng
        $dataToSend = array_filter($validated, fn($value) => !is_null($value));

        // Kiểm tra xem có dữ liệu để gửi không
        if (empty($dataToSend)) {
            return response()->json([
                'message' => 'Không có dữ liệu hợp lệ để cập nhật'
            ], 400);
        }

        try {
            Log::info('Gửi dữ liệu tới FastAPI: ' . json_encode($dataToSend));
            $response = Http::post("{$this->apiBaseUrl}/config/update", $dataToSend);
            if ($response->successful()) {
                Log::info('Phản hồi từ FastAPI: ' . $response->body());
                $updatedConfig = $response->json()['updated_config'];
                // Loại bỏ dấu ngoặc kép từ updated_config, trừ SELECTED_LLM
                $cleanConfig = array_map(function ($value, $key) {
                    return $key === 'SELECTED_LLM' ? $value : preg_replace('/^"(.*)"$/', '$1', $value);
                }, $updatedConfig, array_keys($updatedConfig));
                return response()->json([
                    'message' => $response->json()['message'] ?? 'Cập nhật cấu hình thành công',
                    'updated_config' => $cleanConfig
                ]);
            } else {
                Log::error('Failed to update config: ' . $response->body());
                return response()->json([
                    'message' => 'Không thể cập nhật cấu hình: ' . $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error updating config: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi kết nối tới API: ' . $e->getMessage()
            ], 500);
        }
    }
}