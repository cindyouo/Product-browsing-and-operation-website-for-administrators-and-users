<?php
session_start();
$productId = $_GET['id'];
date_default_timezone_set("Asia/Taipei");
$time = date('Y-m-d H:i:s');

// 假设历史记录存储在会话中，实际情况下应存储在数据库中
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// 添加到历史记录
$_SESSION['history'][] = ['id' => $productId, 'time' => $time];

// 返回成功响应
echo 'success';
?>
