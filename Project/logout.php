<?php
session_start();

// ล้างข้อมูลเซสชันทั้งหมด
$_SESSION = array();

// ลบเซสชันจากคุกกี้ถ้ามี
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// ทำลายเซสชัน
session_destroy();

// เริ่มเซสชันใหม่เพื่อเพิ่มความปลอดภัย
session_start();
session_regenerate_id(true);

// ส่งกลับไปยังหน้าหลักหลังจากออกจากระบบ
header("Location: index.php");
exit();
?>
