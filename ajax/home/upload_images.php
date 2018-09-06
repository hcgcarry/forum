<?php
session_start();
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
UserVeridator::checkLogin();

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt'); // valid extensions
$path = Config::FILE_BASE_URL.'uploads/users/profile/'; // upload directory
$imgSrcPath=Config::DIR_BASE_URL.'uploads/users/profile/';
//$path = 'uploads/'; // upload directory

if ($_FILES['image']) {
	$img = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
	$size=$_FILES["image"]["size"];//上傳的檔案類型。

// get uploaded file's extension
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

// can upload same image using rand function
	$final_image = rand(1000, 1000000) . $img;

// check's valid format
	if (in_array($ext, $valid_extensions) and ($size/(1024*1024)) < 2) {
		$path = $path . strtolower($final_image);
		$imgSrcPath=$imgSrcPath.strtolower($final_image);

		if (move_uploaded_file($tmp, $path)) {


//insert form data in the database
			$table='members';
			$data_array['profile']=$imgSrcPath;
			$memberID=$_SESSION['memberID'];
			Database::get()->update($table,$data_array,'memberID',$memberID);

//echo $insert?'ok':'err';
			echo 'success';
		}
	} else {
		echo 'invalid';
	}
}
$error=Database::get()->getErrorMessage();
logArrayRecoder::errorLog($error);
?>