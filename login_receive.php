<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="utf-8">
  <title>Agen | Bootstrap Agency Template</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="plugins/venobox/venobox.css">
  <link rel="stylesheet" href="plugins/card-slider/css/style.css">
  <link href="css/style.css" rel="stylesheet">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>

<header class="navigation fixed-top">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-center" id="navigation">
      <ul class="navbar-nav ml-auto">

      </ul>
    </div>
  </nav>
</header>


<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 mx-auto text-center">
        <center>
        <?php
          require_once("dbtools.inc.php");
          header("Content-type: text/html; charset=utf-8");

          // 取得表單資料
          $account = $_POST["account"];
          $password = $_POST["password"];

          // 建立資料連接
          $link = create_connection();

          // 檢查帳號密碼是否正確
          $sql = "SELECT * FROM user Where account = '$account' AND password = '$password'";
          $result = execute_sql($link, "member", $sql);

          $check_status=false;
          $_SESSION["check_status"]="login_not_ok";
          $_SESSION["admin"]="admin_not_ok";

          // 如果帳號密碼錯誤
          if (mysqli_num_rows($result) == 0)
          {

            // 釋放 $result 佔用的記憶體
            mysqli_free_result($result);

            // 關閉資料連接
            mysqli_close($link);

            // 顯示訊息要求使用者輸入正確的帳號密碼
            echo "<script>
            alert('登入失敗');
            window.location.href = 'login.php';
            </script>";

          }

          // 如果帳號密碼正確
          else
          {
            // 取得 id 欄位
            $id = mysqli_fetch_object($result)->id;

            // 釋放 $result 佔用的記憶體
            mysqli_free_result($result);

            // 關閉資料連接
            mysqli_close($link);

            // 將使用者資料加入 cookies
            setcookie("id", $id);
            setcookie("passed", "TRUE");

            $check_status=true;
            $_SESSION["check_status"]="login_ok";
            $_SESSION["name"]=$_POST['account'];
            if($_POST['account']=="ccc"){
                $_SESSION["name"]="管理員大大";
                $_SESSION["admin"]="admin_ok";
            }
          }
          if($_SESSION["check_status"]=="login_ok"){
            if($_SESSION["admin"]=="admin_ok"){
              echo "<script>
              alert('管理員登入成功');
              window.location.href = 'admin.php';
              </script>";
      
            } else {
              echo "<script>
              alert('登入成功');
              window.location.href = 'index.php';
              </script>";
    
            }
          }
        ?>

        <br>
        </center>
      </div>
    </div>
  </div>
</section>

<script src="plugins/jQuery/jquery.min.js"></script>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/slick/slick.min.js"></script>
<script src="plugins/venobox/venobox.min.js"></script>
<script src="plugins/shuffle/shuffle.min.js"></script>
<script src="plugins/counto/apear.js"></script>
<script src="plugins/counto/counTo.js"></script>
<script src="plugins/card-slider/js/card-slider-min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="plugins/google-map/gmap.js"></script>
<script src="js/script.js"></script>

</body>
</html>
