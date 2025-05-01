<?php

namespace App\Http\Controllers;

use App\Models\Page; // Đảm bảo bạn đã import model Page
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy bản ghi đầu tiên từ bảng 'pages'
        $page = Page::first();

        // Nếu không có bản ghi nào, tạo một bản ghi mặc định với các liên kết mạng xã hội trống
        if (!$page) {
            $page = Page::create([
                'title' => 'Tiêu đề mặc định',
                'facebook_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'about_url' => '',
                'contact_url' => '',
                'terms_url' => '',
                'privacy_url' => ''
            ]);
        }

        // Truyền biến $page vào view
        return view('home', compact('page'));
    }
}
