/*!
* Start Bootstrap - Landing Page v6.0.6 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

/*!
* Start Bootstrap - Landing Page v6.0.6 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

async function uploadImage(file) {
    let formData = new FormData();
    formData.append("image", file);

    // Lấy CSRF Token từ cookie hoặc từ một element nếu cần
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        let response = await fetch("/chatbot/ask", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken // Đảm bảo token CSRF được gửi
            },
            body: formData
        });

        if (!response.ok) {
            // Nếu mã trạng thái không phải 200, thông báo lỗi
            let errorData = await response.json();
            document.querySelector("#result").innerText = `❌ Lỗi: ${errorData.error || "Không xác định"}`;
            return;
        }

        let data = await response.json();

        // Hiển thị kết quả lên giao diện
        let result = document.querySelector("#result");
        result.innerText = `✅ Giống mèo: ${data.breed}`;

    } catch (error) {
        document.querySelector("#result").innerText = `❌ Lỗi kết nối: ${error.message}`;
    }
}

// Khi người dùng chọn ảnh
document.querySelector("#upload").addEventListener("change", function(event) {
    let file = event.target.files[0];
    if (file) {
        uploadImage(file);
    } else {
        document.querySelector("#result").innerText = "❌ Vui lòng chọn ảnh.";
    }
});
