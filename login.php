<?php
// login.php - Bài 2: Đăng nhập
// PHẢI ĐẶT session_start() Ở DÒNG ĐẦU TIÊN
session_start();

// Nếu đã đăng nhập, chuyển hướng sang dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

require_once 'db_connect.php';

$message = '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 3 - Bài 2: Đăng nhập</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 500px; margin: auto; }
        .container { background: #f9f9f9; padding: 25px; border-radius: 10px; }
        h2 { color: #333; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn { background: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn:hover { background: #0056b3; }
        .message { padding: 15px; margin: 15px 0; border-radius: 5px; text-align: center; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .links { text-align: center; margin-top: 20px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .demo { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Bài 2: Đăng nhập hệ thống</h2>
        <p style="text-align: center; color: #666;">Sử dụng password_verify() để kiểm tra mật khẩu</p>
        
        <div class="demo">
            <strong>💡 Demo account:</strong><br>
            Email: test@example.com<br>
            Mật khẩu: 123456<br>
            <small>(Hãy đăng ký tài khoản này trước)</small>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $message = "<div class='message error'>Vui lòng nhập email và mật khẩu!</div>";
            } else {
                try {
                    // Tìm user trong bảng students
                    $sql = "SELECT * FROM students WHERE email = :email";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    
                    $student = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($student) {
                        // Kiểm tra mật khẩu với password_verify() (YÊU CẦU ĐỀ BÀI)
                        if (password_verify($password, $student['password'])) {
                            // Đăng nhập thành công, lưu session
                            $_SESSION['user'] = [
                                'id' => $student['id'],
                                'email' => $student['email'],
                                'fullname' => $student['fullname'],
                                'student_code' => $student['student_code']
                            ];
                            
                            // Chuyển hướng sang dashboard.php (YÊU CẦU ĐỀ BÀI)
                            header('Location: dashboard.php');
                            exit();
                        } else {
                            $message = "<div class='message error'>Sai email hoặc mật khẩu!</div>";
                        }
                    } else {
                        $message = "<div class='message error'>Sai email hoặc mật khẩu!</div>";
                    }
                    
                } catch (PDOException $e) {
                    $message = "<div class='message error'>Lỗi hệ thống!</div>";
                }
            }
        }
        
        echo $message;
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Đăng nhập</button>
        </form>
        
        <div class="links">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
            <p><a href="index.php">🏠 Trang chủ Lab 3</a> | 
               <a href="../lab2/index.php">📚 Xem Lab 2</a></p>
        </div>
    </div>
</body>
</html>