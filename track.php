<?php
$servername = "localhost";
$username = "ctechlab_tracking";
$password = "Qielli2007@";
$database = "ctechlab_tracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy IP và User Agent của người truy cập
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Lấy vị trí từ IP
$geo_data = json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);
$city = $geo_data['city'] ?? 'Không xác định';
$country = $geo_data['country'] ?? 'Không xác định';

// Lấy GPS từ URL nếu có
$latitude = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$longitude = isset($_GET['lon']) ? floatval($_GET['lon']) : null;

// Ghi nhận lượt truy cập vào database
$sql = "INSERT INTO tracking (ip_address, user_agent, city, country, latitude, longitude) 
        VALUES ('$ip', '$user_agent', '$city', '$country', '$latitude', '$longitude')";
$conn->query($sql);

// Chuyển hướng sau khi ghi nhận lượt truy cập
header("Location: https://www.facebook.com/CTechLab");
exit();
?>