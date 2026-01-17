<?php
// cart.php - Bài 4: Giỏ hàng với Session
// PHẢI ĐẶT session_start() Ở DÒNG ĐẦU TIÊN
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm
if (isset($_GET['add'])) {
    $product_id = (int)$_GET['add'];
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id;
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    $key = array_search($product_id, $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Xử lý xóa toàn bộ
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
}

// Danh sách sản phẩm
$products = [
    1 => ['name' => 'Laptop Dell XPS', 'price' => 25000000, 'image' => '💻'],
    2 => ['name' => 'iPhone 15 Pro', 'price' => 28000000, 'image' => '📱'],
    3 => ['name' => 'Tai nghe Sony', 'price' => 3500000, 'image' => '🎧'],
    4 => ['name' => 'Bàn phím cơ', 'price' => 1500000, 'image' => '⌨️'],
    5 => ['name' => 'Chuột gaming', 'price' => 800000, 'image' => '🖱️'],
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab 3 - Bài 4: Giỏ hàng</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        h1, h2 { color: #333; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin: 30px 0; }
        .product { background: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; }
        .cart-items { background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .cart-item { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; }
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-add { background: #28a745; color: white; }
        .btn-remove { background: #dc3545; color: white; }
        .session-info { background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-top: 30px; font-family: monospace; }
        .f5-test { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Bài 4: Giỏ hàng với Session Array</h1>
        <p>Giỏ hàng được lưu trong $_SESSION['cart'] - một mảng PHP</p>
        
        <div class="f5-test">
            <strong>🎯 Test yêu cầu đề bài:</strong>
            <ol>
                <li>Thêm sản phẩm vào giỏ hàng</li>
                <li>Nhấn F5 (refresh trang)</li>
                <li><strong>Kết quả:</strong> Dữ liệu giỏ hàng vẫn được giữ nguyên</li>
                <li>Điều này chứng tỏ Session hoạt động</li>
            </ol>
        </div>
        
        <div style="margin: 20px 0;">
            <a href="dashboard.php" class="btn" style="background: #007bff; color: white;">← Dashboard</a>
            <a href="cart.php?clear=1" class="btn" style="background: #6c757d; color: white;" 
               onclick="return confirm('Xóa toàn bộ giỏ hàng?')">🗑️ Xóa giỏ hàng</a>
        </div>
        
        <h2>📦 Sản phẩm</h2>
        <div class="products">
            <?php foreach ($products as $id => $product): ?>
            <div class="product">
                <div style="font-size: 40px;"><?php echo $product['image']; ?></div>
                <h3><?php echo $product['name']; ?></h3>
                <p style="color: #e74c3c; font-weight: bold;"><?php echo number_format($product['price']); ?> ₫</p>
                <a href="cart.php?add=<?php echo $id; ?>" class="btn btn-add">+ Thêm vào giỏ</a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <h2>🛍️ Giỏ hàng của bạn (<?php echo count($_SESSION['cart']); ?> sản phẩm)</h2>
        <div class="cart-items">
            <?php if (empty($_SESSION['cart'])): ?>
                <p style="text-align: center; color: #666; font-style: italic;">Giỏ hàng trống</p>
            <?php else: ?>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id):
                    if (isset($products[$product_id])):
                        $product = $products[$product_id];
                        $total += $product['price'];
                ?>
                    <div class="cart-item">
                        <div>
                            <strong><?php echo $product['image']; ?> <?php echo $product['name']; ?></strong>
                            <br>#<?php echo $product_id; ?>
                        </div>
                        <div>
                            <span style="color: #e74c3c;"><?php echo number_format($product['price']); ?> ₫</span>
                            <a href="cart.php?remove=<?php echo $product_id; ?>" class="btn btn-remove" style="margin-left: 10px;">Xóa</a>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
                
                <div style="margin-top: 20px; padding: 15px; background: #2ecc71; color: white; border-radius: 5px;">
                    <h3 style="margin: 0;">Tổng: <?php echo number_format($total); ?> ₫</h3>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="session-info">
            <h3 style="color: white;">🔍 Debug Session Array:</h3>
            <pre>$_SESSION['cart'] = <?php print_r($_SESSION['cart']); ?></pre>
        </div>
    </div>
</body>
</html>