<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS สำหรับลดขนาดตัวอักษร */
        .small-text {
            font-size: 14px; /* ปรับตามความต้องการ */
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
        }
        .input-group input {
            width: 97%;
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .input-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: #dc3545;
            margin-top: 10px;
        }
        /* CSS สำหรับลดขนาดตัวอักษร */
        .small-text {
            font-size: 14px; /* ปรับตามความต้องการ */
        }
        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="http://localhost/Project/St/logo.jpg" alt="Logo" class="logo">
            <h2 style="text-align: left;">ลิ้มกิ้มเชียง อพาร์ทเมนท์<br>
                <span class="small-text">1/13 หมู่ 7 ถนนพหลโยธิน ตำบลเชียงรากน้อย<br> อำเภอบางปะอิน จังหวัดพระนครศรีอยุธยา 13180<br>
                โทรศัพท์: 0-3523-7166</span>
            </h2>
        </header>
        <h2>เข้าสู่ระบบ</h2>
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="message">
            <?php
            if(isset($_GET['error']) && $_GET['error'] == 'true'){
                echo "Invalid username or password.";
            }
            ?>
        </div>
        <div class="forgot-password">
            <a href="forgot_password.php">ลืมรหัสผ่าน?</a>
        </div>
    </div>
</body>
</html>
