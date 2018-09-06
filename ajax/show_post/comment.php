<?php

//create comment
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
UserVeridator::checkLogin();

sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if(!isset($_POST['content']) or empty($_POST['content'])){
	echo '請輸入內容';
	exit;
}
else if (strlen($_POST['content']) > 100){
	echo '文長不可大於100';
}
	
else{
	foreach($_POST as $key => $item){
		${$key}=$item;
	}


	if($_POST['index'] > 0 ){
		$postOrReplyIDName='replyID';
		$postOrReplyName='replys';
	}
	else{
		$postOrReplyIDName='postID';
		$postOrReplyName='posts';
	}
	$memberID=$_SESSION['memberID'];
	$postOrReplyIDValue=$_POST['postOrReplyID'];


	$table='comments';
	$data_array['memberID']=$memberID;
	$data_array['content']=$content;
	$date= date('Y-m-d h:i:s');
	$data_array['date']=$date;
	$data_array["$postOrReplyIDName"]=$postOrReplyIDValue;
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



}

