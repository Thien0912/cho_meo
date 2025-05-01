@extends('layouts.app')

@section('content')
<link href="css/styles.css" rel="stylesheet" />

<header class="masthead">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="text-center text-white">
                    <!-- Page heading-->
                    <h1 class="mb-5">KHÁM PHÁ THẾ GIỚI ĐẦY MÀU SẮC CỦA CÁC GIỐNG CHÓ MÈO ĐỘC ĐÁO!</h1>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Image Showcases-->
<section class="showcase">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('{{ asset('assets/img/dog.jpg') }}')"></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>SỰ THÔNG MINH VÀ TRUNG THÀNH CỦA LOÀI CHÓ</h2>
                <p class="lead mb-0">Chó là một trong những loài động vật thông minh và trung thành nhất. Chúng có khả năng học hỏi nhanh chóng, ghi nhớ mệnh lệnh và thậm chí hiểu được cảm xúc của con người. Nhiều giống chó như Border Collie, Poodle hay German Shepherd nổi tiếng với khả năng giải quyết vấn đề và thực hiện các nhiệm vụ phức tạp. Ngoài ra, chó còn có bản năng bảo vệ, sẵn sàng bảo vệ chủ nhân khỏi nguy hiểm và luôn ở bên cạnh an ủi khi bạn buồn.</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-6 text-white showcase-img" style="background-image: url('{{ asset('assets/img/image-79322-800.jpg') }}')"></div>
            <div class="col-lg-6 my-auto showcase-text">
                <h2>TÍNH ĐỘC LẬP VÀ QUYẾN RŨ CỦA LOÀI MÈO</h2>
                <p class="lead mb-0">Mèo nổi tiếng với tính cách độc lập và sự duyên dáng tự nhiên. Chúng có thói quen làm sạch cơ thể thường xuyên và di chuyển rất nhẹ nhàng, uyển chuyển. Dù có vẻ lạnh lùng, mèo lại rất thích được vuốt ve và thường cọ mình vào người mà chúng tin tưởng. Tiếng kêu "meo meo" và tiếng rừ rừ của mèo không chỉ đáng yêu mà còn có tác dụng làm giảm căng thẳng cho con người.</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('{{ asset('assets/img/living-with-cats-dogs-689902.jpg') }}')"></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>NHỮNG ĐIỀU THÚ VỊ CỦA CHÓ VÀ MÈO</h2>
                <p class="lead mb-0">Chó và mèo có sự đa dạng về giống loài vô cùng phong phú, với hơn 340 giống chó và khoảng 70 giống mèo được công nhận trên thế giới. Chó có các giống nổi tiếng như Golden Retriever với tính cách thân thiện, Border Collie thông minh và nhanh nhẹn, hay Chihuahua nhỏ bé nhưng rất tinh nghịch. Trong khi đó, mèo cũng có những giống đặc biệt như Mèo Maine Coon với kích thước lớn và bộ lông dày, Mèo Ba Tư có khuôn mặt dẹt dễ thương, hay Mèo Scottish Fold với đôi tai cụp độc đáo. Mỗi giống đều có đặc điểm ngoại hình, tính cách và hành vi riêng, khiến chúng trở nên độc đáo và thu hút trong thế giới động vật.</p>
            </div>
        </div>
    </div>
</section>

<section class="call-to-action text-white text-center">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <h1 class="mb-5">SỬ DỤNG AI ĐỂ NHẬN DIỆN GIỐNG CHÓ MÈO</h1>
            <div>
                <button class="btn btn-warning btn-lg custom-btn" onclick="window.location.href='{{ route('chat') }}'">Trải nghiệm ngay!</button>
            </div>
        </div>
    </div>
</section>

<!-- Footer-->
<footer class="footer bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                <ul class="list-inline mb-2">
                    <li class="list-inline-item"><a href="{{ $page->about_url ?: '#' }}">About</a></li>
                    <li class="list-inline-item">⋅</li>
                    <li class="list-inline-item"><a href="{{ $page->contact_url ?: '#' }}">Contact</a></li>
                    <li class="list-inline-item">⋅</li>
                    <li class="list-inline-item"><a href="{{ $page->terms_url ?: '#' }}">Terms of Use</a></li>
                    <li class="list-inline-item">⋅</li>
                    <li class="list-inline-item"><a href="{{ $page->privacy_url ?: '#' }}">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-4">
                        <a href="{{ $page->facebook_url ?: '#' }}" target="_blank"><i class="bi-facebook fs-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ $page->instagram_url ?: '#' }}" target="_blank"><i class="bi-instagram fs-3"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Custom CSS for the button, header, and call-to-action background -->
<style>
    .custom-btn {
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 50px;
        background-color: #ffc107; /* Yellow background */
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-btn:hover {
        background-color: #e0a800; /* Darker yellow on hover */
        transform: scale(1.05);
    }

    .masthead {
        background-image: url('{{ asset('assets/img/family.jpg') }}') !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .call-to-action {
        background-image: url('{{ asset('assets/img/footer.png') }}') !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    @media (max-width: 576px) {
        .custom-btn {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }
</style>
@endsection