<?php
session_start();

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['room_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$room_id = $_SESSION['room_id'];

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

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลประวัติการซ่อมบำรุงของหมายเลขห้องที่เข้าสู่ระบบ
$sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, mm.Room_id, mm.M_pic1, mm.M_pic2, mm.M_pic3, mm.M_date
        FROM mm
        WHERE Room_id = ? AND mm.M_status != 'รอดำเนินการ'
        ORDER BY mm.M_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $room_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการซ่อมบำรุง</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .report-table th, .report-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .report-table th {
            background-color: #0779e4;
            color: #ffffff;
            text-align: center;
        }
        .report-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .report-table tr:hover {
            background-color: #f1f1f1;
        }
        .repair-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #deecd9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #0779e4 3px solid;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header ul {
            padding: 0;
            list-style: none;
            display: flex;
        }
        header li {
            margin-left: 20px;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>ประวัติการซ่อมบำรุง</h1>
        <nav>
            <ul>
                <li><a href="repairman_dashboard.php">Home</a></li>
                <li><a href="assigned_repairs.php">งานที่ได้รับมอบหมาย</a></li>
                <li><a href="repair_history.php">ประวัติการซ่อมบำรุง</a></li>
                <li><a href="logout.php">ออกจากระบบ</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="main-content">
        <div class="container">
            <h2>งานที่ได้รับมอบหมายล่าสุด</h2>
            <p>การแจ้งซ่อมบำรุงที่สำเร็จแล้ว</p>
            <?php
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

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูลการแจ้งซ่อมล่าสุดที่ได้รับมอบหมาย
            $sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, users.Room_id, mm.M_pic1, mm.M_pic2, mm.M_pic3
            FROM mm
            INNER JOIN users ON mm.Room_id = users.Room_id
            WHERE mm.M_status = 'ซ่อมเสร็จแล้ว'
            ORDER BY mm.M_id DESC
            LIMIT 5";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table class='report-table'>
                <tr>
                    <th>รหัสการซ่อมบำรุง</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                    <th>หมายเลขห้อง</th>
                    <th>รูปภาพที่ 1</th>
                    <th>รูปภาพที่ 2</th>
                    <th>รูปภาพที่ 3</th>
                </tr>";
    
        // แสดงข้อมูลในตาราง
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["M_id"]."</td>
                    <td>".$row["M_status"]."</td>
                    <td>".$row["M_detail"]."</td>
                    <td>".$row["Room_id"]."</td>
<td>".( $row["M_pic1"] ? "<a href='".$row["M_pic1"]."' target='_blank'><img src='".$row["M_pic1"]."' alt='Image 1' class='repair-img'></a>" : "-")."</td>
<td>".( $row["M_pic2"] ? "<a href='".$row["M_pic2"]."' target='_blank'><img src='".$row["M_pic2"]."' alt='Image 2' class='repair-img'></a>" : "-")."</td>
<td>".( $row["M_pic3"] ? "<a href='".$row["M_pic3"]."' target='_blank'><img src='".$row["M_pic3"]."' alt='Image 3' class='repair-img'></a>" : "-")."</td>
                  </tr>";
        }
    
        echo "</table>";
    } else {
        echo "<p>ไม่มีการแจ้งซ่อมค้างอยู่</p>";
    }
    
    $conn->close();
    ?>        </div>
    </section>

<footer>
    <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
</footer>
</body>
</html>
