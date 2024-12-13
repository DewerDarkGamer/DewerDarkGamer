<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว - บริการแจ้งซ่อม</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>แก้ไขข้อมูลส่วนตัว - บริการแจ้งซ่อม</h2>
        <form method="post" action="update_profile.php">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" value="JohnDoe" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" value="johndoe@example.com" required>
            </div>
            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="text" id="phone" name="phone" value="080-123-4567" required>
            </div>
            <!-- ใส่ฟิลด์อื่นๆ ตามต้องการ -->
            <div class="button-container">
                <input type="submit" value="บันทึกข้อมูล">
            </div>
        </form>
    </div>
</body>
</html>
