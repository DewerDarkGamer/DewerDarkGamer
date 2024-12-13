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

// รับข้อมูลจากฟอร์มและป้องกัน SQL Injection
$room_id = $conn->real_escape_string($_POST['room_id']);
$pass = $conn->real_escape_string($_POST['password']);

// ตรวจสอบข้อมูลผู้ใช้ในฐานข้อมูล
$sql = "SELECT users.*, admin.Acc_name 
        FROM users 
        INNER JOIN admin ON users.Acc_id = admin.Acc_id 
        WHERE Room_id = ? AND Use_pass = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $room_id, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // ผู้ใช้มีอยู่ในฐานข้อมูล
    $row = $result->fetch_assoc();
    $_SESSION['room_id'] = $row['Room_id']; // เก็บ Room_id
    $_SESSION['username'] = $row['Use_name']; // เพิ่ม Username
    $_SESSION['role'] = $row['Acc_name']; // เก็บสิทธิ์ของผู้ใช้

    // กำหนดการเปลี่ยนเส้นทางตามสิทธิ์ของผู้ใช้
    if ($row['Acc_name'] == 'Manager') {
        header("Location: manager_dashboard.php");
    } elseif ($row['Acc_name'] == 'Repairman') {
        header("Location: repairman_dashboard.php");
    } elseif ($row['Acc_name'] == 'Customer') {
        header("Location: customer_dashboard.php");
    } else {
        header("Location: home.php");
    }
    exit(); // หยุดการทำงานหลังจาก Redirect
} else {
    // ข้อมูลไม่ถูกต้อง
    echo "<script>alert('หมายเลขห้องหรือรหัสผ่านไม่ถูกต้อง'); window.location.href = 'login.php';</script>";
}

$stmt->close();
$conn->close();
?>
