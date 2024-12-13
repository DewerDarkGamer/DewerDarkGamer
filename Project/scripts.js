// Function สำหรับตรวจสอบ Session ผ่านการส่งคำขอไปยังไฟล์ PHP
function checkSession() {
    fetch('check_session.php') // ส่งคำขอไปยังไฟล์ PHP ที่ตรวจสอบ Session
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                // หากมี Session อยู่ให้เปลี่ยนเส้นทางไปยังหน้าที่ต้องการ
                window.location.href = 'manage_users.php';
            } else {
                // หากไม่มี Session ให้แสดง Popup เข้าสู่ระบบ
                document.getElementById('login-popup').style.display = 'flex';
            }
        })
        .catch(error => console.error('Error checking session:', error));
}

// ใช้ Event Listener ในการทำงานเมื่อคลิกที่ลิงก์หรือปุ่มที่ต้องการเข้าถึง
document.getElementById('manage-users-link').addEventListener('click', function(event) {
    event.preventDefault();
    checkSession(); // เรียกใช้ฟังก์ชันเพื่อตรวจสอบ Session ก่อนเข้าถึงหน้าจัดการผู้ใช้
});
