<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // Hiển thị tiêu đề, các liên kết và quản lý favicon
    public function index(Request $request)
    {
        // Kiểm tra quyền truy cập
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $page = Page::first(); // Lấy trang đầu tiên từ bảng 'pages'

        if (!$page) {
            // Nếu không có bản ghi nào, tạo mới với các giá trị mặc định
            $page = Page::create([
                'title' => 'Tiêu đề mặc định',
                'facebook_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'about_url' => '',
                'contact_url' => '',
                'terms_url' => '',
                'privacy_url' => '',
                'favicon' => 'assets/grinning_2171967.png', // Giá trị favicon mặc định
            ]);
        }

        // Nếu form được gửi và có dữ liệu, xử lý cập nhật
        if ($request->isMethod('post')) {
            // Xác thực dữ liệu
            $request->validate([
                'title' => 'required|string|max:255',
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'about_url' => 'nullable|url',
                'contact_url' => 'nullable|url',
                'terms_url' => 'nullable|url',
                'privacy_url' => 'nullable|url',
                'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg|max:2048', // Xác thực favicon
            ]);

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'title' => $request->input('title'),
                'facebook_url' => $request->input('facebook_url'),
                'twitter_url' => $request->input('twitter_url'),
                'instagram_url' => $request->input('instagram_url'),
                'about_url' => $request->input('about_url'),
                'contact_url' => $request->input('contact_url'),
                'terms_url' => $request->input('terms_url'),
                'privacy_url' => $request->input('privacy_url'),
            ];

            // Xử lý favicon nếu có tệp được tải lên
            if ($request->hasFile('favicon')) {
                logger('Favicon uploaded: ' . $request->file('favicon')->getClientOriginalName());

                // Xóa favicon cũ nếu có
                if ($page->favicon && file_exists(public_path($page->favicon)) && $page->favicon !== 'assets/grinning_2171967.png') {
                    unlink(public_path($page->favicon));
                    logger('Old favicon deleted: ' . $page->favicon);
                }

                // Lưu favicon với tên gốc trực tiếp vào public/assets/
                $faviconFile = $request->file('favicon');
                $originalName = $faviconFile->getClientOriginalName(); // Lấy tên gốc của file
                $faviconPath = 'assets/' . $originalName; // Đường dẫn: assets/dog_1650609.png
                $fullPath = public_path($faviconPath); // Đường dẫn đầy đủ: public/assets/dog_1650609.png

                // Đảm bảo thư mục public/assets/ tồn tại
                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Lưu file vào public/assets/
                file_put_contents($fullPath, file_get_contents($faviconFile));
                $data['favicon'] = $faviconPath; // Lưu đường dẫn vào cơ sở dữ liệu: assets/dog_1650609.png
                logger('Favicon path saved: ' . $faviconPath);
            } else {
                logger('No favicon uploaded');
            }

            // Cập nhật bản ghi trong bảng pages
            $page->update($data);
            logger('Page updated: ' . json_encode($data));

            return redirect()->route('admin.pages.index')->with('success', 'Tiêu đề, liên kết và favicon đã được cập nhật!');
        }

        return view('admin.pages.index', compact('page'));
    }
}