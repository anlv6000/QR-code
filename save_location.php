<?php
session_start();
$_SESSION['latitude'] = $_POST['lat'] ?? null;
$_SESSION['longitude'] = $_POST['lon'] ?? null;
echo "Vị trí đã lưu!";
?>