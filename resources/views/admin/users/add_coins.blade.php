@extends('layouts.app')

@section('content')

<!-- Meta Tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<!-- Custom fonts for this template -->
<link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<!-- Begin Page Content -->
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-1">Trang quản lý</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Quản lý</div>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Giao dịch</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Người dùng</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.coin_history') }}">
                    <i class="fas fa-fw fa-coins"></i>
                    <span>Quản lý coins</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Bài đăng</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.expenses.index') }}" >
                    <i class="fas fa-fw fa-hand-holding-usd"></i>
                    <span>Chi tiêu</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <div class="container-fluid">
            <br>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Thêm/Cập nhật Coins</h1>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.process_add_coins') }}" method="POST">
                        @csrf

                        <!-- Chọn người dùng -->
                        <div class="form-group">
                            <label for="user_id">Chọn người dùng:</label>
                            <select name="user_id" class="form-control" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Số coins -->
                        <div class="form-group">
                            <label for="coins_change">Số coins (+/-):</label>
                            <input type="number" name="coins_change" class="form-control" required>
                        </div>

                        <!-- Lý do -->
                        <div class="form-group">
                            <label for="reason">Lý do:</label>
                            <input type="text" name="reason" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Cập nhật Coins</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection
