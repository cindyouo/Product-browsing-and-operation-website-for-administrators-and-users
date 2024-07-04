<?php
session_start();
include('product_backend.php'); // 包含后端代码

// 獲取排序選項
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : '';

// 根據排序選項設置顯示文本
$sort_text = '';
switch ($sort_option) {
    case 'price_asc':
        $sort_text = '價錢(低-高)';
        break;
    case 'price_desc':
        $sort_text = '價錢(高-低)';
        break;
    case 'time_new':
        $sort_text = '時間(最新)';
        break;
    case 'time_old':
        $sort_text = '時間(最舊)';
        break;
    default:
        $sort_text = '默認排序';
        break;
}
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
                            if ($_SESSION["admin"] == "admin_ok") {
                                echo "<li class=\"nav-item\">".
                                "<a class=\"nav-link\" href=\"admin.php\">管理區</a>"
                                ."</li>";
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
                    <div class="filter-shop d-flex flex-wrap justify-content-between">
                        <div class="showing-product">
                            <p><?php echo count($products); ?> 產品 - 當前排序：<?php echo $sort_text; ?></p>
                        </div>
                        <div style="border: 2px solid #000; position: relative; padding: 10px;" class="sort-by">
                            <select id="input-sort" name="sort" class="form-control">
                                <option value="">產品排序</option>
                                <option value="price_asc" >價錢(低-高)</option>
                                <option value="price_desc" >價錢(高-低)</option>
                                <option value="time_new" >時間(最新)</option>
                                <option value="time_old" >時間(最舊)</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row product-content product-store">
                        <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                          <div class="product-wrapper text-center">
                              <a href="product1.php?id=<?php echo $product['id']; ?>">
                                <img src="<?php echo $product['image']; ?>" alt="categories" class="product-image img-fluid">
                              </a>
                              <div class="product-content text-center">
                                  <h5 class="text-uppercase mt-3">
                                    <a href="product1.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                                  </h5>
                                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$<?php echo $product['price']; ?></span></a>
                              </div>
                          </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </main>
                
            </div>
        </div>
    </div>

 
    <script>
    document.getElementById('input-sort').addEventListener('change', function() {
        var sortValue = this.value;
        window.location.href = 'shop.php?sort=' + sortValue;
    });
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
假設我在這邊有點過商品我想回傳到history.php顯示剛剛點過的紀錄
<?php
	session_start();
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

    
    <div id="preloader">
      <div id="loader"></div>
    </div>

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
                <li class="nav-item me-5">
                  <a class="nav-link ms-0" href="index.php">首頁</a>
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

    <section class="hero-section jarallax d-flex align-items-center justify-content-center padding-medium pb-5" style="background: url(images/hero-img.jpg) no-repeat;">
      <div class="hero-content">
        <div class="container">
          <div class="row">
            <div class="text-center">
              <h1>歷史紀錄</h1>
              <div class="breadcrumbs">
                <span class="item">
                  <a href="index.php">首頁 ></a>
                </span>
                <span class="item">歷史紀錄</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- 這裡放程式碼 -->
<script>
// 添加fetch API代码
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.product-wrapper a').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            var productId = this.href.split('id=')[1];
            fetch('add_to_history.php?id=' + productId, {
                method: 'GET',
                credentials: 'same-origin' // Ensure session is properly handled
            })
            .then(response => response.text())
            .then(data => {
                window.location.href = 'product1.php?id=' + productId;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>




    <script>
    function logout() {
        if (confirm("您確定要登出嗎？")) {
            fetch('logout.php', {
                method: 'GET',
                credentials: 'same-origin' // 傳遞 cookie 以確保 session 正確
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
