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

// ตรวจสอบว่าผู้ใช้ได้เข้าสู่ระบบแล้วหรือไม่
if (!isset($_SESSION['room_id'])) {
    header('Location: login.php');
    exit();
}

// ตรวจสอบว่าผู้ใช้มีสิทธิ์เป็น Manager หรือ Admin หรือไม่
if ($_SESSION['role'] !== 'Manager' && $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้'); window.location.href = 'home.php';</script>";
    exit();
}

// ตรวจสอบว่ามีการส่งฟอร์มเพื่ออัปเดตสถานะการซ่อมหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repair_id = $_POST['repair_id'];
    $new_status = $_POST['status'];

    $update_sql = "UPDATE mm SET M_status = ? WHERE M_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $new_status, $repair_id);
    
    if ($stmt->execute()) {
        echo "<p>อัปเดตสถานะสำเร็จ!</p>";
    } else {
        echo "<p>เกิดข้อผิดพลาดในการอัปเดตสถานะ: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// ดึงข้อมูลการแจ้งซ่อมทั้งหมด
$sql = "SELECT mm.M_id, mm.M_type, mm.M_status, mm.M_detail, mm.M_date, users.Room_id 
        FROM mm
        INNER JOIN users ON mm.Room_id = users.Room_id
        ORDER BY mm.M_date DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสถานะการซ่อมบำรุง</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ใช้สไตล์เหมือนหน้า home.php */
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
        .button {
            display: inline-block;
            background: #0779e4;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
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
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <img src="http://localhost/Project/Logo.jpg" alt="Logo" class="logo">
                <h1><span class="highlight">ระบบ</span> จัดการสถานะการซ่อมบำรุง</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="report_repair.php" id="report-repair-link">แจ้งซ่อม</a></li>
                    <li><a href="manage_users.php" id="manage-users-link">จัดการผู้ใช้</a></li>
                    <li><a href="manage_repair.php" id="manage-repair-link">จัดการการซ่อม</a></li>
                    <li><a href="logout.php" id="logout-link">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="main-content">
        <div class="container">
            <h2>การแจ้งซ่อมบำรุง</h2>
            <?php if ($result->num_rows > 0): ?>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>รหัสการซ่อมบำรุง</th>
                            <th>ประเภทการซ่อม</th>
                            <th>รายละเอียด</th>
                            <th>วันที่แจ้ง</th>
                            <th>หมายเลขห้อง</th>
                            <th>สถานะ</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['M_id']; ?></td>
                                <td><?php echo $row['M_type']; ?></td>
                                <td><?php echo $row['M_detail']; ?></td>
                                <td><?php echo $row['M_date']; ?></td>
                                <td><?php echo $row['Room_id']; ?></td>
                                <td><?php echo $row['M_status']; ?></td>
                                <td>
                                    <form action="manage_repair.php" method="POST">
                                        <input type="hidden" name="repair_id" value="<?php echo $row['M_id']; ?>">
                                        <select name="status">
                                            <option value="รอดำเนินการ" <?php if ($row['M_status'] == 'รอดำเนินการ') echo 'selected'; ?>>รอดำเนินการ</option>
                                            <option value="กำลังซ่อม" <?php if ($row['M_status'] == 'กำลังซ่อม') echo 'selected'; ?>>กำลังซ่อม</option>
                                            <option value="ซ่อมเสร็จแล้ว" <?php if ($row['M_status'] == 'ซ่อมเสร็จแล้ว') echo 'selected'; ?>>ซ่อมเสร็จแล้ว</option>
                                        </select>
                                        <button type="submit" class="button">อัปเดต</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>ไม่มีการแจ้งซ่อมบำรุง</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>

    <!-- Popup สำหรับเข้าสู่ระบบ -->
    <div class="popup" id="login-popup">
        <div class="popup-content">
            <h2>เข้าสู่ระบบ</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            // เช็คว่ามี Session Username หรือไม่
            if (!checkSession()) {
                // หากไม่มี Session ให้แสดง Popup เข้าสู่ระบบ
                document.getElementById('login-popup').style.display = 'flex';
            } else {
                // หากมี Session ให้ไปยังหน้าออกจากระบบ
                window.location.href = 'logout.php';
            }
        });

        // Function เช็ค Session Username ว่ามีหรือไม่
        function checkSession() {
            var username = '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>';
            return username !== '';
        }
    </script>
</body>
</html>
