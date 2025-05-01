@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Tải ảnh chó/mèo lên để nhận diện</h1>

                    @if($totalCoins <= 0)
                        <div class="text-center">
                            <button class="btn btn-secondary btn-lg" disabled>Chọn ảnh</button>
                        </div>
                    @else
                        <div class="upload-container text-center mb-4">
                            <button class="btn btn-primary btn-lg custom-btn" onclick="document.getElementById('upload').click();">Chọn ảnh</button>
                            <input type="file" id="upload" name="file" accept="image/*" class="form-control-file" style="display: none;" onchange="handleUpload(this)">
                        </div>
                    @endif

                    <div class="result-container text-center" id="result-container">
                        <h3 class="text-success mb-3">Giống nhận diện:</h3>
                        <img id="uploaded-image" 
                             src="{{ asset('assets/img/dog-and-cat-simple-icon-illustration-material.png') }}" 
                             alt="Uploaded Image" 
                             class="img-fluid mb-3 custom-image" >
                        <div id="breed-result" class="text-info h5"></div>
                    </div>

                    <div class="mt-4 p-3 border rounded bg-light text-left result-detail" id="result-detail">
                        Chưa có kết quả.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<!-- Custom CSS with thinner blue border -->
<style>
    .custom-card {
        border: 1px solid #3b82f6; /* Thinner blue border */
        border-radius: 15px;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .custom-btn {
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 50px;
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .custom-image {
        width: 100%;
        max-width: 280px;
        height: auto;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: border-color 0.3s ease;
    }

    .custom-image:hover {
        border-color: #007bff;
    }

    .result-detail {
        background-color: #f1f3f5;
        border-radius: 10px;
        font-size: 0.95rem;
        line-height: 1.6;
        color: #34495e;
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1.5rem;
        }

        .custom-btn {
            padding: 10px 20px;
            font-size: 1rem;
        }

        .custom-image {
            max-width: 220px;
        }
    }
</style>

<script>
    function handleUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('uploaded-image').src = e.target.result;
                document.getElementById('breed-result').textContent = "Đang nhận diện giống chó/mèo...";
                document.getElementById("result-detail").innerHTML = `<div class="text-muted">Đang xử lý...</div>`;
            };

            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append("file", file);

            fetch("{{ url('/chat/upload') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.detail) {
                    document.getElementById("result-detail").innerHTML = `<div class="text-danger">Lỗi: ${data.detail}</div>`;
                    document.getElementById("breed-result").textContent = "Không xác định được.";
                } else {
                    updateCoins();
                    const vectorStorePath = "app/utils/data/data_vector";

                    fetch(`http://localhost:55010/chatbot/analyze?vector_store_path=${encodeURIComponent(vectorStorePath)}`, {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.detail) {
                            document.getElementById("result-detail").innerHTML = `<div class="text-danger">Lỗi: ${data.detail}</div>`;
                            document.getElementById("breed-result").textContent = "Không xác định được.";
                        } else {
                            const { predicted_breed, responses } = data;
                            const finalResponse = responses.final;

                            if (finalResponse.match === "ĐÚNG") {
                                document.getElementById("breed-result").innerHTML = predicted_breed;
                            } else if (finalResponse.match === "SAI") {
                                document.getElementById("breed-result").innerHTML = `${finalResponse.detected_breed}`;
                            } else {
                                document.getElementById("breed-result").innerHTML = "Không xác định được.";
                            }

                            let htmlAnswer = '';

                            if (finalResponse.answer) {
                                htmlAnswer += finalResponse.answer
                                    .replace(/\*\*/g, '')
                                    .replace(/### (.*?)(?=\n|$)/g, '<h5 class="mt-3">$1</h5>')
                                    .replace(/- ([^:]+): (.*?)(?=\n|$)/g, '<li><strong>$1:</strong> $2</li>')
                                    .replace(/- (.*?)(?=\n|$)/g, '<li>$1</li>')
                                    .replace(/\n{2,}/g, '</ul><p>')
                                    .replace(/\n/g, '<br>');
                            } else if (finalResponse.description) {
                                htmlAnswer += finalResponse.description
                                    .replace(/\*\*/g, '')
                                    .replace(/\n{2,}/g, '<br><br>')
                                    .replace(/\n/g, '<br>');
                            } else {
                                htmlAnswer = "<div class='text-muted'>Không có mô tả chi tiết.</div>";
                            }

                            document.getElementById("result-detail").innerHTML = `<div class="answer">${htmlAnswer}</div>`;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById("result-detail").innerHTML = `<div class="text-danger">Không thể kết nối tới API phân tích.</div>`;
                        document.getElementById("breed-result").textContent = "Không xác định được.";
                    });
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById("result-detail").innerHTML = `<div class="text-danger">Không thể trừ xu ngay.</div>`;
            });
        }
    }

    function updateCoins() {
        fetch("{{ route('user.coins') }}")
            .then(res => res.json())
            .then(data => {
                if (data.totalCoins !== undefined) {
                    document.querySelector('.nav-item a[href="{{ route('deposit.show') }}"]').innerHTML = `Coins: ${data.totalCoins}`;
                    const uploadButton = document.querySelector('button[onclick="document.getElementById(\'upload\').click();"]');
                    if (data.totalCoins <= 0) {
                        uploadButton.setAttribute('disabled', true);
                        uploadButton.classList.add('btn-secondary');
                    } else {
                        uploadButton.removeAttribute('disabled');
                        uploadButton.classList.remove('btn-secondary');
                    }
                }
            })
            .catch(err => console.error(err));
    }
</script>
@endsection