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

            <li class="nav-item active">
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
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-white">
            <br>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quản lý mô hình</h1>
                    </div>

                    <!-- Form upload -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Upload mô hình</h6>
                        </div>
                        <div class="card-body">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <label for="file">Chọn file mô hình (.keras)</label>
                                <input type="file" name="file" id="file" required class="form-control mb-2" accept=".keras" placeholder="Chọn file .keras">
                                <label for="labels_csv">Chọn file nhãn (.csv, tùy chọn)</label>
                                <input type="file" name="labels_csv" id="labels_csv" class="form-control mb-2" accept=".csv" placeholder="Chọn file nhãn .csv (tùy chọn)">
                                <input type="number" step="0.01" name="accuracy" placeholder="Độ chính xác (%)" required class="form-control mb-2">
                                <input type="text" name="custom_filename" placeholder="Tên mô hình" required class="form-control mb-2">
                                <button type="submit" class="btn btn-primary btn-sm">Tải lên</button>
                            </form>
                            <div id="result" class="mt-2 text-success fw-bold"></div>
                        </div>
                    </div>

                    <!-- Hiển thị mô hình đang chọn -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Mô hình đang chọn</h6>
                        </div>
                        <div class="card-body">
                            <div id="currentModelInfo">
                                <p><strong>Tên mô hình:</strong> <span id="currentModelName">Chưa có mô hình nào được chọn</span></p>
                                <p><strong>Ngày tải lên:</strong> <span id="currentModelDate">N/A</span></p>
                                <p><strong>Nhãn:</strong> <span id="currentModelLabels">N/A</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách mô hình -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách mô hình AI</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="modelTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên mô hình</th>
                                            <th>Độ chính xác</th>
                                            <th>Ngày upload</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modelTableBody"></tbody>
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
        const API_URL = "{{ env('UPLOAD_API_URL', 'http://api.chm.adhigtechn.com/upload-file') }}";
        const API_KEY = "{{ env('UPLOAD_API_KEY', 'iAtteKj8TSqUK4kdrHHC2QlIldEdfMjk') }}";

        // Hiển thị mô hình hiện tại
        async function loadCurrentModel() {
            try {
                const res = await fetch(`${API_URL}/models/current/`, {
                    headers: { "API-Key": API_KEY }
                });
                const data = await res.json();
                const currentModelName = document.getElementById("currentModelName");
                const currentModelDate = document.getElementById("currentModelDate");
                const currentModelLabels = document.getElementById("currentModelLabels");

                if (data.model) {
                    currentModelName.textContent = data.model;
                    // Nếu upload_date không có, thử lấy từ danh sách mô hình
                    currentModelDate.textContent = data.upload_date || "Không có dữ liệu ngày tải lên";
                    currentModelLabels.textContent = data.labels || "N/A";

                    // Nếu upload_date là "N/A" hoặc null, thử lấy từ danh sách mô hình
                    if (!data.upload_date) {
                        const modelsRes = await fetch(`${API_URL}/models/`, {
                            headers: { "API-Key": API_KEY }
                        });
                        const modelsData = await modelsRes.json();
                        const currentModel = modelsData.models.find(model => model.filename === data.model);
                        if (currentModel && currentModel.upload_date) {
                            currentModelDate.textContent = currentModel.upload_date;
                        }
                    }
                } else {
                    currentModelName.textContent = "Chưa có mô hình nào được chọn";
                    currentModelDate.textContent = "N/A";
                    currentModelLabels.textContent = "N/A";
                }
            } catch (err) {
                console.error("Error loading current model:", err);
                Swal.fire("Lỗi", "Không thể tải thông tin mô hình hiện tại: " + err.message, "error");
            }
        }

        // Load danh sách mô hình
        async function loadModels() {
            const tbody = document.getElementById("modelTableBody");
            tbody.innerHTML = "<tr><td colspan='5'>Đang tải...</td></tr>";

            try {
                const [modelsRes, currentRes] = await Promise.all([
                    fetch(`${API_URL}/models/`, {
                        headers: { "API-Key": API_KEY }
                    }),
                    fetch(`${API_URL}/models/current/`, {
                        headers: { "API-Key": API_KEY }
                    })
                ]);

                const modelsData = await modelsRes.json();
                const currentData = await currentRes.json();
                const currentModel = currentData.model || "";

                if (modelsData.models.length === 0) {
                    tbody.innerHTML = "<tr><td colspan='5'>Không có mô hình nào.</td></tr>";
                    return;
                }

                tbody.innerHTML = "";
                modelsData.models.forEach((model, index) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${model.filename}${model.filename === currentModel ? ' <span class="badge badge-success">Selected</span>' : ''}</td>
                        <td>${model.accuracy !== "N/A" ? `${(model.accuracy).toFixed(2)}%` : "Chưa có"}</td>
                        <td>${model.upload_date || "Chưa có"}</td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="setCurrentModel('${model.filename}')">Sử dụng</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteModel('${model.filename}')">Xóa</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (err) {
                console.error("Error loading models:", err);
                tbody.innerHTML = "<tr><td colspan='5'>Không thể tải mô hình.</td></tr>";
                Swal.fire("Lỗi", "Không thể tải danh sách mô hình: " + err.message, "error");
            }
        }

        // Upload file
        document.getElementById("uploadForm").addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const result = document.getElementById("result");
            result.textContent = "Đang upload...";

            try {
                const res = await fetch(`${API_URL}/upload/`, {
                    method: "POST",
                    headers: { "API-Key": API_KEY },
                    body: formData
                });
                const data = await res.json();

                if (res.ok) {
                    result.innerHTML = `Đã upload: <strong>${data.filename}</strong>`;
                    await loadModels();
                    await loadCurrentModel();
                } else {
                    result.textContent = "Lỗi: " + (data.detail || "Không rõ nguyên nhân");
                }
            } catch (err) {
                result.textContent = "Không thể kết nối tới API.";
                Swal.fire("Lỗi", "Không thể kết nối tới API: " + err.message, "error");
            }
        });

        // Set mô hình hiện tại
        async function setCurrentModel(filename) {
            const formData = new FormData();
            formData.append('filename', filename);

            try {
                const res = await fetch(`${API_URL}/models/select/`, {
                    method: "POST",
                    headers: { "API-Key": API_KEY },
                    body: formData
                });

                if (res.ok) {
                    Swal.fire("Thành công", "Chọn mô hình thành công!", "success");
                    await loadCurrentModel();
                    await loadModels();
                } else {
                    Swal.fire("Lỗi", "Không thể chọn mô hình", "error");
                }
            } catch (err) {
                console.error("Error setting current model:", err);
                Swal.fire("Lỗi", "Không thể chọn mô hình: " + err.message, "error");
            }
        }

        // Xóa mô hình
        async function deleteModel(filename) {
            try {
                const res = await fetch(`${API_URL}/models/${filename}`, {
                    method: "DELETE",
                    headers: { "Content-Type": "application/json", "API-Key": API_KEY }
                });

                if (res.ok) {
                    Swal.fire("Thành công", "Xóa mô hình thành công!", "success");
                    await loadModels();
                    await loadCurrentModel();
                } else {
                    Swal.fire("Lỗi", "Không thể xóa mô hình", "error");
                }
            } catch (err) {
                console.error("Error deleting model:", err);
                Swal.fire("Lỗi", "Không thể xóa mô hình: " + err.message, "error");
            }
        }

        // Khi load trang
        document.addEventListener("DOMContentLoaded", function () {
            loadCurrentModel();
            loadModels();
        });
    </script>

</body>
@endsection