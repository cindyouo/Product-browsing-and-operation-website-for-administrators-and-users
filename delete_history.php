<?php
session_start();

if (isset($_POST['index'])) {
    $index = $_POST['index'];

    if (isset($_SESSION['history'][$index])) {
        unset($_SESSION['history'][$index]);
        // 重新排列索引
        $_SESSION['history'] = array_values($_SESSION['history']);
    }
}
?>
