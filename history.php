<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>歷史紀錄</title>
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
                        <li class="nav-item me-5">
                            <a class="nav-link ms-0" href="index.php">首頁</a>
                        </li>
                        <?php
                        if ($_SESSION["admin"] == "admin_ok") {
                            echo "<li class=\"nav-item\">" .
                            "<a class=\"nav-link\" href=\"admin.php\">管理區</a>"
                            . "</li>";
                        }
                        ?>
                        <li class="nav-item me-5">
                            <a href="shop.php" class="nav-link ms-0">商品總覽</a>
                        </li>
                        <li>
                            <a href="history.php" class="dropdown-item active fs-5 fw-medium">歷史紀錄</a>
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
<div class="container">
    <h2 class="mt-4">瀏覽歷史紀錄</h2>
    <ul class="list-group mt-3">
        <?php
        if (isset($_SESSION['history'])) {
            foreach ($_SESSION['history'] as $index => $entry) {
                // 假设您的商品数据在一个名为 $products 的数组中
                $product = $products[$entry['id']];
                echo '<li class="list-group-item">';
                echo '    <div class="row">';
                echo '        <div class="col-md-2">';
                echo '            <img src="' . $product['image'] . '" alt="' . $product['name'] . '" class="img-fluid">';
                echo '        </div>';
                echo '        <div class="col-md-8">';
                echo '            <h5>' . $product['name'] . '</h5>';
                echo '            <p>瀏覽時間: ' . $entry['time'] . '</p>';
                echo '        </div>';
                echo '        <div class="col-md-2">';
                echo '            <a href="product1.php?id=' . $entry['id'] . '" class="btn btn-primary">查看詳情</a>';
                echo '            <button class="btn btn-danger" onclick="deleteHistory(' . $index . ')">刪除</button>';
                echo '        </div>';
                echo '    </div>';
                echo '</li>';
            }
        } else {
            echo '<li class="list-group-item">沒有瀏覽歷史記錄。</li>';
        }
        ?>
    </ul>
</div>
<script src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script>
function deleteHistory(index) {
    if (confirm("確定要刪除這條記錄嗎？")) {
        $.ajax({
            url: 'delete_history.php',
            type: 'POST',
            data: {index: index},
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("刪除失敗，請重試");
            }
        });
    }
}
</script>
</body>
</html>
