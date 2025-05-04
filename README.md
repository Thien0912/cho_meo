## Giới thiệu
Trang web hỗ trợ người yêu thú cưng nhận diện giống chó/mèo, xem thông tin các giống chó/mèo, xem các bài viết về các giống chó/mèo và quản lý thông tin cá nhân.
## Mô tả
- Nhận diện giống chó/mèo thông qua hình ảnh.
- Cung cấp thông tin chăm sóc thú cưng qua giao diện thân thiện.
- Quản lý tài khoản người dùng (đăng ký, đăng nhập, cập nhật hồ sơ).
Dự án được xây dựng để kết nối cộng đồng yêu thú cưng và cung cấp các công cụ hữu ích.
## Yêu cầu
- PHP >= 8.0
- Composer
- MySQL hoặc database tương thích
- Node.js và NPM (cho giao diện)
## Cài đặt
Clone repository:
- git clone https://github.com/Thien0912/cho_meo.git
- cd cho_meo
Cài đặt phụ thuộc:
- composer install
- npm install
Cấu hình môi trường:
- cp .env.example .env
- Cập nhật database
Tạo key: php artisan key:generate
Chạy migration: php artisan migrate
Biên dịch giao diện: npm run dev
Khởi động server: php artisan serve
Truy cập ứng dụng tại http://localhost:8000
## Hướng dẫn sử dụng
- Đăng ký/Đăng nhập: Tạo tài khoản hoặc đăng nhập để sử dụng.
- Nhận diện giống: Tải ảnh chó/mèo để nhận kết quả.
- Thư viện và blog: Xem các bài viết và thư viện chó/mèo.
- Quản lý hồ sơ: Cập nhật thông tin cá nhân trong mục tài khoản.
## Công nghệ
- Backend: Laravel (PHP)
- Frontend: Blade, JavaScript, CSS
- Database: MySQL
- Công cụ: Composer, NPM, Artisan
- API: Tích hợp API nhận diện hình ảnh
