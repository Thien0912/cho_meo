<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\Post;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // Kiểm tra nếu user chưa đăng nhập hoặc không phải admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Tính tổng thu nhập từ bảng transactions
        $totalIncome = Transaction::where('status', 'approved')->sum('amount');
        $totalPendingTransactions = Transaction::where('status', 'pending')->count();

        // Tính tổng người dùng từ users
        $totalUsers = User::count();

        // Tính tổng bài post
        $totalPosts = Post::count();

        $totalExpenses = Expense::sum('amount');

        return view('admin.dashboard', compact('totalUsers', 'totalIncome', 'totalPosts', 'totalExpenses', 'totalPendingTransactions'));
    }
}
