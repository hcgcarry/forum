<?php
session_start();
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
UserVeridator::checkLogin();
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if(isset($_SESSION['memberID']) and isset($_POST['content']) and !empty($_POST['content']) and strlen($_POST['content']) <50 ){
	$selfDetail=$_POST['content'];
}
else{
	echo '請勿輸入空白or超過兩百個字';
	exit;
}
$table='members';
$data_array['selfDetail']=$selfDetail;

$key_column='memberID';
$id=$_SESSION['memberID'];
Database::get()->update($table,$data_array,$key_column,$id);
$error=logArrayRecoder::errorLog(Database::get()->getErrorMessage());
if(!$error){
	echo $selfDetail;
}
