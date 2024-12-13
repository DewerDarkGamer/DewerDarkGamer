<?php
session_start();
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "myinternet";
$dbname = "db_maintenance";
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

// ตรวจสอบสิทธิ์การเข้าถึง (เฉพาะ Manager ที่ Acc_id = 1)
$room_id = $_SESSION['room_id'];
$sql = "SELECT Acc_id FROM users WHERE Room_id = '$room_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Acc_id = $row['Acc_id'];
    if ($Acc_id != 1) {
        // หากไม่ใช่ Manager (Acc_id != 1) ให้เปลี่ยนเส้นทางไปยังหน้า home.php พร้อมแสดง Alert
        echo "<script>alert('คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้'); window.location.href = 'home.php';</script>";
        exit();
    }
} else {
    // หากไม่พบข้อมูลผู้ใช้ในฐานข้อมูล ให้เปลี่ยนเส้นทางไปยังหน้า home.php พร้อมแสดง Alert
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'home.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
            display: flex;
        }
        header li {
            margin-left: 20px;
        }
        header #branding {
            display: flex;
            align-items: center;
        }
        header #branding h1 {
            margin: 0;
        }
        section {
            padding: 20px;
            margin: 20px 0;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            background: #0779e4;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">ระบบ</span> จัดการผู้ใช้</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="report_repair.php" id="report-repair-link">แจ้งซ่อม</a></li>
                    <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                    <li><a href="manage_repair.php" id="manage-repair-link">จัดการการซ่อม</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section>
        <div class="container">
            <h2>รายชื่อผู้ใช้</h2>
            <a href="register.php" class="button">ลงทะเบียนสมาชิก</a>
            <table>
    <tr>
        <th>ลำดับ</th>
        <th>ชื่อผู้ใช้</th>
        <th>ที่อยู่</th>
        <th>เบอร์โทร</th>
        <th>สิทธิการใช้งาน</th>
        <th>เลขห้องพัก</th>
        <th>สถานะห้อง</th>
        <th>การกระทำ</th>
    </tr>
    <?php
    // ดึงข้อมูลผู้ใช้ทั้งหมดจากฐานข้อมูลพร้อมข้อมูลสิทธิ์และสถานะ
    $sql = "SELECT users.*, admin.Acc_name FROM users 
            INNER JOIN admin ON users.Acc_id = admin.Acc_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            // กำหนดสถานะและสีพื้นหลัง
            if ($row['status_id'] == 1) {
                $status = "เช่าแล้ว";
                $background = "background-color: green; color: white;";
            } elseif ($row['status_id'] == 2) {
                $status = "ห้องว่าง";
                $background = "background-color: red; color: white;";
            } else {
                $status = "สถานะไม่ทราบ";
                $background = "background-color: grey; color: white;";
            }

            echo "<tr>
                    <td>{$count}</td>
                    <td>{$row['Use_name']}</td>
                    <td>{$row['Use_address']}</td>
                    <td>{$row['Use_tel']}</td>
                    <td>{$row['Acc_name']}</td>
                    <td>{$row['Room_id']}</td>
                    <td style='{$background}'>{$status}</td>
                    <td>
                        <a href='edit_user.php?Use_id={$row['Use_id']}' class='button'>แก้ไข</a>
                    </td>
                  </tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='8'>ไม่มีผู้ใช้</td></tr>";
    }
    ?>
</table>
        </div>
    </section>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>

    <script>
        function confirmDelete() {
            return confirm("คุณต้องการลบข้อมูลผู้ใช้นี้หรือไม่?");
        }
    </script>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
