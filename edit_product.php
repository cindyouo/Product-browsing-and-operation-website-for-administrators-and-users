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
    $password = "92MySQLcindy"; 
    $dbname = "member";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 根據 product_id 從資料庫中獲取產品資料
    $sql = "SELECT id, class, name, description, price, image FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // 顯示表單讓用戶修改資料
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>修改產品</title>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <header id="header" class="site-header">
            <nav id="header-nav" class="navbar navbar-expand-lg p-3 p-lg-0">
            <div class="container">
            <a class="navbar-brand d-lg-none" href="index.php">
                <img src="images/main-logo.png" class="logo">
            </a>
            <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">Menu</button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
                <div class="offcanvas-header px-4 pb-0">
                <a class="navbar-brand" href="index.php">
                    <img src="images/main-logo.png" class="logo">
                </a>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdNavbar"></button>
                </div>
                <div class="offcanvas-body d-block">
                <ul id="navbar" class="navbar-nav w-100 py-4 d-none d-lg-flex justify-content-between align-items-center border-bottom border-dark">
                    
                    <h3><b>商品展示網站</h3></b>

        
                    <ul class="list-unstyled d-lg-flex justify-content-between align-items-center">
                    <li class="nav-item ms-5 search-item">
                        <div id="search-bar" class="border-right d-none d-lg-block">
                        <form action="" autocomplete="on">
                            <input id="search" class="text-dark" name="search" type="text" placeholder="Search Here...">
                            <a type="submit" class="nav-link me-0" href="#">搜尋</a>
                        </form>
                        </div>
                    </li>

                    <?php
                        if($_SESSION['check_status']=="login_ok"){
                        echo "<li class=\"nav-item\">".
                        "<a href=\"modify.php\"><Img Src=\"person.png\"width=50dp ></a>"
                        ."</li>";
                        echo "<li class=\"nav-item\">".
                        "<a class=\"nav-link\" href=\"#\" onclick=\"logout()\">登出</a>"
                        ."</li>";}
                        else{
                            echo "<li class=\"nav-item\">".
                            "<a class=\"nav-link\" href=\"login.php\">登入</a>"
                        ."</li>";
                        }
                    ?>
                    </ul>
                </ul>
                <ul class="list-unstyled d-lg-flex m-0 py-2">
                    <li class="nav-item ">
                      <a class="nav-link"  href="index.php">首頁</a>
                    </li>
                    <?php
                    if($_SESSION["admin"]=="admin_ok"){
                    echo "<li class=\"nav-item\">".
                    "<a class=\"nav-link\" href=\"admin.php\">管理區</a>"
                    ."</li>";}
                    else{
                      echo"";
                    }
                    ?>
                    <li nav-item me-5>
                      <a href="shop.php" class="nav-link ms-0">商品總覽</a>
                    </li>
                    <li nav-item me-5>
                      <a href="history.php" class="nav-link ms-0">歷史紀錄</a>
                    </li>
                    <li class="nav-item me-5">
                      <!-- <a class="nav-link ms-0" href="form.php">表單</a> -->
                    </li>


              </ul>
                </div>
            </div>
            </div>
        </nav>
        </header>
        <section class="hero-section jarallax d-flex align-items-center justify-content-center padding-medium pb-5" style="background: url(images/hero-img.jpg) no-repeat;">
        <div class="hero-content">
        <div class="container">
        <div class="row">
            <div class="text-center">
            <h1>產品編輯</h1>
            <div class="breadcrumbs">
                <span class="item">
                <a href="index.php">首頁 ></a>
                </span>
                <span class="item">產品編輯</span>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- 新增商品表单 -->
    <div class="shopify-grid padding-large">
        <div class="container">
            <div class="row">
                <main class="col-md-9">
                    <div class="row product-content product-store">
                        <div class="col-md-12 py-3">
                            <form action="update_product.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">商品名稱</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="class" class="form-label">商品類型</label>
                                    <input type="text" class="form-control" id="class" name="class" value="<?php echo $row['class']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">商品描述</label>
                                    <textarea id="description" class="form-control" name="description"><?php echo $row['description']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">商品價格</label>
                                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="product_image" class="form-label">商品圖片</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <img src="picture/<?php echo $row['image']; ?>" alt="Product Image" width="200">
                                </div>
                                <button type="submit" class="btn btn-primary" name="update_product">提交修改</button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>        
        <script src="js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "找不到指定的產品";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "無效的請求";
}
?>