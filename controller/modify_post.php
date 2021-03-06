<?php
UserVeridator::checkLogin();
sanitize::sanitizeArray($_GET);
if(isset($_GET['postID'])){
	$postOrReplyName='posts';
	$postOrReplyIDName='postID';
	$postOrReplyIDValue=$_GET['postID'];
} 
else if (isset($_GET['replyID'])){
	$postOrReplyName='replys';
	$postOrReplyIDName='replyID';
	$postOrReplyIDValue=$_GET['replyID'];
}
$sql="select content,memberID from $postOrReplyName where $postOrReplyIDName=:$postOrReplyIDName" ;
$data_array["$postOrReplyIDName"]=$postOrReplyIDValue;
$result=Database::get()->execute($sql,$data_array);
if(isset($result[0]) and count($result[0]) > 0){
	foreach($result[0] as $key => $value){
		${$key}=$value;
	}
}
if($memberID!=$_SESSION['memberID']){
	exit;
}
?>


<?php
if(isset($_GET['postID']) and !empty($_GET['postID'])){
	$postID= htmlspecialchars($_GET['postID']);
}
if(isset($_POST['submit'])){
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 

  $validation_rules_array = array(
    'content' => 'required|max_len,5000|min_len,1'
  );
$gump->validation_rules($validation_rules_array);

  $filter_rules_array = array(
    'content' => 'sanitize_string'
  );
  $gump->filter_rules($filter_rules_array);

  $validated_data = $gump->run($_POST);

  if($validated_data === false) {
    $error = $gump->get_readable_errors(false);
  } 
  ///////////////沒出錯的話

  else {
    
    // validation successful
    // 將_POST['username'] 復職給 $username 以此類推
    foreach($validation_rules_array as $key => $val) {
      ${$key} = $_POST[$key];
    }
	$data_array=array();
      $table=$postOrReplyName;
      $data_array['content']=$content;
      $date= date('Y-m-d h:i:s');
      $data_array['date']=$date;
	  $data_array['hasEdit']=1;
	  print_r($data_array);

      Database::get()->update($table,$data_array,$postOrReplyIDName,$postOrReplyIDValue);
    
  } 

    ///final error convert to flash session

  if(isset($error) AND count($error) > 0){
    foreach( $error as $e) {
      //msg is flash session
        $msg->error($e);
    }
  }
  $databaseError=Database::get()->getErrorMessage();
  if(isset($databaseError) and count($databaseError)>0){
    foreach($databaseError as $e){
		$msg->error($e);
    
    }
  }
  if(!$msg->hasMessages()){
    $msg->success('回覆發表成功');
	  if(isset($_GET['location']) and !empty($_GET['location'])){
		  header('Location:'.htmlspecialchars($_GET['location']));
		exit;
	  }
  }
}


/**
 * 載入頁面
 */
$filename=basename($_SERVER['REQUEST_URI']);
$title=$filename;
include('view/header/default.php'); // 載入共用的頁首
include('view/body/create_reply.php');  //借用create_reply的
include('view/footer/default.php'); // 載入共用的頁尾







