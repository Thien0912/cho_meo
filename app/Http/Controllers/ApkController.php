<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ApkController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $apiKey = env('FASTAPI_KEY', 'iAtteKj8TSqUK4kdrHHC2QlIldEdfMjk'); // Lấy từ .env
        return view('admin.apk.index', compact('apiKey'));
    }
}