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

$user_id = $_SESSION['user_id'];

$sql = "SELECT p.id, p.name, p.price, p.image, h.click_count FROM history h
        JOIN products p ON h.product_id = p.id
        WHERE h.user_id = ?
        ORDER BY h.last_click_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>歷史紀錄</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <header id="header" class="site-header">
    <!-- Your existing header code -->
  </header>

  <section class="hero-section jarallax d-flex align-items-center justify-content-center padding-medium pb-5">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>歷史紀錄</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="index.html">Home</a>
              </span>
              <span class="separator"> > </span>
              <span class="item current">歷史紀錄</span>
            </div>
          </div>
        </div>

        <div class="row">
          <?php foreach ($history as $item): ?>
          <div class="col-lg-3 col-md-6">
            <div class="product-item">
              <div class="product-thumb">
                <a href="product1.php?id=<?php echo $item['id']; ?>">
                  <img src="<?php echo $item['image']; ?>" alt="">
                </a>
              </div>
              <div class="product-info">
                <h4 class="product-title">
                  <a href="product1.php?id=<?php echo $item['id']; ?>">
                    <?php echo $item['name']; ?>
                  </a>
                </h4>
                <div class="product-price">
                  $<?php echo $item['price']; ?>
                </div>
                <div class="product-click-count">
                  點擊次數: <?php echo $item['click_count']; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <script src="js/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="js/plugins.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
</body>
</html>