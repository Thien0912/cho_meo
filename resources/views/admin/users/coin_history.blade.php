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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-white">
        <br>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quản lý coins</h1>
                        <a href="{{ route('admin.add_coins') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            Cập nhật</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Coins</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Tên người dùng</th>
                                        <th>Email</th>
                                        <th>Thay đổi Coins</th>
                                        <th>Lý do</th>
                                        <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    @foreach($coinHistory as $history)
                                        <tr>
                                            <td>{{ $history->user_id }}</td>
                                            <td>{{ $history->name }}</td>
                                            <td>{{ $history->email }}</td>
                                            <td style="color: {{ $history->coins_change >= 0 ? 'green' : 'red' }}">
                                                {{ $history->coins_change }}
                                            </td>
                                            <td>{{ $history->reason }}</td>
                                            <td>{{ $history->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Page Content -->

            </div>
            <!-- End Main Content -->

        </div>
        <!-- End Content Wrapper -->
        
    </div>
    <!-- End Wrapper -->
</body>
@endsection
