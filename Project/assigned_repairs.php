<?php
session_start();

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินเข้ามาแล้วหรือยัง ถ้ายังให้ไปที่หน้า login.php
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

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

// ดึงข้อมูลการแจ้งซ่อมที่มอบหมายให้กับช่างที่ล็อกอินอยู่
$current_username = $_SESSION['username']; // สมมติว่า username ของช่างเก็บใน session
$sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, users.Room_id
        FROM mm
        INNER JOIN users ON mm.Use_id = users.Use_id
        WHERE mm.AssignedTo = '$current_username'
        ORDER BY mm.M_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>งานซ่อมบำรุงที่ได้รับมอบหมาย</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Your CSS styles here */
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
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #0779e4;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">งานซ่อมบำรุง</span> ที่ได้รับมอบหมาย</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="repairman_dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="container">
        <h2>งานซ่อมบำรุงที่ได้รับมอบหมาย</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>รหัสการซ่อมบำรุง</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                    <th>หมายเลขห้อง</th>
                    <th>อัปเดตสถานะ</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["M_id"]; ?></td>
                        <td><?php echo $row["M_status"]; ?></td>
                        <td><?php echo $row["M_detail"]; ?></td>
                        <td><?php echo $row["Room_id"]; ?></td>
                        <td>
                            <form action="update_repair_status.php" method="POST">
                                <input type="hidden" name="M_id" value="<?php echo $row["M_id"]; ?>">
                                <select name="new_status">
                                    <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                    <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                                </select>
                                <button type="submit" class="button">อัปเดต</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>ไม่มีงานซ่อมบำรุงที่ได้รับมอบหมาย</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </section>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>
</body>
</html>
