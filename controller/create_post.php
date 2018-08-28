<?php
if(!isset($_SESSION['memberID']) ){
  header('Location: '.Config::BASE_URL.'login');
}
if(isset($_POST['submit'])){
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 

  $validation_rules_array = array(
    'categoriesID' => 'required',
    'topic'    => 'required',
    'content' => 'required|max_len,300|min_len,1'
  );
  $gump->validation_rules($validation_rules_array);

  $filter_rules_array = array(
    'categoriesID' => 'trim|sanitize_string',
    'topic' => 'trim|sanitize_string',
    'content' => 'trim|sanitize_string'
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
		$table = 'categories';
		$condition = 'categoriesID = :categoriesID';
		$order_by = '1';
		$fields = 'categoriesID';
		$limit = '1';
		$data_array['categoriesID'] = $categoriesID;
		$result = Database::get()->query($table, $condition, $order_by, $fields, $limit, $data_array);
    ///判斷是否重複
    if(!isset($result[0]['categoriesID']) OR empty($result[0]['categoriesID'])){
      $error[]='categories is not exist';
    }
    ////repleat
    else {
      $table='posts';
      $data_array['memberID']=$_SESSION['memberID'];
      $data_array['topic']=$topic;
      $data_array['content']=$content;
      $date= date('Y-m-d h:i:s');
      $data_array['date']=$date;
      Database::get()->insert($table,$data_array);
    
    }

  } 

    ///final error convert to flash session

  if(isset($error) AND count($error) > 0){
    foreach( $error as $e) {
      //msg is flash session
        $msg->error($e);
    }
  }
  $databaseError=Database::get()->getErrorMessage();
  if(count($databaseError)>0){
    foreach($databaseError as $e){
    $msg->error($e);
    
    }
  }
  if(!$msg->hasMessages()){
    $msg->success('文章發表成功');
  }
}

////////////////再create post的葉面提供類別的選單
$sql="SELECT categories_name,categoriesID FROM categories";
///這個似乎只能執行一次, 我猜拭去取得categoreisnamearray食材會執行query
$categoriesArray=Database::get()->execute($sql);


/**
 * 載入頁面
 */
$title = 'create post';
$filename=basename($_SERVER['REQUEST_URI']);
include('view/header/default.php'); // 載入共用的頁首
include('view/body/create_post.php');  
include('view/footer/default.php'); // 載入共用的頁尾


