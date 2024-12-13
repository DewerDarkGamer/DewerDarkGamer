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
$room_id = $_SESSION['room_id'];
$sql = "SELECT Acc_id FROM users WHERE Room_id = '$room_id'";
$result = $conn->query($sql);

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

// การจัดการข้อมูลสมาชิก
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_user'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $password = $_POST['password'];
    $acc_id = $_POST['acc_id'];
    $room_id_new = $_POST['room_id'];
    $type_id = $_POST['type_id']; // รับข้อมูลประเภทห้องพัก
    $status_id = 1; // กำหนดค่า status_id เป็น 1 โดยอัตโนมัติ

    $sql = "INSERT INTO users (Use_name, Use_address, Use_tel, Use_pass, Acc_id, Room_id, type_id, status_id) 
            VALUES ('$name', '$address', '$tel', '$password', '$acc_id', '$room_id_new', '$type_id', '$status_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ลงทะเบียนสมาชิกสำเร็จ'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนสมาชิก</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS เดิม */
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input, form select {
            display: block;
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            padding: 10px 20px;
            background: #0779e4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script>
        function resetForm() {
            document.getElementsByName('name')[0].value = '';
            document.getElementsByName('password')[0].value = '';
            document.getElementsByName('confirm_password')[0].value = '';
        }

        function validateForm() {
            var password = document.getElementsByName('password')[0].value;
            var confirmPassword = document.getElementsByName('confirm_password')[0].value;
            if (password !== confirmPassword) {
                alert('รหัสผ่านทั้งสองช่องไม่ตรงกัน');
                return false;
            }
            return true;
        }

        window.onload = resetForm;
    </script>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">ระบบ</span> ลงทะเบียนสมาชิก</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="report_repair.php">แจ้งซ่อม</a></li>
                    <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                    <li><a href="manage_repair.php">จัดการการซ่อม</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ฟอร์มสำหรับการลงทะเบียนสมาชิก -->
    <section>
        <div class="container">
            <h2>ลงทะเบียนสมาชิกใหม่</h2>
            <form action="register.php" method="POST" onsubmit="return validateForm()" autocomplete="off">
                <input type="hidden" name="register_user" value="1">
                <label for="name">ชื่อผู้ใช้-นามสกุล</label>
                <input type="text" name="name" id="name" placeholder="กรุณาใส่ชื่อผู้ใช้และนามสกุล" required autocomplete="off">

                <label for="address">ที่อยู่</label>
                <input type="text" name="address" id="address" placeholder="กรุณาใส่ที่อยู่" required autocomplete="off">

                <label for="tel">เบอร์โทร</label>
                <input type="text" name="tel" id="tel" placeholder="กรุณาใส่เบอร์โทร" required autocomplete="off">

                <label for="password">Password (เลขบัตรประชาชน)</label>
                <input type="password" name="password" id="password" placeholder="กรุณาใส่ Password" required autocomplete="off">

                <label for="confirm_password">ยืนยัน Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="กรุณาใส่ Password อีกครั้ง" required autocomplete="off">

                <label for="acc_id">ประเภทผู้ใช้</label>
                <select name="acc_id" id="acc_id" required>
                    <option value="" disabled selected>เลือกประเภทผู้ใช้</option>
                    <option value="1">Manager</option>
                    <option value="2">Repairman</option>
                    <option value="3">Customer</option>
                </select>

                <label for="room_id">เลขห้องพัก</label>
                <input type="text" name="room_id" id="room_id" placeholder="กรุณาใส่เลขห้องพัก" required autocomplete="off">

                <label for="type_id">ประเภทห้องพัก</label>
<select name="type_id" id="type_id" required>
    <option value="" disabled selected>เลือกประเภทห้องพัก</option>
    <?php
    $sql = "SELECT type_id, type_name FROM room_types";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
    }
    ?>
</select>

                <button type="submit">ลงทะเบียน</button>
            </form>
        </div>
    </section>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
