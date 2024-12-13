<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์รายงานการแจ้งซ่อม</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>พิมพ์รายงานการแจ้งซ่อม</h2>
        <form method="post" action="print_report_result.php">
            <div class="form-group">
                <label for="month">เลือกเดือน:</label>
                <select id="month" name="month" required>
                    <option value="01">มกราคม</option>
                    <option value="02">กุมภาพันธ์</option>
                    <option value="03">มีนาคม</option>
                    <option value="04">เมษายน</option>
                    <option value="05">พฤษภาคม</option>
                    <option value="06">มิถุนายน</option>
                    <option value="07">กรกฎาคม</option>
                    <option value="08">สิงหาคม</option>
                    <option value="09">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                </select>
            </div>
            <div class="form-group">
                <label for="issue_type">เลือกประเภทการแจ้งซ่อม:</label>
                <select id="issue_type" name="issue_type" required>
                    <option value="electrical">ปัญหาไฟฟ้า</option>
                    <option value="plumbing">ปัญหาประปา</option>
                    <option value="appliance">อุปกรณ์ใช้งาน</option>
                    <option value="others">อื่นๆ</option>
                </select>
            </div>
            <input type="submit" value="พิมพ์รายงาน">
        </form>
    </div>
</body>
</html>
