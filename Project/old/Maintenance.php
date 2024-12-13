<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อม - บริการแจ้งซ่อม</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>แจ้งซ่อม</h2>
        <form method="post" action="submit_issue.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">หัวข้อ:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">รายละเอียด:</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="room">ห้อง:</label>
                <input type="text" id="room" name="room" required>
            </div>
            <div class="form-group">
                <label for="priority">ความเร่งด่วน:</label>
                <select id="priority" name="priority" required>
                    <option value="low">ต่ำ</option>
                    <option value="medium">กลาง</option>
                    <option value="high">สูง</option>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">วันที่นัดหมาย:</label>
                <input type="date" id="appointment_date" name="appointment_date">
            </div>
            <div class="form-group">
                <label for="contact_number">เบอร์ติดต่อ:</label>
                <input type="text" id="contact_number" name="contact_number">
            </div>
            <div class="form-group">
                <label for="status">สถานะการซ่อม:</label>
                </select>
            </div>
            <div class="form-group">
                <label for="image">รูปภาพ:</label>
                <input type="file" id="image" name="image">
            </div>
            <input type="submit" value="ส่งการแจ้งซ่อม">
        </form>
    </div>
</body>
</html>
