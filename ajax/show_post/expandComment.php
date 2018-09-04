<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
$postID=$_POST['postID'];

$table='comment';
$data_array['postID']=$postID;
$fields='content,date,memberID';
$order_by='date DESC';
$sql="SELECT
	comments.content,comments.date,members.nickname
FROM
	comments
LEFT JOIN members
	ON comments.memberID=members.memberID
WHERE comments.postID=:postID
	ORDER BY comments.date DESC
";
$data_array[':postID']=$postID;

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

