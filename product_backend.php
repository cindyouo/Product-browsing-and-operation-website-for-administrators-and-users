<?php
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "member";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連結失敗: " . $conn->connect_error);
}

// 添加商品的請求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST["name"];
    $class = $_POST["class"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = null;

    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "picture/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    $sql = "INSERT INTO products (name, class, description, price, image) VALUES ('$name', '$class', '$description', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('新紀錄插入成功');
            window.location.href = 'shopadmin.php';
        </script>";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
}

// 獲取排序選項
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : '';

switch ($sort_option) {
    case 'price_asc':
        $order_by = 'price ASC';
        break;
    case 'price_desc':
        $order_by = 'price DESC';
        break;
    case 'time_new':
        $order_by = 'upload_time DESC';
        break;
    case 'time_old':
        $order_by = 'upload_time ASC';
        break;
    default:
        $order_by = 'id ASC'; // 默認排序
        break;
        
}

// 獲取所有商品，根據選擇的排序方式
$sql = "SELECT * FROM products ORDER BY $order_by";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// 根據 ID 獲取商品詳細信息
function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$conn->close();
?>