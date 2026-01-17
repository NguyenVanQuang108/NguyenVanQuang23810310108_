<?php
// dashboard.php - Bài 3: Trang quản trị
// PHẢI ĐẶT session_start() Ở DÒNG ĐẦU TIÊN
session_start();

// Kiểm tra đăng nhập - nếu chưa đăng nhập thì đá về login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 3 - Bài 3: Dashboard</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f0f2f5; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; }
        .container { max-width: 1000px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; }
        .content { padding: 30px; }
        h1 { margin: 0; }
        .user-info { background: #e8f5e9; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; padding: 10px 20px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { opacity: 0.9; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        .session-debug { background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-top: 30px; font-family: monospace; }
        .test-instruction { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107; }
    </style>
</head>
<body>
    <div class="header">
        <div style="max-width: 1000px; margin: auto;">
            <h1>🎯 Bài 3: Dashboard - Trang quản trị</h1>
            <p>Bảo vệ trang bằng Session</p>
        </div>
    </div>
    
    <div class="container">
        <div class="content">
            <div class="user-info">
                <h2>👋 Xin chào, <?php echo htmlspecialchars($user['fullname']); ?>!</h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($user['student_code']); ?></p>
                <p><strong>User ID:</strong> #<?php echo $user['id']; ?></p>
                
                <div style="margin-top: 15px;">
                    <a href="cart.php" class="btn btn-success">🛒 Bài 4: Giỏ hàng</a>
                    <a href="logout.php" class="btn btn-danger">🚪 Đăng xuất</a>
                    <a href="index.php" class="btn">🏠 Trang chủ</a>
                    <a href="../lab2/list_students.php" class="btn">📚 Danh sách SV (Lab 2)</a>
                </div>
            </div>
            
            <div class="test-instruction">
                <h3>🔍 Test bảo mật (Yêu cầu đề bài):</h3>
                <ol>
                    <li>Copy đường link này: <code><?php echo $_SERVER['REQUEST_URI']; ?></code></li>
                    <li>Mở trình duyệt ẩn danh (Ctrl+Shift+N)</li>
                    <li>Paste đường link vào</li>
                    <li><strong>Kết quả mong đợi:</strong> Tự động chuyển về trang login.php</li>
                </ol>
            </div>
            
            <div class="session-debug">
                <h3 style="color: white;">📊 Debug Session:</h3>
                <pre><?php print_r($_SESSION); ?></pre>
                <p>Session ID: <?php echo session_id(); ?></p>
            </div>
        </div>
    </div>
</body>
</html>