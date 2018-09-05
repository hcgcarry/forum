<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if(isset($_POST['index']) and isset($_POST['postOrReplyID'])){


	if($_POST['index'] > 0 ){
		$postOrReplyIDName='replyID';
		$postOrReplyName='replys';
	}
	else{
		$postOrReplyIDName='postID';
		$postOrReplyName='posts';
	}

	$postOrReplyIDValue=$_POST['postOrReplyID'];

	$sql="SELECT
		comments.content,comments.date,members.nickname
	FROM
		comments
	LEFT JOIN members
		ON comments.memberID=members.memberID
	WHERE comments.$postOrReplyIDName=:$postOrReplyIDName
		ORDER BY comments.date DESC
	";
	$data_array[":$postOrReplyIDName"]=$postOrReplyIDValue;

	$result=Database::get()->execute($sql,$data_array);
	///if result not empty
	if(isset($result) and count($result) > 0){
		$resultLen=count($result);
		foreach($result as $key => $item){
			$row=$result[$resultLen-1-$key];
			echo "<div class='row'>

					<div class='col-12 pl-3'>".$row['nickname'].":".$row['content']."</div>
					<div class='col-12 pl-3' style='height:10px;font-size:10px;'>".$row['date']."</div>
				</div>";


		}

	}

}
