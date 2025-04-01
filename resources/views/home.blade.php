@extends('layouts.app')

@section('content')
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- Favicon-->
<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
<!-- Bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
<!-- Google fonts-->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="css/styles.css" rel="stylesheet" />
<div class="text-center mt-4">
    <a href="{{ route('deposit.show') }}" class="btn btn-primary btn-lg">Nạp Tiền</a>
</div>

<header class="masthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
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
        <!-- Footer-->
        <footer class="footer bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><a href="#!">About</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Contact</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Terms of Use</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Privacy Policy</a></li>
                        </ul>
                        <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2023. All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-twitter fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
@endsection
