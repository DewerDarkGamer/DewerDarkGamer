<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "myinternet";
$dbname = "db_maintenance";

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าผู้ใช้ได้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['room_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href = 'home.php';</script>";
    exit();
}

// ตรวจสอบสิทธิ์การใช้งานของผู้ใช้ (เฉพาะ Manager)
$username = $_SESSION['room_id'];
$sql = "SELECT Acc_id FROM users WHERE room_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Acc_id = $row['Acc_id'];
    if ($Acc_id != 1) { // เฉพาะผู้ใช้ที่มี Acc_id = 1 (Manager) เท่านั้นที่สามารถเข้าถึงหน้านี้ได้
        echo "<script>alert('คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้'); window.location.href = 'home.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'home.php';</script>";
    exit();
}

// ตรวจสอบว่ามีการส่ง Use_id มาหรือไม่
if (isset($_GET['Use_id'])) {
    $use_id = $_GET['Use_id'];

    // ตรวจสอบว่ามีข้อมูลผู้ใช้ที่ต้องการลบอยู่จริงหรือไม่
    $checkSql = "SELECT * FROM users WHERE Use_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $use_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        // ลบข้อมูลผู้ใช้
        $deleteSql = "DELETE FROM users WHERE Use_id = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $use_id);
        if ($stmt->execute()) {
            echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location.href = 'manage_users.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'manage_users.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'manage_users.php';</script>";
    exit();
}

$conn->close();
?>
