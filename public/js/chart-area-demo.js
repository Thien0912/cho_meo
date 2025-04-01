document.addEventListener("DOMContentLoaded", function () {
    fetch("/visitors")
        .then(response => response.json())
        .then(data => {
            let labels = data.map(item => item.date);
            let counts = data.map(item => item.count);

            let ctx = document.getElementById("myAreaChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        // Bỏ label để không hiển thị tiêu đề dữ liệu
                        data: counts,
                        borderColor: "rgba(78, 115, 223, 1)",
                        backgroundColor: "rgba(78, 115, 223, 0.2)",
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    },
                    plugins: {
                        // Ẩn legend
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                // Tùy chỉnh tooltip
                                label: function(tooltipItem) {
                                    return 'Số lượng truy cập: ' + tooltipItem.raw; // Thêm "Số lượng truy cập: " trước số liệu
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading chart data:', error));
});
