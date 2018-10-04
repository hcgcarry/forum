<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("/var/www/html/forum/vendor/autoload.php"); // 載入 composer


sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if (isset($_SESSION['memberID']) and ! empty($_SESSION['memberID']) and isset($_POST['pointName']) and ! empty($_POST['pointName'])
		and isset($_POST['postOrReplyID']) and ! empty($_POST['postOrReplyID'])) {

	if ($_POST['index'] > 0) {
		$postOrReplyIDName = 'replyID';
		$postOrReplyName = 'replys';
	} else {
		$postOrReplyIDName = 'postID';
		$postOrReplyName = 'posts';
	}

	$postOrReplyIDValue = $_POST['postOrReplyID'];

	$pointName = $_POST['pointName'];
	$memberID = $_SESSION['memberID'];
	if ($pointName == 'goodPoint') {
		$pointName = 'goodPoint';
		$hasGivePoint = 'hasGiveGoodPoint';
	} elseif ($pointName == 'badPoint') {
		$pointName = 'badPoint';
		$hasGivePoint = 'hasGiveBadPoint';
	}
	//判斷有沒有給過point
	$sql = "select $postOrReplyIDName from $hasGivePoint where $postOrReplyIDName=:$postOrReplyIDName and memberID=:memberID";
	$data_array[":$postOrReplyIDName"] = $postOrReplyIDValue;
	$data_array[':memberID'] = $memberID;
	$selectResult = Database::get()->execute($sql, $data_array);
	//如果已經給過讚的話
	if (isset($selectResult[0][0]) and count($selectResult[0][0]) > 0) {
		echo 'hasGivePoint';
	} else {
		//還沒給過讚
		echo 'doNotHasGivePoint';
		//insert into $hasgivepoint
		$table = $hasGivePoint;
		$data_array=array();
		$data_array["$postOrReplyIDName"] = $postOrReplyIDValue;
		$data_array['memberID'] = $memberID;
		Database::get()->insert($table, $data_array);
		$error[] = Database::get()->getErrorMessage();
		//upadte postorreply point
		//init
		$table=$postOrReplyName;
		$data_array=array();
		$data_array[":$postOrReplyIDName"]=$postOrReplyIDValue;
		$sql="update $table set $pointName=$pointName+1 where $postOrReplyIDName=:$postOrReplyIDName";
		Database::get()->execute($sql,$data_array);
		$error[] = Database::get()->getErrorMessage();
	}
	/*
	$data_array = array();
	$sql = "select $hasGivePoint from $postOrReplyName where $postOrReplyIDName=:$postOrReplyIDName";
	$data_array[":$postOrReplyIDName"] = $postOrReplyIDValue;
	$result = Database::get()->execute($sql, $data_array);
	 * 
	 */


	if (isset($error[0][0]) and ! empty($error[0][0])) {
		$log = new Log();
		foreach ($error as $row) {
			foreach ($row as $item) {
				$log->error($item, Config::FILE_BASE_URL . 'log/error.log');
			}
		}
	}
} else {
	exit;
}
?>
