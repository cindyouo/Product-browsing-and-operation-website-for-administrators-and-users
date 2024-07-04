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

if (isset($_GET['id'])) {
  $product_id = $_GET['id'];

  // Fetch the class of the current product
  $sql = "SELECT class FROM products WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_class = $row['class'];

    // Fetch up to 4 recommended products from the same class
    $sql_recommend = "SELECT id, name, price, image FROM products WHERE class = ? AND id != ? LIMIT 4";
    $stmt_recommend = $conn->prepare($sql_recommend);
    $stmt_recommend->bind_param("si", $product_class, $product_id);
    $stmt_recommend->execute();
    $result_recommend = $stmt_recommend->get_result();

    $recommended_products = [];
    while ($row_recommend = $result_recommend->fetch_assoc()) {
      $recommended_products[] = $row_recommend;
    }
  }

  $stmt->close();
  $stmt_recommend->close();
  
  // 記錄點擊歷史
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_history = "INSERT INTO history (user_id, product_id) VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE click_count = click_count + 1, last_click_time = CURRENT_TIMESTAMP";
    $stmt_history = $conn->prepare($sql_history);
    $stmt_history->bind_param("ii", $user_id, $product_id);
    $stmt_history->execute();
    $stmt_history->close();
  }
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
              <h1>商品總覽</h1>
              <div class="breadcrumbs">
                <span class="item">
                  <a href="index.php">首頁 ></a>
                </span>
                <?php
                  if (isset($_GET['id'])) {
                    $product_id = $_GET['id'];
                    
                    // Find the product details from $products array (or database query)
                    foreach ($products as $product) {
                        if ($product['id'] == $product_id) {
                          echo'<span class="item">';
                          echo '<p class="card-text">' . $product['name'] . '</p>';
                          echo'</span>';
                        }
                      }      
                    }   
                    ?> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- 這裡放程式碼 -->

<section class="single-product padding-large">
      <div class="container">
        <div class="row g-md-5">
          <div class="col-lg-6">
            <div class="row product-preview">
              <div class="swiper thumb-swiper col-3">
                <div class="swiper-wrapper d-flex flex-wrap align-content-start">
                  <!-- <div class="swiper-slide">
                    <img src="picture/pic1.jpg" alt="" class="img-fluid">
                  </div> 多張圖片可放-->

                </div>
              </div>
              <div class="swiper large-swiper overflow-hidden col-9">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                <?php    
                  if (isset($_GET['id'])) {
                        $product_id = $_GET['id'];
                        
                        // Find the product details from $products array (or database query)
                        foreach ($products as $product) {
                          if ($product['id'] == $product_id) {

                            echo '<img src="' . $product['image'] . '" class="card-img-top" alt="Product Image">';
                          }
                        }
                  }
                  ?>       
                  </div>


                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="product-info px-0 px-lg-3">
              <div class="element-header">
              <?php
              if (isset($_GET['id'])) {
                        $product_id = $_GET['id'];
                        
                        // Find the product details from $products array (or database query)
                        foreach ($products as $product) {
                          if ($product['id'] == $product_id) {

                            echo '<h4 class="card-title">' . $product['name'] . '</h4>';
                          }
                        }
                  }
                  ?>  
                <div class="rating-container d-flex align-items-center my-3">
                  <div class="rating" data-rating="1" onclick=rate(1)>
                    <svg class="bi" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  </div>
                  <div class="rating" data-rating="1" onclick=rate(1)>
                    <svg class="bi" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  </div>
                  <div class="rating" data-rating="1" onclick=rate(1)>
                    <svg class="bi" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  </div>
                  <div class="rating" data-rating="1" onclick=rate(1)>
                    <svg class="bi" width="16" height="16"><use xlink:href="#star-half"></use></svg>
                  </div>
                  <div class="rating" data-rating="1" onclick=rate(1)>
                    <svg class="bi" width="16" height="16"><use xlink:href="#star-empty"></use></svg>
                  </div>
                  
                </div>
              </div>
              <div class="product-price my-3">

              <?php
              if (isset($_GET['id'])) {
                        $product_id = $_GET['id'];
                        
                        // Find the product details from $products array (or database query)
                        foreach ($products as $product) {
                          if ($product['id'] == $product_id) {

                            echo '<span class="fs-1 text-primary">$' . $product['price'] . '</span>';
                          }
                        }
                  }
                  ?>  
    
              </div>
              <?php
              if (isset($_GET['id'])) {
                        $product_id = $_GET['id'];
                        
                        // Find the product details from $products array (or database query)
                        foreach ($products as $product) {
                          if ($product['id'] == $product_id) {
                            echo '<p class="card-text">' . $product['description'] . '</p>';
                          }
                        }
                  }
                  ?>  
              <hr>
            </div>
        </div>
      </div>
    </section>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section id="products" class="padding-large">
      <div class="container">
      <section id="products" class="padding-large">
  <div class="container">
    <div class="display-header d-flex flex-wrap justify-content-between pb-1">
      <b><h4 class="display-4">推薦產品</h4></b>
      <div class="btn-right d-flex flex-wrap align-items-center">
        <a href="shop.php" class="btn me-5">Go to shop</a>
      </div>
    </div>






    <div class="row">
      <?php
      if (!empty($recommended_products)) {
        foreach ($recommended_products as $product) {
          echo '<div class="col-md-3 py-3 product-item link-effect">';
          echo '  <div class="image-holder position-relative">';
          echo '    <a href="product1.php?id=' . $product['id'] . '">';
          echo '      <img src="' . $product['image'] . '" alt="' . $product['name'] . '" class="product-image img-fluid">';
          echo '    </a>';
          echo '    <div class="product-content text-center">';
          echo '      <h5 class="text-uppercase mt-3">';
          echo '        <a href="product1.php?id=' . $product['id'] . '">' . $product['name'] . '</a>';
          echo '      </h5>';
          echo '      <a href="cart.php?id=' . $product['id'] . '" class="text-decoration-none" data-after="Add to cart"><span>$' . $product['price'] . '</span></a>';
          echo '    </div>';
          echo '  </div>';
          echo '</div>';
        }
      } else {
        echo '<p>No recommended products available.</p>';
      }
      ?>
    </div>
  </div>
</section>





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