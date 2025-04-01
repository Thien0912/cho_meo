@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nạp tiền qua MoMo</h2>

    <img src="{{ asset('momo_qr.png') }}" alt="QR MoMo" style="width: 300px;">
    <p>Quét mã QR để chuyển khoản MoMo</p>

    <form action="{{ route('deposit.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Số tiền:</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="momo_transaction_id">Mã giao dịch MoMo:</label>
            <input type="text" name="momo_transaction_id" value="{{ $randomTransactionId ?? '' }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
    </form>
</div>
@endsection
