<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon từ cơ sở dữ liệu -->
    @php
        $page = \App\Models\Page::first();
        $faviconPath = $page->favicon ?? 'assets/grinning_2171967.png';
        $faviconUrl = file_exists(public_path($faviconPath)) ? asset($faviconPath) : asset('assets/grinning_2171967.png');
        // Debug đường dẫn favicon
        \Illuminate\Support\Facades\Log::debug('Favicon path used: ' . $faviconPath);
        \Illuminate\Support\Facades\Log::debug('Favicon URL used: ' . $faviconUrl);
    @endphp
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}?v={{ time() }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Page::first()->title }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body>
    @stack('scripts')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link home-link" href="{{ route('home') }}">
                                <img src="{{ $faviconUrl }}" alt="Home Logo" class="home-logo me-2">Trang chủ 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('download.apk') }}">Tải APK</a>
                        </li>
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">Blog</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('breed.index') }}">Thư viện</a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('deposit.show') }}" id="coins-display">
                                Coin(s): {{ $totalCoins }}
                            </a>
                        </li>
                        @endauth
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Welcome: {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Đăng xuất') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('edit') }}" aria-labelledby="navbarDropdown">
                                        {{ __('Chỉnh sửa thông tin') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('deposit.show') }}" aria-labelledby="navbarDropdown">
                                        {{ __('Nạp coin') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-0">
            @yield('content')
        </main>
    </div>

    <!-- Custom CSS for home link -->
    <style>
        .home-logo {
            height: 24px;
            vertical-align: middle;
        }

        .home-link {
            display: flex;
            align-items: center;
        }
    </style>
</body>
</html>