@extends('layouts.app')

@section('content')

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<!-- Custom fonts for this template -->
<link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
        
<!-- Begin Page Content -->

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-1">Trang quản lý</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Quản lý
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Giao dịch</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Người dùng</span>
                </a>
            </li>

            <li class="nav-item">
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
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Thêm người dùng</h1>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        {{-- Address --}}
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>

                        {{-- Phone --}}
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="form-control">
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        {{-- Role --}}
                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Blocked</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Tạo</button>
                    </form>
                </div>
            </div>
        </div> <!-- Đóng thẻ div #wrapper -->
    </div>
</body> <!-- Đóng thẻ body -->

@endsection
