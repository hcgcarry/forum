<?php
date_default_timezone_set('Asia/Taipei');

if(isset($_POST))$_POST = GUMP::xss_clean($_POST);

$route = new Router(Request::uri()); //搭配 .htaccess 排除資料夾名稱後解析 URL

//這是一個很神奇的東西 ，flashsession 其直會再儲存後會再第一次取其直之後失笑
$msg = new \Plasticbrain\FlashMessages\FlashMessages();


