<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer

sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
print_r($_POST);
if(isset($_POST['pointName']) and !empty($_POST['pointName']) 
and isset($_POST['postID']) and !empty($_POST['postID'])){
	$postID=$_POST['postID'];
	$pointName=$_POST['pointName'];
	$memberID=($_POST['memberID']);
	if($pointName=='goodPoint'){
		$pointName='goodPoint';
		$hasGivePoint='hasGiveGoodPoint';
	}
	elseif($pointName=='badPoint'){
		$pointName='badPoint';
		$hasGivePoint='hasGiveBadPoint';
	}
	//判斷有沒有給過point
	$sql="select $hasGivePoint from posts where postID=:postID and json_search($hasGivePoint,'one',:memberID) is not null;";
	$data_array[':postID']=$postID;
	$data_array[':memberID']=$memberID;
	$selectResult=Database::get()->execute($sql,$data_array);
	print_r($selectResult);
		//如果已經給過讚的話
	if(isset($selectResult[0][0]) and count($selectResult[0][0]) >0 ){
				echo '動作復原';
				$sql="update 
						posts 
					set 
						$pointName=$pointName-1,$hasGivePoint=JSON_REMOVE($hasGivePoint,replace(json_search($hasGivePoint,'one',
							:memberID ),'\"',''))
					WHERE postID=:postID;
						";
				$data_array[':memberID']=$memberID;
				Database::get()->execute($sql,$data_array);
	}
	else{
		echo '動作成功!!!';
		$sql="update posts set $pointName=$pointName+1,$hasGivePoint=JSON_ARRAY_APPEND($hasGivePoint,'$',:memberID ) where postID=:postID";

		$data_array[':postID']=$postID;
		$data_array[':memberID']=$memberID;
		Database::get()->execute($sql,$data_array);

	}
	$data_array=array();
	$sql="select $hasGivePoint from posts where postID=:postID" ;
	$data_array[':postID']=$postID;
	$result=Database::get()->execute($sql,$data_array);
	print_r($result);
	



	$error[]=Database::get()->getErrorMessage();
	if(isset($error[0][0]) and !empty($error[0][0])){
		$log=new Log();
		foreach($error as $row){
			foreach($row as $item){
				$log->error($item,'../log/error.log');
			}
		}
		
	}


}
?>
