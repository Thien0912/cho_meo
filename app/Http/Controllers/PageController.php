<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $page = Page::first();

        if (!$page) {
            $page = Page::create([
                'title' => 'Tiêu đề mặc định',
                'description' => 'Chào mừng đến với trang web của chúng tôi!',
                'header_title' => 'KHÁM PHÁ THẾ GIỚI ĐẦY MÀU SẮC CỦA CÁC GIỐNG CHÓ MÈO ĐỘC ĐÁO!',
                'facebook_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'about_url' => '',
                'contact_url' => '',
                'terms_url' => '',
                'privacy_url' => '',
                'favicon' => 'assets/grinning_2171967.png',
            ]);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'header_title' => 'nullable|string|max:255',
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'about_url' => 'nullable|url',
                'contact_url' => 'nullable|url',
                'terms_url' => 'nullable|url',
                'privacy_url' => 'nullable|url',
                'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg|max:2048',
            ]);

            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'header_title' => $request->input('header_title'),
                'facebook_url' => $request->input('facebook_url'),
                'twitter_url' => $request->input('twitter_url'),
                'instagram_url' => $request->input('instagram_url'),
                'about_url' => $request->input('about_url'),
                'contact_url' => $request->input('contact_url'),
                'terms_url' => $request->input('terms_url'),
                'privacy_url' => $request->input('privacy_url'),
            ];

            if ($request->hasFile('favicon')) {
                logger('Favicon uploaded: ' . $request->file('favicon')->getClientOriginalName());

                if ($page->favicon && file_exists(public_path($page->favicon)) && $page->favicon !== 'assets/grinning_2171967.png') {
                    unlink(public_path($page->favicon));
                    logger('Old favicon deleted: ' . $page->favicon);
                }

                $faviconFile = $request->file('favicon');
                $originalName = $faviconFile->getClientOriginalName();
                $faviconPath = 'assets/' . $originalName;
                $fullPath = public_path($faviconPath);

                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($fullPath, file_get_contents($faviconFile));
                $data['favicon'] = $faviconPath;
                logger('Favicon path saved: ' . $faviconPath);
            } else {
                logger('No favicon uploaded');
            }

            $page->update($data);
            logger('Page updated: ' . json_encode($data));

            return redirect()->route('admin.pages.index')->with('success', 'Cấu hình đã được cập nhật!');
        }

        return view('admin.pages.index', compact('page'));
    }
}