<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อมบำรุง</title>
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
        .input-group select,
        .input-group textarea {
            width: 50%;
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .input-group input:focus, 
        .input-group select:focus,
        .input-group textarea:focus {
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
        .cancel-btn {
            background-color: #dc3545;
            margin-left: left; /* ชิดขวา */
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
        <h2>แจ้งซ่อมบำรุง</h2>
        <form action="maintenance_request_process.php" method="POST">
            <div class="input-group">
                <label for="room_number">หมายเลขห้อง</label>
                <input type="text" id="room_number" name="room_number" required>
            </div>
            <div class="input-group">
                <label for="room_number">เบอร์โทรติดต่อ</label>
                <input type="text" id="room_number" name="room_number" required>
            </div>

            <div class="input-group">
                <label for="issue_type">ประเภทปัญหา</label>
                <select id="issue_type" name="issue_type" required>
                    <option value="" selected disabled>โปรดเลือก</option>
                    <option value="ไฟฟ้า">ไฟฟ้า</option>
                    <option value="ประปา">ประปา</option>
                    <option value="เฟอร์นิเจอร์">เฟอร์นิเจอร์</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>
            </div>
            <div class="input-group">
                <label for="description">รายละเอียด</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">ส่งคำขอ</button>
            <button class="btn cancel-btn">ยกเลิก</button>
        </form>
    </div>
</body>
</html>
