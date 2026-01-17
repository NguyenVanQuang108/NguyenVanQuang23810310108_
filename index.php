<?php
// index.php - Trang chủ Lab 3
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 3 - Session & Authentication</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f0f2f5; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 20px; text-align: center; }
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card h2 { margin-top: 0; color: #333; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        .btn { display: inline-block; padding: 12px 25px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { opacity: 0.9; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .user-status { background: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .lab-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Lab 3: Session & Authentication</h1>
        <p>Nguyễn Văn Quang - 23810310108</p>
        
        <div class="user-status">
            <?php if (isset($_SESSION['user'])): ?>
                <p>👤 <strong>Đã đăng nhập:</strong> <?php echo $_SESSION['user']['email']; ?></p>
                <div>
                    <a href="dashboard.php" class="btn">📊 Dashboard</a>
                    <a href="logout.php" class="btn btn-danger">🚪 Đăng xuất</a>
                </div>
            <?php else: ?>
                <p>🔒 <strong>Chưa đăng nhập</strong></p>
                <div>
                    <a href="login.php" class="btn">🔐 Đăng nhập</a>
                    <a href="register.php" class="btn btn-success">📝 Đăng ký</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="container">
        <div class="lab-grid">
            <div class="card">
                <h2>📚 Bài 1: Đăng ký tài khoản</h2>
                <p>Sử dụng <code>password_hash()</code> để mã hóa mật khẩu</p>
                <p>Lưu vào bảng students (dùng chung với Lab 2)</p>
                <a href="register.php" class="btn btn-success">📝 Đăng ký</a>
            </div>
            
            <div class="card">
                <h2>🔐 Bài 2: Đăng nhập</h2>
                <p>Sử dụng <code>password_verify()</code> để kiểm tra mật khẩu</p>
                <p>Lưu thông tin vào <code>$_SESSION['user']</code></p>
                <a href="login.php" class="btn">🔐 Đăng nhập</a>
            </div>
            
            <div class="card">
                <h2>🎯 Bài 3: Trang quản trị</h2>
                <p>Bảo vệ trang bằng Session</p>
                <p>Kiểm tra: <code>if(!isset($_SESSION['user']))</code></p>
                <a href="dashboard.php" class="btn">📊 Dashboard</a>
                <a href="logout.php" class="btn">🚪 Đăng xuất</a>
            </div>
            
            <div class="card">
                <h2>🛒 Bài 4: Giỏ hàng (Challenge)</h2>
                <p>Sử dụng mảng trong Session</p>
                <p>Dữ liệu được giữ khi refresh (F5)</p>
                <a href="cart.php" class="btn">🛒 Giỏ hàng</a>
            </div>
        </div>
        
        <div class="card">
            <h2>📋 Hướng dẫn test</h2>
            <ol>
                <li>Vào <strong>Bài 1</strong>: Đăng ký tài khoản mới</li>
                <li>Vào <strong>Bài 2</strong>: Đăng nhập với tài khoản vừa tạo</li>
                <li>Vào <strong>Bài 3</strong>: Test bảo mật (mở dashboard trong trình duyệt ẩn danh)</li>
                <li>Vào <strong>Bài 4</strong>: Test giỏ hàng (thêm sản phẩm → F5)</li>
            </ol>
            
            <div style="margin-top: 20px;">
                <a href="../lab2/index.php" class="btn">📚 Xem Lab 2</a>
                <a href="http://localhost/phpmyadmin" target="_blank" class="btn">🗄️ Xem Database</a>
            </div>
        </div>
    </div>
</body>
</html>