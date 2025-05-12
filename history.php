<?php
$servername = "localhost";
$username = "ctechlab_tracking";
$password = "Qielli2007@";
$database = "ctechlab_tracking";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$filter_ip = $_GET['ip'] ?? '';
$filter_date = $_GET['date'] ?? '';

$sql = "SELECT * FROM tracking WHERE 1";

if ($filter_ip) {
    $sql .= " AND ip_address LIKE '%$filter_ip%'";
}
if ($filter_date) {
    $sql .= " AND DATE(visit_time) = '$filter_date'";
}

$sql .= " ORDER BY visit_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Lịch sử truy cập</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; }
        th { background-color: #f2f2f2; }
        .filter { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Lịch sử truy cập</h1>

    <!-- Bộ lọc tìm kiếm -->
    <form class="filter" method="GET">
        <input type="text" name="ip" placeholder="Nhập IP" value="<?php echo htmlspecialchars($filter_ip); ?>">
        <input type="date" name="date" value="<?php echo htmlspecialchars($filter_date); ?>">
        <button type="submit">Tìm kiếm</button>
    </form>

<table>
    <tr>
        <th>STT</th>
        <th>Địa chỉ IP</th>
        <th>Thành phố</th>
        <th>Quốc gia</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Thời gian</th>
        <th>User Agent</th>
    </tr>
    <?php
    $stt = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$stt}</td>";
        echo "<td>{$row['ip_address']}</td>";
        echo "<td>{$row['city']}</td>";
        echo "<td>{$row['country']}</td>";
        echo "<td>{$row['latitude']}</td>";
        echo "<td>{$row['longitude']}</td>";
        echo "<td>{$row['visit_time']}</td>";
        echo "<td>{$row['user_agent']}</td>";
        echo "</tr>";
        $stt++;
    }
    ?>
</table>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script>
function initMap() {
    let map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 0, lng: 0 },
        zoom: 2
    });

    <?php
    $result = $conn->query("SELECT latitude, longitude FROM tracking WHERE latitude IS NOT NULL");
    while ($row = $result->fetch_assoc()) {
        echo "new google.maps.Marker({ position: { lat: {$row['latitude']}, lng: {$row['longitude']} }, map: map });";
    }
    ?>
}
</script>
<div id="map" style="height: 400px;"></div>
</body>
</html>

<?php $conn->close(); ?>