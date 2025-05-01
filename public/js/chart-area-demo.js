document.addEventListener("DOMContentLoaded", function () {
    fetch(VISITOR_URL) // Đảm bảo URL đúng (dùng API của `getTransactions`)

        .then(response => response.json())
        .then(data => {
            let labels = data.map(item => item.date);  // Ngày giao dịch
            let income = data.map(item => item.total_income);  // Tổng thu nhập

            let ctx = document.getElementById("myAreaChart").getContext("2d");
            new Chart(ctx, {
                type: 'line', // Loại biểu đồ: Line Chart
                data: {
                    labels: labels,  // Ngày giao dịch
                    datasets: [{
                        label: 'Tổng thu nhập (VNĐ)',  // Tiêu đề của biểu đồ
                        data: income,  // Dữ liệu thu nhập
                        borderColor: "rgba(78, 115, 223, 1)",  // Màu đường biên
                        backgroundColor: "rgba(78, 115, 223, 0.2)",  // Màu nền
                        borderWidth: 2  // Độ dày của đường biên
                    }]
                },
                options: {
                    responsive: true,  // Đảm bảo biểu đồ đáp ứng với kích thước màn hình
                    scales: {
                        x: { grid: { display: false } },  // Ẩn lưới trục x
                        y: { beginAtZero: true }  // Bắt đầu trục y từ 0
                    },
                    plugins: {
                        legend: { display: true },  // Hiển thị tên biểu đồ
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return 'Thu nhập: ' + tooltipItem.raw + ' VNĐ';  // Hiển thị thu nhập khi hover
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading chart data:', error));
});
