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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $use_id = $_POST['use_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $password = $_POST['password'];
    $acc_id = $_POST['acc_id'];
    $room_id = $_POST['room_id'];
    $status_id = $_POST['status_id'];
    $type_id = $_POST['type_id'];

    $sql = "UPDATE users SET 
                Use_name='$name', 
                Use_address='$address', 
                Use_tel='$tel', 
                Use_pass='$password', 
                Acc_id='$acc_id', 
                Room_id='$room_id', 
                Status_id='$status_id', 
                Type_id='$type_id' 
            WHERE Use_id='$use_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }}

if (isset($_GET['Use_id'])) {
    $use_id = $_GET['Use_id'];
    echo "Debug: Use_id = " . $use_id; // Debugging line
    $sql = "SELECT * FROM users WHERE Use_id = '$use_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'manage_users.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'manage_users.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลสมาชิก</title>
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin: 10px 0 5px;
        }
        form input, form select {
            display: block;
            width: 100%;
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
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">ระบบ</span> แก้ไขข้อมูลสมาชิก</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section>
        <div class="container">
            <h2>แก้ไขข้อมูลสมาชิก</h2>
            <form action="edit_user.php" method="POST">
            <input type="hidden" name="use_id" value="<?php echo $row['Use_id']; ?>">
            
            <label for="name">ชื่อผู้ใช้</label>
            <input type="text" id="name" name="name" value="<?php echo $row['Use_name']; ?>" required>
            
            <label for="address">ที่อยู่</label>
            <input type="text" id="address" name="address" value="<?php echo $row['Use_address']; ?>" required>
            
            <label for="tel">เบอร์โทร</label>
            <input type="text" id="tel" name="tel" value="<?php echo $row['Use_tel']; ?>" required>
            
            <label for="password">รหัสผ่าน</label>
            <input type="password" id="password" name="password" value="<?php echo $row['Use_pass']; ?>" required>
            
            <label for="acc_id">สิทธิ์การใช้งาน</label>
            <select id="acc_id" name="acc_id">
                <option value="1" <?php if ($row['Acc_id'] == 1) echo 'selected'; ?>>Manager</option>
                <option value="2" <?php if ($row['Acc_id'] == 2) echo 'selected'; ?>>Repairman</option>
                <option value="3" <?php if ($row['Acc_id'] == 3) echo 'selected'; ?>>Customer</option>
            </select>
            
            <label for="room_id">เลขห้องพัก</label>
            <input type="text" id="room_id" name="room_id" value="<?php echo $row['Room_id']; ?>" required>
            
            <label for="status_id">สถานะการเช่า</label>
            <select id="status_id" name="status_id">
                <option value="1" <?php if ($row['Status_id'] == 1) echo 'selected'; ?>>เช่าแล้ว</option>
                <option value="2" <?php if ($row['Status_id'] == 2) echo 'selected'; ?>>ห้องว่าง</option>
            </select>
            
            <label for="type_id">ประเภทห้องพัก</label>
            <select id="type_id" name="type_id">
                <option value="1" <?php if ($row['Type_id'] == 1) echo 'selected'; ?>>ห้องพัดลม</option>
                <option value="2" <?php if ($row['Type_id'] == 2) echo 'selected'; ?>>ห้องแอร์</option>
            </select>
            
            <button type="submit">แก้ไข</button>
        </form>        </div>
    </section>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
