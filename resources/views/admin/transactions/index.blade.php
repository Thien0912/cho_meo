@extends('layouts.app')

@section('content')
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
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

            <li class="nav-item active">
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

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.coin_history') }}">
                    <i class="fas fa-fw fa-coins"></i>
                    <span>Quản lý coins</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Bài đăng</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.breeds.index') }}">
                    <i class="fas fa-fw fa-paw"></i>
                    <span>Thư viện</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.uploads.index') }}">
                    <i class="fas fa-fw fas fa-file"></i>
                    <span>Mô hình</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.llm.index') }}">
                    <i class="fas fa-cog"></i>
                    <span>Cấu hình LLM</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-tools"></i>
                    <span>Cấu hình web</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.apk.index') }}">
                    <i class="fas fa-wrench"></i>
                    <span>Quản lý APK</span>
                </a>
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
                        <h1 class="h3 mb-0 text-gray-800">Quản lý giao dịch</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách giao dịch</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Người dùng</th>
                                            <th>Số tiền</th>
                                            <th>Ngày nạp</th>
                                            <th>Mã giao dịch MoMo</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>{{ $transaction->user->name }}</td>
                                                <td>{{ number_format($transaction->amount) }} VNĐ</td>
                                                <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $transaction->momo_transaction_id }}</td>
                                                <td>
                                                    @if ($transaction->status == 'pending')
                                                        Chờ duyệt
                                                    @elseif ($transaction->status == 'approved')
                                                        Đã duyệt
                                                    @elseif ($transaction->status == 'rejected')
                                                        Đã hủy
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaction->status == 'approved')
                                                        <button class="btn btn-success btn-sm" disabled>Đã duyệt</button>
                                                    @else
                                                        <form action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST" style="display:inline;" class="approve-transaction-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">Duyệt</button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" style="display:inline;" class="reject-transaction-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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

    <script>
        // Hiển thị thông báo từ session khi trang tải
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire('Thành công', '{{ session('success') }}', 'success');
            @endif
        });

        // Xử lý xác nhận duyệt giao dịch
        document.querySelectorAll('.approve-transaction-form').forEach(form => {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                const confirmed = await Swal.fire({
                    title: 'Xác nhận duyệt giao dịch',
                    text: 'Bạn có chắc chắn muốn duyệt giao dịch này?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Duyệt',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#3085d6'
                });

                if (confirmed.isConfirmed) {
                    form.submit(); // Gửi form nếu người dùng xác nhận
                }
            });
        });

        // Xử lý xác nhận từ chối giao dịch
        document.querySelectorAll('.reject-transaction-form').forEach(form => {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                const confirmed = await Swal.fire({
                    title: 'Xác nhận từ chối giao dịch',
                    text: 'Bạn có chắc chắn muốn từ chối giao dịch này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Từ chối',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                });

                if (confirmed.isConfirmed) {
                    form.submit(); // Gửi form nếu người dùng xác nhận
                }
            });
        });
    </script>
</body>
@endsection
