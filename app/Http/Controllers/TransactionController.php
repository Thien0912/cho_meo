<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    // Hiển thị form nạp tiền
    public function showDepositForm()
    {
        $randomTransactionId = 'MOMO_' . uniqid(); // Tạo mã giao dịch tự động
        return view('deposit', compact('randomTransactionId'));
    }


    // Lưu thông tin giao dịch
    public function store(Request $request)
    {
        $request->validate([
            'momo_transaction_id' => 'required|unique:transactions',
            'amount' => 'required|numeric|min:1000',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'momo_transaction_id' => $request->momo_transaction_id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Giao dịch đang chờ duyệt.');
    }

    // Hiển thị danh sách giao dịch cho admin
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $transactions = Transaction::all(); // Lấy tất cả
        return view('admin.transactions.index', compact('transactions'));
    }


    // Duyệt giao dịch
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'approved']);

        // Cộng xu thủ công (Admin sẽ tự nhập số xu cho user)
        return redirect()->back()->with('success', 'Giao dịch đã được duyệt.');
    }

    // Từ chối giao dịch
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Giao dịch đã bị từ chối.');
    }
}
