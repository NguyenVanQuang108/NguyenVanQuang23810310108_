<?php
// register.php - Bài 1: Đăng ký tài khoản với mật khẩu mã hóa
require_once 'db_connect.php';

$message = '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 3 - Bài 1: Đăng ký</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 500px; margin: auto; }
        .container { background: #f9f9f9; padding: 25px; border-radius: 10px; }
        h2 { color: #333; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn { background: #4CAF50; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn:hover { background: #45a049; }
        .message { padding: 15px; margin: 15px 0; border-radius: 5px; text-align: center; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .links { text-align: center; margin-top: 20px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Bài 1: Đăng ký tài khoản</h2>
        <p style="text-align: center; color: #666;">Mật khẩu sẽ được mã hóa bằng password_hash()</p>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $student_code = $_POST['student_code'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($fullname) || empty($student_code) || empty($email) || empty($password)) {
                $message = "<div class='message error'>Vui lòng điền đầy đủ thông tin!</div>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "<div class='message error'>Email không hợp lệ!</div>";
            } elseif (strlen($password) < 6) {
                $message = "<div class='message error'>Mật khẩu phải có ít nhất 6 ký tự!</div>";
            } else {
                try {
                    // Mã hóa mật khẩu (YÊU CẦU ĐỀ BÀI)
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Lưu vào bảng students (DÙNG CHUNG VỚI LAB2)
                    $sql = "INSERT INTO students (fullname, student_code, email, password) 
                            VALUES (:fullname, :student_code, :email, :password)";
                    $stmt = $pdo->prepare($sql);
                    
                    $stmt->bindParam(':fullname', $fullname);
                    $stmt->bindParam(':student_code', $student_code);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);
                    
                    if ($stmt->execute()) {
                        $message = "<div class='message success'>
                            ✅ Đăng ký thành công!<br>
                            <small>Mật khẩu đã được mã hóa: " . substr($hashed_password, 0, 30) . "...</small>
                        </div>";
                    }
                    
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $message = "<div class='message error'>Email hoặc mã sinh viên đã tồn tại!</div>";
                    } else {
                        $message = "<div class='message error'>Lỗi: " . $e->getMessage() . "</div>";
                    }
                }
            }
        }
        
        echo $message;
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="fullname" required value="<?php echo $_POST['fullname'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Mã sinh viên:</label>
                <input type="text" name="student_code" required value="<?php echo $_POST['student_code'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
                <small style="color: #666;">Ít nhất 6 ký tự</small>
            </div>
            
            <button type="submit" class="btn">Đăng ký</button>
        </form>
        
        <div class="links">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
            <p><a href="index.php">🏠 Trang chủ Lab 3</a> | 
               <a href="../lab2/index.php">📚 Xem Lab 2</a></p>
        </div>
    </div>
</body>
</html>