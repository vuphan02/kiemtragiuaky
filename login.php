<?php
// Kiểm tra xem người dùng đã gửi biểu mẫu đăng nhập hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối tới cơ sở dữ liệu MySQL
    $conn = mysqli_connect("localhost", "root", "", "ql_nhansu");
    if (!$conn) {
        die("Không thể kết nối đến cơ sở dữ liệu: " . mysqli_connect_error());
    }

    // Lấy dữ liệu từ biểu mẫu đăng nhập
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Xây dựng câu truy vấn SQL để kiểm tra thông tin đăng nhập
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    // Kiểm tra xem có người dùng hợp lệ hay không
    if (mysqli_num_rows($result) > 0) {
        // Đăng nhập thành công, chuyển hướng đến trang chính hoặc trang khác
        header("Location: index.php");
        exit();
    } else {
        // Sai thông tin đăng nhập, hiển thị thông báo lỗi
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="POST" action="login.php">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" required><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html> 