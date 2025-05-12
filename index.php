<?php
$servername = "localhost";
$username = "ctechlab_tracking";
$password = "Qielli2007@";
$database = "ctechlab_tracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total_visits FROM tracking";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_visits = $row['total_visits'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Thống kê truy cập</title>
    <script>
function sendLocation() {
    navigator.geolocation.getCurrentPosition(function(position) {
        let lat = position.coords.latitude;
        let lon = position.coords.longitude;

        fetch('save_location.php', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `lat=${lat}&lon=${lon}`
        }).then(response => response.text()).then(data => console.log("Server response:", data));
    });
}
</script>
    <style>
 /* Căn chỉnh toàn bộ trang */
body {
    background-color: white;
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 0;
    padding: 0;
}

/* Phần tiêu đề */
h1 {
    font-size: 24px;
    color: black;
    margin-top: 20px;
}

/* Container chính */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* QR Code hiển thị đẹp hơn */
.qr-code {
    display: block;
    margin: 20px auto;
    width: 200px;
    transition: transform 0.3s ease;
}

/* Hiệu ứng khi hover vào QR Code */
.qr-code:hover {
    transform: scale(1.1);
}

/* Chỉnh kích thước bảng lịch sử */
.history-table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
}

/* Kiểu bảng */
.history-table th, .history-table td {
    border: 1px solid black;
    padding: 10px;
}

/* Tiêu đề bảng */
.history-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Tổng số lượt truy cập: <?php echo $total_visits; ?></h1>
        <img src="qr-code.png" alt="QR Code" class="qr-code">
        <a href="history.php" style="
    display: inline-block;
    padding: 10px 20px;
    background-color: blue;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
">
    Xem lịch sử truy cập
</a>
    </div>
</body>
</html>