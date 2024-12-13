<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานข้อมูลการซ่อมบำรุง</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS สำหรับลดขนาดตัวอักษร */
        .small-text {
            font-size: 14px; /* ปรับตามความต้องการ */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="http://localhost/Project/St/logo.jpg" alt="Logo" class="logo">
            <h2 style="text-align: left;">ลิ้มกิ้มเชียง อพาร์ทเมนท์<br>
                <span class="small-text">1/13 หมู่ 7 ถนนพหลโยธิน ตำบลเชียงรากน้อย อำเภอบางปะอิน จังหวัดพระนครศรีอยุธยา 13180<br>
                โทรศัพท์: 0-3523-7166</span>
            </h2>
        </header>
        <h2 style="text-align: center;">รายงานข้อมูลการซ่อมบำรุง<br><br></h2>
        <div style="text-align: left;">
            <p><strong>ประจำเดือน มีนาคม 2567</strong></p>
        </div>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "myinternet";
        $dbname = "db_maintenance";

        // เชื่อมต่อฐานข้อมูล
        $conn = new mysqli($servername, $username, $password, $dbname);

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
        $sql = "SELECT mm.M_id, mm.M_status, mm.M_detail, users.Room_id
                FROM mm
                INNER JOIN users ON mm.Use_id = users.Use_id";

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
            echo "<div style='text-align: left; margin-top: 20px;'>จำนวนการซ่อมบำรุงทั้งหมด : ".$result->num_rows." ครั้ง</div>";
            echo "<div style='text-align: right; margin-top: 20px;'>ผู้พิมพ์รายงาน : เจษฎา สุภาพ</div>";
            echo "<div style='text-align: right;'>วันที่พิมพ์ : ".strftime('%e %B %Y', time())."</div>";

        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
