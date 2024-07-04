<?php
session_start();
include('product_backend.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "92MySQLcindy";
$dbname = "member";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // 檢查歷史紀錄中是否已有該產品
    $sql = "SELECT * FROM history WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 若有，更新點擊次數和最後點擊時間
        $sql_update = "UPDATE history SET click_count = click_count + 1, last_click_time = CURRENT_TIMESTAMP WHERE user_id = ? AND product_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $user_id, $product_id);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        // 若沒有，插入新記錄
        $sql_insert = "INSERT INTO history (user_id, product_id) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $user_id, $product_id);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    $stmt->close();
}

$conn->close();
?>