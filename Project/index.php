<?php
session_start();

function check_session() {
    if (isset($_SESSION['room_id'])) {
        // มี session ของผู้ใช้อยู่
        echo '<a href="report_repair.php" id="report-now-link" class="button">แจ้งซ่อมตอนนี้</a>';
    } else {
        // ไม่มี session ของผู้ใช้อยู่
        echo '<a href="#" id="login-link" class="button">เข้าสู่ระบบ</a>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อมบำรุงหอพัก</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #deecd9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #0779e4 3px solid;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
            display: flex;
        }
        header li {
            margin-left: 20px;
        }
        header #branding {
            display: flex;
            align-items: center;
        }
        header #branding h1 {
            margin: 0;
        }
        #showcase {
            min-height: 400px;
            background: url('showcase.jpg') no-repeat 0 -100px;
            text-align: center;
            color: #000;
        }
        #showcase h1 {
            margin-top: 100px;
            font-size: 55px;
            margin-bottom: 10px;
        }
        #showcase p {
            font-size: 20px;
        }
        .button {
            display: inline-block;
            background: #0779e4;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
        }
        .slideshow-container {
            max-width: 80%;
            position: relative;
            margin: 0 auto; /* ทำให้สไลด์โชว์อยู่ตรงกลาง */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            justify-content: center; /* ทำให้รูปภาพอยู่ตรงกลางในแนวนอน */
            align-items: center;     /* ทำให้รูปภาพอยู่ตรงกลางในแนวตั้ง */
        }
        .slides {
            display: flex; /* Center content */
            justify-content: center;
            align-items: center;
            height: 800px; /* Same height as max-height of images */
        }
        .slides img {
            max-width: 100%; /* Adjust to fit within container */
            max-height: 100%; /* Adjust to fit within container */
            object-fit: contain; /* Adjust image to contain within the slide */
            margin: auto; /* Center the image */
            border-radius: 10px;
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        .prev {
            left: 0;
            border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .dots-container {
            text-align: center;
            padding: 20px;
            background: #333;
        }
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
        section {
            padding: 20px;
            margin: 20px 0;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .report-table th, .report-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .report-table th {
            background: #f4f4f4;
        }

        /* CSS สำหรับ Popup */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .popup-content h2 {
            margin-top: 0;
        }
        .popup-content input[type="text"],
        .popup-content input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .popup-content button {
            padding: 10px 20px;
            background: #0779e4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <img src="http://localhost/Project/Logo.jpg" alt="Logo" class="logo">
                <h1><span class="highlight">ระบบ</span> แจ้งซ่อมบำรุงหอพัก</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <?php if (isset($_SESSION['room_id'])): ?>
                        <li><a href="report_repair.php">แจ้งซ่อม</a></li>
                        <li><a href="manage_users.php">จัดการผู้ใช้</a></li>
                        <li><a href="logout.php">ออกจากระบบ</a></li>
                    <?php else: ?>
                        <li><a href="login.php" id="login-link" class="button">เข้าสู่ระบบ</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ส่วนแสดงสไลด์โชว์ -->
    <div class="slideshow-container">
        <!-- Slide 1 -->
        <div class="slides">
            <img src="http://localhost/Project/imgslide1.jpg" alt="Image 1">
        </div>

        <!-- Slide 2 -->
        <div class="slides">
            <img src="http://localhost/Project/imgslide2.jpg" alt="Image 2">
        </div>

        <!-- Slide 3 -->
        <div class="slides">
            <img src="http://localhost/Project/imgslide3.jpg" alt="Image 3">
        </div>

        <!-- Slide 4 -->
        <div class="slides">
            <img src="http://localhost/Project/imgslide4.jpg" alt="Image 4">
        </div>

        <!-- ปุ่ม Next และ Previous -->
        <a class="prev">&#10094;</a>
        <a class="next">&#10095;</a>
    </div>

    <!-- จุดแสดงตำแหน่งของรูปภาพ -->
    <div class="dots-container">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

    <footer>
        <p>ลิ้มกิ้มเชียง อพาร์ทเมนท์ &copy; 2024</p>
    </footer>

    <!-- Popup สำหรับเข้าสู่ระบบ -->
    <div class="popup" id="login-popup">
        <div class="popup-content">
            <h2>เข้าสู่ระบบ</h2>
            <form action="login.php" method="POST">
                <input type="text" name="room_id" placeholder="หมายเลขห้อง" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>

    <script>
        // สไลด์โชว์
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("slides");
            var dots = document.getElementsByClassName("dot");

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 4000); // เปลี่ยนสไลด์ทุก 4 วินาที
        }

        // ควบคุมปุ่ม Previous และ Next
        document.querySelector('.prev').addEventListener('click', function () {
            slideIndex -= 2;
            showSlides();
        });

        document.querySelector('.next').addEventListener('click', function () {
            showSlides();
        });

        document.getElementById('login-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });

        document.getElementById('login-popup').addEventListener('click', function(event) {
            if (event.target == this) {
                this.style.display = 'none';
            }
        });

        <?php if (!isset($_SESSION['room_id'])): ?>
        document.getElementById('login-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-popup').style.display = 'flex';
        });
        <?php endif; ?>
    </script>

    <script src="scripts.js"></script>
</body>
</html>
