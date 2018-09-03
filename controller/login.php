<?php
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
if (isset($_SESSION['memberID'])){ 
	header('Location:'.Config::BASE_URL.'home');
	exit;
}
else{
	if(isset($_POST['submit'])) 
	{
	  $error = array(); 
	  $gump = new GUMP();


	  $_POST = $gump->sanitize($_POST); 
	  $validation_rules_array = array(
		  'username'    => 'required|alpha_numeric|max_len,20|min_len,3',
		  'password'    => 'required|max_len,20|min_len,3'
	  );
	  $gump->validation_rules($validation_rules_array);
	  $filter_rules_array = array(
		  'username' => 'trim|sanitize_string',
		  'password' => 'trim',
	  );
	  $gump->filter_rules($filter_rules_array);
	  $validated_data = $gump->run($_POST);

	  if($validated_data === false) {
		$error = $gump->get_readable_errors(false);
	  } 
	  else {
		// basic validation successful
		foreach($validation_rules_array as $key => $val) {
		  ${$key} = $_POST[$key]; // trans to local parameters
		}
		$memberVeridator = new UserVeridator();
		$memberVeridator->loginVerification($username, $password);
		$error = $memberVeridator->getErrorArray();

			//////////////////login success
		if(count($error) == 0){
		  $table = "members";
		  $condition = "username = :username";
		  $order_by = "1";
		  $fields = "*";
		  $limit = "LIMIT 1";
		  $data_array = array(":username" => $username);
		  $result = Database::get()->query($table, $condition, $order_by, $fields, $limit, $data_array);
		  $_SESSION['memberID'] = $result[0]['memberID'];
		  $_SESSION['username'] = $username;
			$_SESSION['nickname'] = $result[0]['nickname'];
			$_SESSION['level'] = $result[0]['level'];
		/////倒回去
		  if(isset($_GET['location']) and !empty($_GET['location'])){
			  header('Location:'.htmlspecialchars($_GET['location']));
			exit;
		  }
		  else{
			header('Location:'.Config::BASE_URL.'home');
			exit;

		  }
		}

		}
	  }
	  
	  if(isset($error) and count($error) > 0){
		  logArrayRecoder::error($error,$msg);
	  }

	$filename=basename($_SERVER['REDIRECT_URL']);
	$title =$filename;
	include('view/header/default.php'); // 載入共用的頁首
	include('view/body/'.$filename.'.php');     // 載入登入用的頁面
	include('view/footer/default.php'); // 載入共用的頁尾
}
	?>

