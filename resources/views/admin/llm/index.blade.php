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

            <li class="nav-item active">
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

        <div id="content-wrapper" class="d-flex flex-column bg-white">
            <br>
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quản lý cấu hình LLM</h1>
                    </div>

                    <!-- Form cập nhật cấu hình -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cập nhật cấu hình LLM</h6>
                        </div>
                        <div class="card-body">
                            <form id="config-form">
                                <div class="mb-3">
                                    <label for="KEY_API_GPT" class="form-label">KEY_API_GPT</label>
                                    <input type="text" class="form-control" id="KEY_API_GPT" name="KEY_API_GPT" value="{{ preg_replace('/^"(.*)"$/', '$1', $config[1] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="GEMINI_API_KEY" class="form-label">GEMINI_API_KEY</label>
                                    <input type="text" class="form-control" id="GEMINI_API_KEY" name="GEMINI_API_KEY" value="{{ preg_replace('/^"(.*)"$/', '$1', $config[2] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="OPENAI_LLM" class="form-label">OPENAI_LLM</label>
                                    <input type="text" class="form-control" id="OPENAI_LLM" name="OPENAI_LLM" value="{{ preg_replace('/^"(.*)"$/', '$1', $config[4] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="GOOGLE_LLM" class="form-label">GOOGLE_LLM</label>
                                    <input type="text" class="form-control" id="GOOGLE_LLM" name="GOOGLE_LLM" value="{{ preg_replace('/^"(.*)"$/', '$1', $config[5] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="SELECTED_LLM" class="form-label">Chọn LLM</label>
                                    <select class="form-control" id="SELECTED_LLM" name="SELECTED_LLM">
                                        <option value="openai" {{ ($config[7] ?? '') == 'openai' ? 'selected' : '' }}>OpenAI</option>
                                        <option value="gemini" {{ ($config[7] ?? '') == 'gemini' ? 'selected' : '' }}>Gemini</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>

                    <!-- Bảng cấu hình hiện tại -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cấu hình hiện tại</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="modelTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="config-table">
                                        @php
                                            $fixedKeys = [
                                                1 => 'KEY_API_GPT',
                                                2 => 'GEMINI_API_KEY',
                                                4 => 'OPENAI_LLM',
                                                5 => 'GOOGLE_LLM',
                                                7 => 'SELECTED_LLM'
                                            ];
                                        @endphp
                                        @foreach ($fixedKeys as $index => $key)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{ $key === 'SELECTED_LLM' ? $config[$index] : preg_replace('/^"(.*)"$/', '$1', $config[$index]) }}</td>
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

            @if (session('error'))
                Swal.fire('Lỗi', '{{ session('error') }}', 'error');
            @endif

            @if (isset($error))
                Swal.fire('Lỗi', '{{ $error }}', 'error');
            @endif
        });

        document.getElementById('config-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            // Lấy dữ liệu từ form
            const formData = new FormData(this);
            const data = {};

            // Các trường text cần thêm dấu ngoặc kép
            const textFields = ['KEY_API_GPT', 'GEMINI_API_KEY', 'OPENAI_LLM', 'GOOGLE_LLM'];
            for (const field of textFields) {
                const value = formData.get(field)?.trim();
                if (value) {
                    data[field] = `"${value}"`;
                }
            }

            // Trường SELECTED_LLM không thêm dấu ngoặc kép
            const selectedLLM = formData.get('SELECTED_LLM')?.trim();
            if (selectedLLM) {
                data['SELECTED_LLM'] = selectedLLM;
            }

            // Kiểm tra nếu không có dữ liệu hợp lệ
            if (Object.keys(data).length === 0) {
                Swal.fire('Cảnh báo', 'Vui lòng nhập ít nhất một giá trị hợp lệ', 'warning');
                return;
            }

            try {
                const response = await fetch('{{ route('admin.llm.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire('Thành công', result.message || 'Cập nhật cấu hình thành công', 'success');
                    // Cập nhật bảng cấu hình
                    const tableBody = document.getElementById('config-table');
                    tableBody.innerHTML = '';
                    const fixedKeys = {
                        1: 'KEY_API_GPT',
                        2: 'GEMINI_API_KEY',
                        4: 'OPENAI_LLM',
                        5: 'GOOGLE_LLM',
                        7: 'SELECTED_LLM'
                    };
                    const indices = [1, 2, 4, 5, 7];
                    for (const index of indices) {
                        const key = fixedKeys[index];
                        const value = result.updated_config[index];
                        const cleanValue = key === 'SELECTED_LLM' ? value : value.replace(/^"(.*)"$/, '$1');
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${key}</td><td>${cleanValue}</td>`;
                        tableBody.appendChild(row);
                    }
                } else {
                    Swal.fire('Lỗi', result.message || 'Không thể cập nhật cấu hình', 'error');
                }
            } catch (error) {
                Swal.fire('Lỗi', 'Lỗi khi kết nối tới API', 'error');
                console.error('Error:', error);
            }
        });
    </script>
</body>
@endsection