<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลผู้ใช้ระบบ</title>
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
            margin-bottom: 5px;
        }
        .input-group input, 
        .input-group select {
            width: 50%;
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .input-group input:focus, 
        .input-group select:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn {
            display: block;
            width: 50%;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-sizing: border-box;
        }
        .btn:hover {
            background-color: #0056b3;
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
        <h2>เพิ่มข้อมูลผู้ใช้ระบบ</h2>
        <form action="add_user_process.php" method="POST">
        <div class="input-group">
                <label for="user_type">ประเภทผู้ใช้</label>
                <select id="user_type" name="user_type" required>
                    <option value="" selected disabled>โปรดเลือก</option>
                    <option value="admin">ผู้ดูแลระบบ</option>
                    <option value="user">ผู้ใช้ทั่วไป</option>
                </select>

            <div class="input-group">
                <label for="username">ชื่อ - นามสกุล</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                  <label for="username">ที่อยู่</label>
                <select id="province" name="province" required>
                    <option value="" selected disabled>จังหวัด</option>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="เชียงใหม่">เชียงใหม่</option>
                    <!-- เพิ่มตัวเลือกจังหวัดตามที่ต้องการ -->
                </select>
                <select id="province" name="province" required>
                    <option value="" selected disabled>อำเภอ</option>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="เชียงใหม่">เชียงใหม่</option>
                    <!-- เพิ่มตัวเลือกจังหวัดตามที่ต้องการ -->
                </select>
                <select id="province" name="province" required>
                    <option value="" selected disabled>ตำบล</option>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="เชียงใหม่">เชียงใหม่</option>
                    <!-- เพิ่มตัวเลือกจังหวัดตามที่ต้องการ -->
                </select>
                <div class="input-group">
                <input type="text" placeholder="บ้านเลขที่ ถนน ซอย" required>
            </div>
            <div class="input-group">
                <label for="password">เบอร์โทร</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">ชื่อผู้ใช้ (Username)</label>
                <input type="text" id="username" name="username" required>
            </div>
<div class="input-group">
                <label for="username">รหัสผ่าน (Password)</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="password">ยืนยัน รหัสผ่าน (Confirm Password)</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="room_id">หมายเลขห้อง</label>
                <input type="text" id="room_id" name="room_id" required>
            </div>
            <button type="submit" class="btn">เพิ่มข้อมูล</button>
        </form>
    </div>
</body>
</html>
