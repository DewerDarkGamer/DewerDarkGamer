<?php
session_start();

function check_session() {
    if (isset($_SESSION['room_id'])) {
        // มี session ของผู้ใช้อยู่
        echo '<a href="report_repair.php" id="report-now-link" class="button">แจ้งซ่อมตอนนี้</a>';
    } else {
        // ไม่มี session ของผู้ใช้อยู่
        echo '<a href="#" id="login-link" class="button">เข้าสู่ระบบ</a>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อมบำรุงหอพัก</title>
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
        #showcase {
            min-height: 400px;
            background: url('showcase.jpg') no-repeat 0 -100px;
            text-align: center;
            color: #000;
        }
        #showcase h1 {
            margin-top: 100px;
            font-size: 55px;
            margin-bottom: 10px;
        }
        #showcase p {
            font-size: 20px;
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
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .report-table th, .report-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .report-table th {
            background: #f4f4f4;
        }

        /* CSS สำหรับ Popup */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .popup-content h2 {
            margin-top: 0;
        }
        .popup-content input[type="text"],
        .popup-content input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .popup-content button {
            padding: 10px 20px;
            background: #0779e4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <img src="http://localhost/Project/Logo.jpg" alt="Logo" class="logo">
                <h1><span class="highlight">ระบบ</span> แจ้งซ่อมบำรุงหอพัก</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <?php if (isset($_SESSION['room_id'])): ?>
                        <li><a href="report_repair.php">แจ้งซ่อม</a></li>
                        <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                        <li><a href="manage_repair.php" id="manage-repair-link">จัดการการซ่อม</a></li>
                        <li><a href="logout.php">ออกจากระบบ</a></li>
                    <?php else: ?>
                        <li><a href="login.php" id="login-link" class="button">เข้าสู่ระบบ</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <section id="showcase">
        <div class="container">
            <h1>ยินดีต้อนรับสู่ระบบแจ้งซ่อมบำรุงหอพัก</h1>
            <p>ระบบที่ทำให้การแจ้งซ่อมบำรุงง่ายและรวดเร็วสำหรับผู้เช่า</p>
            <?php check_session(); ?>
        </div>
    </section>

    <section id="main-content">
        <div class="container">
            <h2>ข้อมูลล่าสุด</h2>
            <p>การแจ้งซ่อมบำรุงที่ยังค้างอยู่</p>
            <!-- เพิ่มตารางแสดงข้อมูลการซ่อมที่ค้างอยู่ตรงนี้ -->
            <?php
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

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูลการแจ้งซ่อมล่าสุด
            $sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, users.Room_id
                    FROM mm
                    INNER JOIN users ON mm.Room_id = users.Room_id
                    WHERE mm.M_status = 'รอดำเนินการ'
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
                        </tr>";

                // แสดงข้อมูลในตาราง
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["M_id"]."</td>
                            <td>".$row["M_status"]."</td>
                            <td>".$row["M_detail"]."</td>
                            <td>".$row["Room_id"]."</td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "ไม่มีการแจ้งซ่อมค้างอยู่";
            }

            $conn->close();
            ?>
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
                <input type="text" name="room_id" placeholder="หมายเลขห้อง" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('login-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });

        document.getElementById('login-popup').addEventListener('click', function(event) {
            if (event.target == this) {
                this.style.display = 'none';
            }
        });

        <?php if (!isset($_SESSION['room_id'])): ?>
        document.getElementById('login-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });
        <?php endif; ?>
    </script>

    <script src="scripts.js"></script>
</body>
</html>
