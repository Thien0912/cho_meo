@extends('layouts.app')

@section('content')

@if (session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 15px;">
        ✅ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 15px;">
        ❌ {{ session('error') }}
    </div>
@endif

<section>
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card rounded-3">
                    <div class="card-body mx-1 my-2">
                        <div class="text-center mb-3">
                            <b>MÃ QR MOMO</b><br>
                            <img src="{{ asset('assets/img/momo_qr.png') }}" alt="QR MoMo" style="width: 300px;">
                        </div>

                        <div class="pt-3">
                            <form action="{{ route('deposit.store') }}" method="POST">
                                @csrf
                                <div class="d-flex flex-row pb-3 form-group">
                                    <div class="rounded border d-flex w-100 px-3 py-2 align-items-center">
                                        <div class="d-flex flex-column py-1">
                                            <p class="mb-1 small text-primary">Số tiền (1 coin = 2000 VND)</p>
                                            <div class="d-flex flex-row align-items-center">
                                                <input type="number" class="form-control form-control-sm" name="amount" id="numberExample" required min="0"/>
                                                <h6 class="mb-0 text-primary pe-1 ms-2">VND</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row pb-3 form-group">
                                    <div class="rounded border d-flex w-100 px-3 py-2 align-items-center">
                                        <div class="d-flex flex-column py-1">
                                            <p class="mb-1 small text-primary">Mã giao dịch</p>
                                            <p class="mb-1 small text-primary">(Vui lòng nhập vào nội dung chuyển tiền)</p>
                                            <div class="d-flex flex-row align-items-center">
                                                <input type="text" class="form-control form-control-sm" name="momo_transaction_id" value="{{ $randomTransactionId ?? '' }}" readonly>    
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pb-1">
                                    <a href="{{ url('/') }}" class="text-muted">Trở về</a>
                                    <button type="submit" class="btn btn-primary btn-lg">Thanh toán</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection