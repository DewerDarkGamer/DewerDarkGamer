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
        .user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    position: absolute;
    right: 20px;
    top: 20px;
}
.profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
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
                    <li><a href="report_repair.php" id="report-repair-link">แจ้งซ่อม</a></li>
                    <li><a href="logout.php" id="logout-link">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
        <div class="user-info">
            <img src="http://localhost/Project/piccustomer.png" alt="Manager Profile" class="profile-pic">
            <span>ยินดีต้อนรับ, Customer</span>
        </div>

    </header>

    <section id="showcase">
        <div class="container">
            <h1>ยินดีต้อนรับสู่ระบบแจ้งซ่อมบำรุงหอพัก</h1>
            <p>ระบบที่ทำให้การแจ้งซ่อมบำรุงง่ายและรวดเร็วสำหรับผู้เช่า</p>
            <a href="report_repair.php" id="report-now-link" class="button">แจ้งซ่อมตอนนี้</a>
        </div>
    </section>

    <section id="main-content">
        <div class="container">
            <h2>ข้อมูลล่าสุด</h2>
            <p>การแจ้งซ่อมบำรุงที่ยังค้างอยู่</p>
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

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูลการแจ้งซ่อมล่าสุด
            $sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, users.Room_id
                    FROM mm
                    INNER JOIN users ON mm.Use_id = users.Use_id
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
                <input type="text" name="username" placeholder="Username" required>
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

        document.getElementById('report-repair-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });

        document.getElementById('manage-users-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });

        document.getElementById('report-now-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });
    </script>
</body>
</html>
