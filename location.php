<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Lấy vị trí người dùng</title>
    <script>
        async function getLocationAndSend() {
            if (!navigator.geolocation) {
                console.error("Trình duyệt không hỗ trợ Geolocation.");
                return;
            }

            try {
                navigator.geolocation.getCurrentPosition(async function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    // Gửi dữ liệu vị trí lên server
                    let response = await fetch("save_location.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `latitude=${latitude}&longitude=${longitude}`
                    });

                    if (response.ok) {
                        console.log("Dữ liệu vị trí đã gửi thành công!");
                    } else {
                        console.error("Lỗi khi gửi dữ liệu vị trí.");
                    }
                }, function(error) {
                    console.error("Lỗi: " + error.message);
                });
            } catch (err) {
                console.error("Đã xảy ra lỗi:", err);
            }
        }

        window.onload = getLocationAndSend;
    </script>
</head>
<body>
    <h1>Đang lấy vị trí của bạn...</h1>
</body>
</html>