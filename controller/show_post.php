<?php
$filename=basename($_SERVER['REDIRECT_URL']);
$title =$filename;
include('view/header/default.php'); // 載入共用的頁首
include('view/body/'.$filename.'.php');     // 載入登入用的頁面
include('view/footer/show_post.php'); // 載入共用的頁尾
?>