<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "myinternet";
$dbname = "db_maintenance";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['room_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href = 'home.php';</script>";
    exit();
}

// Fetch user data from database
$room_id = $_SESSION['room_id'];
$sql = "SELECT Room_id FROM users WHERE Room_id = '$room_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Room_id = $row['Room_id'];
} else {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้'); window.location.href = 'home.php';</script>";
    exit();
}

// When the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if files are uploaded
    if (isset($_FILES['M_pic']) && count($_FILES['M_pic']['name']) > 0) {
        $uploadDir = "uploads/";
        $uploadedFiles = [];
        $allFilesUploaded = true;

        // Loop through each uploaded file
        foreach ($_FILES['M_pic']['name'] as $key => $value) {
            $fileName = basename($_FILES['M_pic']['name'][$key]);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('M_pic_', true) . '.' . $fileExtension;  // Generate a unique file name
            $targetFile = $uploadDir . $newFileName;

            // Ensure the file is uploaded without errors
            if ($_FILES['M_pic']['error'][$key] == UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES['M_pic']['tmp_name'][$key], $targetFile)) {
                    $uploadedFiles[] = $targetFile;
                } else {
                    echo "<script>alert('ไม่สามารถย้ายไฟล์ได้: " . htmlspecialchars($_FILES['M_pic']['error'][$key]) . "');</script>";
                    $allFilesUploaded = false;
                    break;
                }
            } else {
                echo "<script>alert('การอัปโหลดไฟล์ผิดพลาด: รหัสข้อผิดพลาด " . $_FILES['M_pic']['error'][$key] . "');</script>";
                $allFilesUploaded = false;
                break;
            }
        }

        if ($allFilesUploaded) {
            // Insert repair report into database
            $M_detail = $conn->real_escape_string($_POST['M_detail']);
            $M_type = $conn->real_escape_string($_POST['M_type']);
            $M_date = date("Y-m-d H:i:s");
            $M_status = 'รอดำเนินการ';
            $M_pic1 = isset($uploadedFiles[0]) ? $uploadedFiles[0] : '';
            $M_pic2 = isset($uploadedFiles[1]) ? $uploadedFiles[1] : '';
            $M_pic3 = isset($uploadedFiles[2]) ? $uploadedFiles[2] : '';

            $sql = "INSERT INTO mm (Room_id, M_status, M_detail, M_type, M_pic1, M_pic2, M_pic3, M_date) 
                    VALUES ('$Room_id', '$M_status', '$M_detail', '$M_type', '$M_pic1', '$M_pic2', '$M_pic3', '$M_date')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('แจ้งซ่อมเรียบร้อยแล้ว'); window.location.href = 'home.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('มีปัญหาในการอัปโหลดไฟล์'); window.location.href = 'report_repair.php';</script>";
        }
    } else {
        echo "<script>alert('กรุณาอัปโหลดรูปภาพ'); window.location.href = 'report_repair.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อม</title>
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
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
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
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="file"] {
            margin-top: 10px;
        }
        .form-container button {
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
                    <li><a href="report_repair.php">แจ้งซ่อม</a></li>
                    <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                    <li><a href="manage_repair.php" id="manage-repair-link">จัดการการซ่อม</a></li>
                    <li><a href="logout.php">ออกจากระบบ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="main-content">
        <div class="container">
            <h2>แจ้งซ่อม</h2>
            <div class="form-container">
                <form action="report_repair.php" method="POST" enctype="multipart/form-data">
                    <label>หมายเลขห้อง: <?php echo htmlspecialchars($Room_id); ?></label>
                    <select name="M_type" required>
                        <option value="">เลือกประเภทการแจ้งซ่อม</option>
                        <option value="ประปา">แจ้งซ่อมเกี่ยวกับประปา</option>
                        <option value="ไฟฟ้า">แจ้งซ่อมเกี่ยวกับไฟฟ้า</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                    <textarea name="M_detail" placeholder="รายละเอียดการแจ้งซ่อม" required></textarea>
                    <input type="file" name="M_pic[]" multiple>
                    <button type="submit" class="button">แจ้งซ่อม</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <p>ระบบแจ้งซ่อมบำรุงหอพัก | &copy; 2023</p>
    </footer>
</body>
</html>
