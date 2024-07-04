<?php
session_start();
include('product_backend.php'); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>資料庫應用</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
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
                                            <!-- <a type="submit" class="nav-link me-0" href="#">搜尋</a> -->
                                        </form>
                                    </div>
                                </li>
                                <?php
                                        if ($_SESSION['check_status'] == "login_ok") {
                                            echo "<li class=\"nav-item\">" .
                                            "<a href=\"modify.php\"><Img Src=\"person.png\"width=50dp ></a>"
                                            . "</li>";
                                            echo "<li class=\"nav-item\">" .
                                            "<a class=\"nav-link\" href=\"#\" onclick=\"logout()\">登出</a>"
                                            . "</li>";
                                        } else {
                                            echo "<li class=\"nav-item\">" .
                                            "<a class=\"nav-link\" href=\"login.php\">登入</a>"
                                            . "</li>";
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
                        <h1>商品總覽</h1>
                        <div class="breadcrumbs">
                            <span class="item">
                                <a href="index.php">首頁 ></a>
                            </span>
                            <span class="item">商品總覽</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="shopify-grid padding-large">
        <div class="container">
            <div class="row">
                <main class="col-md-9">

                    <!-- 新增商品表单 -->
                    <div class="row product-content product-store">
                        <div class="col-md-12 py-3">
                            <form action="product_backend.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">商品名稱</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">商品類型</label>
                                    <input type="text" class="form-control" id="class" name="class" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">商品描述</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">商品價格</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_image" class="form-label">商品圖片</label>
                                    <input type="file" class="form-control" id="product_image" name="product_image">
                                </div>
                                <button type="submit" class="btn btn-primary" name="add_product">新增商品</button>
                            </form>
                        </div>
                    </div>
 
                </main>
            </div>
        </div>
    </div>
    <script>
    function logout() {
        if (confirm("您确定要登出吗？")) {
            fetch('logout.php', {
                method: 'GET',
                credentials: 'same-origin' // 传递 cookie 以确保 session 正确
            })
            .then(response => response.text())
            .then(data => {
                alert("登出成功");
                setTimeout(() => {
                    window.location.href = 'index.php';
                });
            })
            .catch(error => console.error('Error:', error));
        }
    }
    </script>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>