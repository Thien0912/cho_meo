@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mt-5">
        <!-- Nút trở về -->
        <div class="row mb-3">
            <div class="col-12 text-left">
                <a href="{{ url('/') }}" class="btn btn-secondary">Trở về trang chủ</a>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Card để bọc nội dung -->
                <div class="card shadow-lg">
                    <div class="card-body">
                        <!-- Tiêu đề và mô tả -->
                        <h1 class="text-primary text-center">Tải ảnh chó/mèo lên để nhận diện</h1>
                        
                        <!-- Button tải ảnh lên -->
                        <div class="upload-container text-center mb-4">
                            <button class="btn btn-primary btn-lg" onclick="document.getElementById('upload').click();">Chọn ảnh</button>
                            <input type="file" id="upload" accept="image/*" class="form-control-file" style="display: none;" onchange="showImage(this)">
                        </div>
                        
                        <!-- Kết quả nhận diện (sẽ hiển thị ngay sau khi ảnh được chọn) -->
                        <div class="result-container text-center" id="result-container">
                            <h3 class="text-success">Giống nhận diện:</h3>
                            <!-- Hình minh họa đẹp hơn thay thế placeholder -->
                            <img id="uploaded-image" 
                                src="{{ asset('assets/img/dog-and-cat-simple-icon-illustration-material.png') }}" 
                                alt="Uploaded Image" 
                                class="img-fluid mb-3" 
                                style="width: 100%; max-width: 300px; height: auto; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                            <p id="cat-breed-result" class="text-info h5">Vui lòng chọn ảnh để nhận diện.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <!-- Gọi script từ public/js -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        function showImage(input) {
            // Kiểm tra nếu có file được chọn
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                // Hiển thị ảnh đã chọn lên trang
                reader.onload = function (e) {
                    document.getElementById('uploaded-image').src = e.target.result;
                    document.getElementById('cat-breed-result').textContent = "Đang nhận diện giống chó/mèo..."; // Có thể thay đổi thông báo ở đây
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
