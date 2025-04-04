<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        // Kiểm tra nếu không có file ảnh
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Chưa có ảnh'], 400);
        }

        $file = $request->file('image');

        // Lưu file vào storage
        $path = $file->store('uploads', 'public');

        // Gửi ảnh đến AI để nhận diện
        $breed = $this->detectCatBreed($path);

        return response()->json([ 
            'breed' => $breed,
            'image_url' => asset("storage/$path")
        ]);
    }

    // Hàm giả lập AI nhận diện giống mèo
    private function detectCatBreed($imagePath)
    {
        return "Mèo Ba Tư"; // Thay bằng mô hình AI thực tế
    }
}
