<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข้อมูลผู้ใช้ - ผู้จัดการหอพัก</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>จัดการข้อมูลผู้ใช้ - ผู้จัดการหอพัก</h2>
        <table class="user-table">
            <tr>
                <th>ชื่อผู้ใช้</th>
                <th>อีเมล</th>
                <th>สิทธิ์การใช้งาน</th>
                <th>ดำเนินการ</th>
            </tr>
            <tr>
                <td>JohnDoe</td>
                <td>johndoe@example.com</td>
                <td>
                    <select>
                        <option value="staff">ผู้จัดการหอพัก</option>
                        <option value="staff">ช่างซ่อม</option>
                        <option value="resident">ผู้เข้าพัก</option>
                    </select>
                </td>
                <td>
                    <button class="save-button">บันทึก</button>
                </td>
            </tr>
            <!-- เพิ่มรายการผู้ใช้อื่นๆ ตามต้องการ -->
        </table>
    </div>
</body>
</html>
