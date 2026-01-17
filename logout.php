<?php
// logout.php - Bài 3: Đăng xuất
// PHẢI ĐẶT session_start() Ở DÒNG ĐẦU TIÊN
session_start();

// Xóa tất cả session
$_SESSION = array();

// Xóa session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Hủy session
session_destroy();

// Chuyển hướng về trang login (YÊU CẦU ĐỀ BÀI)
header('Location: login.php');
exit();
?>