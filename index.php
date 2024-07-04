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
                <a class="navbar-brand d-none d-lg-block me-0" href="index.php">
                  <h3><b>商品展示網站</h3></b>
                </a>
    
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
              <h1>首頁</h1>
              <div class="breadcrumbs">
              <?php
                if($_SESSION['check_status']=="login_ok"){
                echo "<h4>".$_SESSION["name"]."你好哇~"."</h4>";
                }
                else{
                echo"";
                }

                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- 這裡放程式碼 -->
<section id="testimonials" class="position-relative padding-large">
      <div class="container">
        <div class="row">
          <div class="offset-md-2 col-md-8">
            <h3 class="text-center mb-5">主題發想</h3>
            <div class="review-content position-relative">
              <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">
                  <div class="swiper-slide text-center d-flex justify-content-center">
                    <div class="review-item">
                      <blockquote class="fs-1 fw-light">我們計劃做一個產品展示平台，主要以公仔為核心內容，並且提供使用者查看產品的歷史紀錄以及推薦相關產品的功能，讓使用者更容易去觀看有興趣的商品。
</blockquote></blockquote></blockquote>
                      <div class="author-detail">
                        <div class="name fw-bold text-uppercase pt-2">組員:鄭郁馨、王建評</div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide text-center d-flex justify-content-center">
                    <div class="review-item">
                      <blockquote class="fs-1 fw-light">網站將分為使用者與管理員兩個角色，管理員擁有兩個權限:1.察看與管理使用者帳號、密碼 2.新增、修改與刪除產品，同時更新前端使用者看到的內容畫面。
</blockquote></blockquote></blockquote>
                      <div class="author-detail">
                        <div class="name fw-bold text-uppercase pt-2">組員:鄭郁馨、王建評</div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide text-center d-flex justify-content-center">
                    <div class="review-item">
                      <blockquote class="fs-1 fw-light">前端使用者可以瀏覽商品總覽所有的商品，並且可以選擇產品排序方式
。點擊特定產品後，將會跳轉至該產品介紹網站，同時此網站會推薦相關類型的其他產品供使用者參考。
</blockquote></blockquote></blockquote>
                      <div class="author-detail">
                        <div class="name fw-bold text-uppercase pt-2">組員:鄭郁馨、王建評</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-buttons text-center mt-5">
              <button class="swiper-prev testimonial-arrow-prev me-2">
                <svg width="41" height="41"><use xlink:href="#arrow-left"></use></svg>
              </button>
              <span>|</span>
              <button class="swiper-next testimonial-arrow-next ms-2">
                <svg width="41" height="41"><use xlink:href="#arrow-right"></use></svg>
              </button>
            </div>
          </div>
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