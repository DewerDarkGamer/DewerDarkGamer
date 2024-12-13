<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก - บริการแจ้งซ่อม</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            color: #333;
            margin-top: 15px;
        }
        .message a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>สมัครสมาชิก - บริการแจ้งซ่อม</h2>
        <form method="post" action="register_process.php">
            <label for="username">หมายเลขห้อง:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">รหัสผ่าน:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">ชื่อ:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">นามสกุล:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">อีเมล:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="email">เบอร์โทรศัพ:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">ประเภทห้อง:</label>
            <input type="email" id="email" name="email" required>

            <label for="month">สิทธิ์การใช้งาน:</label>
            <select id="month" name="month" required
            <option value="03">มีนาคม</option>
            <option value="04">ผู้จัดการหอพัก</option>
            <option value="05">ผู้เข้าพัก</option>
            <option value="06">ช่างซ่อม</option> 
</select>
            
            <input type="submit" value="สมัครสมาชิก">
        </form>
        
        <div class="message">
            มีบัญชีผู้ใช้แล้ว? <a href="login.php">เข้าสู่ระบบ</a>
        </div>
    </div>
</body>
</html>
