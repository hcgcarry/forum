<?php
if(isset($_POST['submit']) AND $_POST['submit']=="create_categories"){
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

//////////////////////////如果是delete
elseif(isset($_POST['submit']) AND $_POST['submit']=="delete_categories"){
  $table='categories';
  $categories_name=join("','",$_POST);
  $sql = "DELETE  FROM categories WHERE categories_name IN ('$categories_name')";
  Database::get()->getPDOConn()->query($sql);
}

/////////////////////query all exist category
$sql="SELECT categories_name FROM categories";
///這個似乎只能執行一次, 我猜拭去取得categoreisnamearray食材會執行query
$categoriesNameArray=Database::get()->getPDOConn()->query($sql);
/**
 * 載入頁面
 */
$title = 'create categories';
$filename=basename($_SERVER['REQUEST_URI']);
include('view/header/default.php'); // 載入共用的頁首
include('view/body/modify_category.html');  
include('view/footer/default.php'); // 載入共用的頁尾

