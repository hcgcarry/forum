<?php

$filename=basename($_SERVER['REQUEST_URI']);
include('view/header/default.php'); // 載入共用的頁首
include('view/body/index.html');     // 載入登入用的頁面
include('view/footer/default.php'); // 載入共用的頁尾
