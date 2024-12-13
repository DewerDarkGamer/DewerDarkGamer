<?php
session_start();

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามี Session 'room_id' หรือไม่
if (!isset($_SESSION['room_id'])) {
    // หากไม่มี Session 'room_id' ให้เปลี่ยนเส้นทางไปยังหน้า home.php พร้อมแสดง Alert
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href = 'home.php';</script>";
    exit();
}

$conn->close();?>
