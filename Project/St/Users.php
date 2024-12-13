<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานข้อมูลสมาชิก</title>
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
        <h2 style="text-align: center;">รายงานข้อมูลสมาชิก<br><br></h2>
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
        $sql = "SELECT users.Use_name, users.Use_address, users.Use_tel, admin.Acc_name
                FROM users
                INNER JOIN admin ON users.Acc_id = admin.Acc_id
                WHERE admin.Acc_name IN ('Manager', 'Repairman','Customer')";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // นับจำนวนแถว (จำนวนพนักงาน)
            $num_employees = $result->num_rows;

            echo "<table class='report-table'>
                    <tr>
                        <th style='width: 50px;'>ลำดับ</th> <!-- เพิ่มหัวข้อลำดับ -->
                        <th>ชื่อ</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                        <th>ตำแหน่ง</th>
                    </tr>";

            $count = 1; // ตัวแปรสำหรับเก็บลำดับ

            // แสดงข้อมูลในตาราง
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td style='text-align: center;'>".$count."</td> <!-- แสดงลำดับ -->
                        <td>".$row["Use_name"]."</td>
                        <td>".$row["Use_address"]."</td>
                        <td>".$row["Use_tel"]."</td>
                        <td>".$row["Acc_name"]."</td>
                      </tr>";
                $count++; // เพิ่มลำดับทีละ 1 หลังแสดงแถว
            }
            // เพิ่มข้อความ "ผู้พิมพ์รายงาน" และ "วันที่พิมพ์" ด้านล่างของตารางด้านขวา
            echo "</table>";
            echo "<div style='text-align: left; margin-top: 20px;'>จำนวนพนักงานทั้งหมด : $num_employees คน</div>";
            echo "<div style='text-align: right; margin-top: 20px;'>ผู้พิมพ์รายงาน : เจษฎา สุภาพ</div>";
            echo "<div style='text-align: right;'>วันที่พิมพ์ : 23 มีนาคม 2567</div>";
            //echo "<div style='text-align: right;'>วันที่พิมพ์ : " . strftime('%e %B %Y', time()) . "</div>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>