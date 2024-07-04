<?php
session_start();

if (!isset($_SESSION['check_status']) || $_SESSION['check_status'] !== "login_ok") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $filename = '';

    // File upload handling
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $upload_directory = "picture/";

        // Check if the directory exists, if not, create it
        if (!is_dir($upload_directory)) {
            mkdir($upload_directory, 0777, true);
        }

        // Move uploaded file to picture directory
        $target_file = $upload_directory . $filename;
        if (!move_uploaded_file($tmp_name, $target_file)) {
            echo "<script>
            alert('上傳圖片時發生錯誤');
            window.location.href = 'shop.php';
            </script>";
            exit;
        }
    }

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "123456789"; 
    $dbname = "member";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($filename) {
        // Update product details including image filename
        $image_path = "picture/" . $filename;
        $sql = "UPDATE products SET name=?, class=?, description=?, price=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $name, $class, $description, $price, $image_path, $product_id);
    } else {
        // Update product details excluding image filename
        $sql = "UPDATE products SET name=?, class=?, description=?, price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $name, $class, $description, $price, $product_id);
    }

    if ($stmt->execute()) {
        echo "<script>
        alert('產品資料更新成功');
        window.location.href = 'shopadmin.php';
        </script>";
    } else {
        echo "<script>
        alert('更新產品資料時出錯：" . $conn->error . "');
        window.location.href = 'shop.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "無效的請求";
}
?>