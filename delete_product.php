<?php
session_start();

if (!isset($_SESSION['check_status']) || $_SESSION['check_status'] !== "login_ok") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // 資料庫連線
    $servername = "localhost";
    $username = "root";
    $password = "123456789"; 
    $dbname = "member";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 刪除資料
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('產品成功刪除');
        window.location.href = 'shopadmin.php';
        </script>";

    } else {
        echo "<script>
        alert('刪除產品時出錯:'. $conn->error);
        window.location.href = 'shopadmin.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "無效的請求";
}
?>