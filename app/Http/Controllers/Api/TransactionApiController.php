<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class TransactionApiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'             => 'required|exists:users,id',
            'amount'              => 'required|numeric|min:1000',
            'momo_transaction_id' => 'required|unique:transactions,momo_transaction_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        Transaction::create([
            'user_id'             => $request->user_id,
            'amount'              => $request->amount,
            'momo_transaction_id' => $request->momo_transaction_id,
            'status'              => 'pending',
        ]);

        return response()->json(['message' => 'Yêu cầu nạp tiền đã được ghi nhận']);
    }
}
