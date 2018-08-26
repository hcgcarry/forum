<?php
if(isset($_POST['submit'])){
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 

  $validation_rules_array = array(
    'categories_name'    => 'required'
  );
  $gump->validation_rules($validation_rules_array);

  $filter_rules_array = array(
    'categories_name' => 'trim|sanitize_string',
    'categories_describtion' => 'trim|sanitize_string'
  );
  $gump->filter_rules($filter_rules_array);

  $validated_data = $gump->run($_POST);

  if($validated_data === false) {
    $error = $gump->get_readable_errors(false);
  } 

  else {
    
    // validation successful
    // 將_POST['username'] 復職給 $username 以此類推
    foreach($validation_rules_array as $key => $val) {
      ${$key} = $_POST[$key];
    }
		$table = 'categories';
		$condition = 'categories_name = :categories_name';
		$order_by = '1';
		$fields = 'categories_name';
		$limit = '1';
		$data_array['categories_name'] = $categories_name;
		$result = Database::get()->query($table, $condition, $order_by, $fields, $limit, $data_array);
    ///判斷是否重複
    if(!isset($result[0]['categories_name']) OR empty($result[0]['categories_name'])){
        $data_array['categories_describtion']=$_POST['categories_describtion'];
        Database::get()->insert($table,$data_array);
    }
    ////repleat
    else {
      $error[]='categories is exist';
    
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
}

/**
 * 載入頁面
 */
//define page title
$title = 'create categories';
include('view/header/default.php'); // 載入共用的頁首
include('view/body/create_category.php');  // 載入註冊用的表單
include('view/footer/default.php'); // 載入共用的頁尾
