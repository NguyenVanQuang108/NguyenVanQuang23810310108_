<?php
// db_connect.php - Bài 2: Kết nối Database

// Thông tin kết nối
$host = 'localhost';
$dbname = 'buoi2_php';
$username = 'root';  // Mặc định của XAMPP
$password = '';      // Mặc định của XAMPP (để trống)

try {
    // Kết nối bằng PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Cấu hình PDO để báo lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Không echo gì cả - để có thể include vào file khác
    
} catch (PDOException $e) {
    // Hiển thị thông báo thân thiện
    die("<div style='padding: 20px; background: #ffcccc; border: 1px solid red;'>
            <h3>Hệ thống đang bảo trì</h3>
            <p>Vui lòng quay lại sau.</p>
        </div>");
}

// Để test lỗi: thay $password = '123' (sai mật khẩu) và chạy lại
?>