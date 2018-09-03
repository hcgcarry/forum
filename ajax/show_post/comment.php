<?php

session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if(isset($_POST['content']) and !empty($_POST['content'])) {
	foreach($_POST as $key => $item){
		${$key}=$item;
	}
}

$table='comments';
$data_array['memberID']=$memberID;
$data_array['content']=$content;
$date= date('Y-m-d h:i:s');
$data_array['date']=$date;
$data_array['postID']=$postID;
Database::get()->insert($table,$data_array);

//get error
$error[]=Database::get()->getErrorMessage();
if(isset($error[0][0]) and !empty($error[0][0])){
	$log=new Log();
	foreach($error as $row){
		foreach($row as $item){
			$log->error($item,'../log/error.log');
		}
	}
	
}
else{
	echo $_SESSION['nickname'].': '.$content;
}




