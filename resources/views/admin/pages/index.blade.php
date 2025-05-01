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
                <a class="nav-link" href="{{ route('admin.expenses.index') }}">
                    <i class="fas fa-fw fa-hand-holding-usd"></i>
                    <span>Chi tiêu</span>
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

            <li class="nav-item active">
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

        <div id="content-wrapper" class="d-flex flex-column bg-white">
            <br>
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quản lý cấu hình web</h1>
                    </div>

                    <!-- Form để sửa tiêu đề và các liên kết -->
                    <form id="update-page-form" action="{{ route('admin.pages.index') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Cập nhật tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $page->title) }}">
                        </div>

                        <div class="mb-3">
                            <label for="favicon" class="form-label">Favicon (Hình ảnh: .png, .jpg, .jpeg,...)</label>
                            <input type="file" class="form-control" id="favicon" name="favicon" accept="image/png,image/jpeg,image/jpg">
                            @error('favicon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if($page->favicon && file_exists(public_path($page->favicon)))
                                <p>Hiện tại: <img src="{{ asset($page->favicon) }}" alt="Favicon" style="height: 32px; width: auto;"></p>
                            @else
                                <p>Hiện tại: Không có favicon. Giá trị mặc định: <img src="{{ asset('assets/grinning_2171967.png') }}" alt="Default Favicon" style="height: 32px; width: auto;"></p>
                            @endif
                        </div>

                        <!-- Các liên kết -->
                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $page->facebook_url) }}">
                        </div>

                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $page->instagram_url) }}">
                        </div>

                        <div class="mb-3">
                            <label for="about_url" class="form-label">About URL</label>
                            <input type="url" class="form-control" id="about_url" name="about_url" value="{{ old('about_url', $page->about_url) }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_url" class="form-label">Contact URL</label>
                            <input type="url" class="form-control" id="contact_url" name="contact_url" value="{{ old('contact_url', $page->contact_url) }}">
                        </div>

                        <div class="mb-3">
                            <label for="terms_url" class="form-label">Terms of Use URL</label>
                            <input type="url" class="form-control" id="terms_url" name="terms_url" value="{{ old('terms_url', $page->terms_url) }}">
                        </div>

                        <div class="mb-3">
                            <label for="privacy_url" class="form-label">Privacy Policy URL</label>
                            <input type="url" class="form-control" id="privacy_url" name="privacy_url" value="{{ old('privacy_url', $page->privacy_url) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật tiêu đề và liên kết</button>
                    </form>
                    <br>
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

        // Xử lý xác nhận cập nhật cấu hình web
        document.getElementById('update-page-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const confirmed = await Swal.fire({
                title: 'Xác nhận cập nhật',
                text: 'Bạn có chắc chắn muốn cập nhật tiêu đề và các liên kết này?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6'
            });

            if (confirmed.isConfirmed) {
                this.submit(); // Gửi form nếu người dùng xác nhận
            }
        });
    </script>
</body>
@endsection