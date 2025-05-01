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

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-tools"></i>
                    <span>Cấu hình web</span>
                </a>
            </li>

            <li class="nav-item active">
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
                        <h1 class="h3 mb-0 text-gray-800">Quản lý APK</h1>
                    </div>

                    <!-- Hiển thị thông báo -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">APK đang chọn</h6>
                        </div>
                        <div class="card-body">
                            <div id="currentApkInfo">
                                <p><strong>Tên tệp:</strong> <span id="currentApkName">Chưa có APK nào được chọn</span></p>
                                <p><strong>Ngày tải lên:</strong> <span id="currentApkDate">N/A</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Form tải lên APK -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tải lên APK</h6>
                        </div>
                        <div class="card-body">
                            <form id="uploadForm" enctype="multipart/form-data" class="mb-4">
                                <div class="mb-3">
                                    <label for="custom_filename" class="form-label">Tên tệp</label>
                                    <input type="text" class="form-control" id="custom_filename" name="custom_filename" required>
                                </div>
                                <div class="mb-3">
                                    <label for="apk_file" class="form-label">Chọn tệp APK</label>
                                    <input type="file" class="form-control" id="apk_file" name="apk_file" accept=".apk" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload APK</button>
                            </form>
                        </div>
                    </div>

                    <!-- Danh sách APK -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách tệp APK</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="apkTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Filename</th>
                                            <th>Upload Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="apkTableBody"></tbody>
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
    const API_BASE_URL = 'http://localhost:55010/upload-file/';
    const API_KEY = '{{ $apiKey }}'; // Truyền từ Controller

    // Lấy và hiển thị thông tin APK hiện tại
    async function loadCurrentApk() {
        try {
            const response = await fetch(API_BASE_URL + 'apks/current/', {
                method: 'GET',
                headers: { 'API-Key': API_KEY }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const current = await response.json();
            console.log('Current APK response:', current);
            const currentApk = current.apk || '';
            const apkNameElement = document.getElementById('currentApkName');
            const apkDateElement = document.getElementById('currentApkDate');

            if (currentApk) {
                apkNameElement.textContent = currentApk;
                apkDateElement.textContent = current.upload_date || 'N/A';
            } else {
                apkNameElement.textContent = 'Chưa có APK nào được chọn';
                apkDateElement.textContent = 'N/A';
            }
        } catch (error) {
            console.error('Error loading current APK:', error);
            Swal.fire('Error', 'Không thể tải thông tin APK hiện tại: ' + error.message, 'error');
        }
    }

    // Lấy danh sách APK khi trang tải
    async function loadApks() {
        try {
            const [apksResponse, currentResponse] = await Promise.all([
                fetch(API_BASE_URL + 'apks/', {
                    method: 'GET',
                    headers: { 'API-Key': API_KEY }
                }),
                fetch(API_BASE_URL + 'apks/current/', {
                    method: 'GET',
                    headers: { 'API-Key': API_KEY }
                })
            ]);

            if (!apksResponse.ok) {
                throw new Error(`HTTP error! status: ${apksResponse.status}`);
            }
            if (!currentResponse.ok) {
                throw new Error(`HTTP error! status: ${currentResponse.status}`);
            }

            const apks = await apksResponse.json();
            const current = await currentResponse.json();
            console.log('APKs response:', apks);
            console.log('Current APK response:', current);
            const currentApk = current.apk || '';

            const tbody = document.getElementById('apkTableBody');
            tbody.innerHTML = '';
            apks.apks.forEach(apk => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${apk.filename} ${apk.filename === currentApk ? '<span class="badge badge-success">Selected</span>' : ''}</td>
                    <td>${apk.upload_date}</td>
                    <td>
                        <button class="btn btn-sm btn-success btn-select" data-filename="${apk.filename}">Select</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-filename="${apk.filename}">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            document.querySelectorAll('.btn-select').forEach(button => {
                button.addEventListener('click', selectApk);
            });
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', deleteApk);
            });

            await loadCurrentApk();
        } catch (error) {
            console.error('Error loading APKs:', error);
            Swal.fire('Error', 'Lỗi khi tải danh sách APK: ' + error.message, 'error');
        }
    }

    // Xử lý form tải lên APK
    document.getElementById('uploadForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('custom_filename', document.getElementById('custom_filename').value);
        formData.append('file', document.getElementById('apk_file').files[0]);

        try {
            const response = await fetch(API_BASE_URL + 'upload-apk/', {
                method: 'POST',
                headers: {
                    'API-Key': API_KEY,
                },
                body: formData,
            });

            const result = await response.json();
            if (response.ok) {
                Swal.fire('Success', 'Tải lên APK thành công!', 'success');
                loadApks();
            } else {
                Swal.fire('Error', 'Không thể tải lên APK: ' + result.detail, 'error');
            }
        } catch (error) {
            console.error('Error uploading APK:', error);
            Swal.fire('Error', 'Lỗi khi tải lên APK: ' + error.message, 'error');
        }
    });

    // Xử lý chọn APK
    async function selectApk(event) {
        const filename = event.target.dataset.filename;
        console.log('Selecting APK:', filename);
        try {
            const response = await fetch(API_BASE_URL + 'apks/select/', {
                method: 'POST',
                headers: {
                    'API-Key': API_KEY,
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `filename=${encodeURIComponent(filename)}`,
            });

            const result = await response.json();
            console.log('Select APK response:', result);
            if (response.ok) {
                Swal.fire('Success', 'Chọn APK thành công!', 'success');
                loadApks();
            } else {
                Swal.fire('Error', 'Không thể chọn APK: ' + result.detail, 'error');
            }
        } catch (error) {
            console.error('Error selecting APK:', error);
            Swal.fire('Error', 'Lỗi khi chọn APK: ' + error.message, 'error');
        }
    }

    // Xử lý xóa APK
    async function deleteApk(event) {
        const filename = event.target.dataset.filename;
        console.log('Deleting APK:', filename);
        try {
            const response = await fetch(API_BASE_URL + 'apks/' + encodeURIComponent(filename), {
                method: 'DELETE',
                headers: {
                    'API-Key': API_KEY,
                },
            });

            const result = await response.json();
            console.log('Delete APK response:', result);
            if (response.ok) {
                Swal.fire('Success', 'Xóa APK thành công!', 'success');
                loadApks();
            } else {
                Swal.fire('Error', 'Không thể xóa APK: ' + result.detail, 'error');
            }
        } catch (error) {
            console.error('Error deleting APK:', error);
            Swal.fire('Error', 'Lỗi khi xóa APK: ' + error.message, 'error');
        }
    }

    // Gọi loadApks khi trang tải
    document.addEventListener('DOMContentLoaded', loadApks);
</script>
</body>
@endsection