<?php
session_start();
?>
<?php
  // 檢查 cookie 中的 passed 變數是否等於 TRUE
  $passed = $_COOKIE["passed"];

  // 如果 cookie 中的 passed 變數不等於 TRUE
  // 表示尚未登入網站，將使用者導向首頁 index.php
  if ($passed != "TRUE")
  {
    header("location:index.php");
    exit();
  }

  // 如果 cookie 中的 passed 變數等於 TRUE
  // 表示已經登入網站，取得使用者資料
  else
  {
    require_once("dbtools.inc.php");

    $id = $_COOKIE["id"];

    // 建立資料連接
    $link = create_connection();

    // 執行 SELECT 陳述式取得使用者資料
    $sql = "SELECT * FROM user Where id = $id";
    $result = execute_sql($link, "member", $sql);

    $row = mysqli_fetch_assoc($result);
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
    <script type="text/javascript">
      function check_data()
      {
        if (document.myForm.password.value.length == 0)
        {
          alert("「使用者密碼」一定要填寫哦...");
          return false;
        }
        if (document.myForm.password.value.length > 10)
        {
          alert("「使用者密碼」不可以超過 10 個字元哦...");
          return false;
        }
        if (document.myForm.re_password.value.length == 0)
        {
          alert("「密碼確認」欄位忘了填哦...");
          return false;
        }
        if (document.myForm.password.value != document.myForm.re_password.value)
        {
          alert("「密碼確認」欄位與「使用者密碼」欄位一定要相同...");
          return false;
        }
        if (document.myForm.name.value.length == 0)
        {
          alert("您一定要留下真實姓名哦！");
          return false;
        }
        if (document.myForm.year.value.length == 0)
        {
          alert("您忘了填「出生年」欄位了...");
          return false;
        }
        if (document.myForm.month.value.length == 0)
        {
          alert("您忘了填「出生月」欄位了...");
          return false;
        }
        if (document.myForm.month.value > 12 | document.myForm.month.value < 1)
        {
          alert("「出生月」應該介於 1-12 之間哦！");
          return false;
        }
        if (document.myForm.day.value.length == 0)
        {
          alert("您忘了填「出生日」欄位了...");
          return false;
        }
        if (document.myForm.month.value == 2 & document.myForm.day.value > 29)
        {
          alert("二月只有 28 天，最多 29 天");
          return false;
        }
        if (document.myForm.month.value == 4 | document.myForm.month.value == 6
          | document.myForm.month.value == 9 | document.myForm.month.value == 11)
        {
          if (document.myForm.day.value > 30)
          {
            alert("4 月、6 月、9 月、11 月只有 30 天哦！");
            return false;
          }
        }
        else
        {
          if (document.myForm.day.value > 31)
          {
            alert("1 月、3 月、5 月、7 月、8 月、10 月、12 月只有 31 天哦！");
            return false;
          }
        }
        if (document.myForm.day.value > 31 | document.myForm.day.value < 1)
        {
          alert("出生日應該在 1-31 之間");
          return false;
        }
        myForm.submit();
      }
    </script>

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
                <span class="item">商品總覽</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- 這裡放程式碼 -->

<section class="login-tabs padding-large">
      <div class="container">
        <div class="row">
          <div class="tabs-listing">
            <nav>
              <div class="nav nav-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                <h4>個人資料</h4>
              </div>
            </nav>
            <form name="myForm" method="post" action="update.php" >
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade active show" id="nav-sign-in" role="tabpanel" aria-labelledby="nav-sign-in-tab">
                <div class="form-group py-3">
                  <label for="sign-in">帳號 *:</label>
                  <?php echo $row["account"] ?>
                </div>
                <div class="form-group py-3">
                  <label for="sign-in">密碼 *:</label>
                  <input type="password" name="password" size="15" value="<?php echo $row["password"] ?>">
                </div>
                <div class="form-group py-3">
                  <label for="sign-in">密碼確認 *:</label>
                  <input type="password" name="re_password" size="15" value="<?php echo $row["password"] ?>">
                </div>
                <tr bgcolor="#D7B8F3">
                  <td align="right">*姓名：</td>
                  <td><input type="text" name="name" size="8" value="<?php echo $row["name"] ?>"></td>
                </tr><br>
                <tr bgcolor="#D7B8F3">
                  <td align="right">*性別：</td>
                  <td>
                    <input type="radio" name="sex" value="男" checked>男
                    <input type="radio" name="sex" value="女">女
                  </td>
                </tr><br>
                <tr bgcolor="#D7B8F3">
                  <td align="right">*生日：</td>
                  <td>民國
                    <input type="text" name="year" size="2" value="<?php echo $row["year"] ?>">年
                    <input type="text" name="month" size="2" value="<?php echo $row["month"] ?>">月
                    <input type="text" name="day" size="2" value="<?php echo $row["day"] ?>">日
                  </td>
                </tr>
                <div class="form-group py-3">
                  <label for="sign-in">電話：</label>
                  <input type="text" name="telephone" size="20" value="<?php echo $row["telephone"] ?>">
                </div>
                <div class="form-group py-3">
                  <label for="sign-in">地址：</label>
                  <input type="text" name="address" size="45" value="<?php echo $row["address"] ?>">
                </div>
                <div class="form-group py-3">
                  <label for="sign-in">G-mail：</label>
                  <input type="text" name="email" size="30" value="<?php echo $row["email"] ?>">
                </div>
                <div class="form-group py-3">
                  <label for="sign-in">備註：</label>
                  <textarea name="comment" rows="4" cols="45"><?php echo $row["comment"] ?></textarea>
                </div>



                <input type="submit" value="修改資料" name="submit" class="btn btn-dark w-100 my-3"onClick="check_data()">
              </div>
              </form>
             
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
<?php
    // 釋放資源及關閉資料連接
    mysqli_free_result($result);
    mysqli_close($link);
  }
?>