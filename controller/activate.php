<?php
$data_array = array();
$data_array['memberID'] = $route->getParameter(2);    
$data_array['active'] = $route->getParameter(3);    

$gump = new GUMP();
$data_array = $gump->sanitize($data_array); 
$validation_rules_array = array(
  'memberID'    => 'required|integer',
  'active'    => 'required|exact_len,32'
);
$gump->validation_rules($validation_rules_array);

$filter_rules_array = array(
  'memberID' => 'trim',
  'active' => 'trim',
);
$gump->filter_rules($filter_rules_array);
$validated_data = $gump->run($data_array);


if($validated_data === false) {
  $error = $gump->get_readable_errors(false);
  $msg->error($error);
  header('Location: '.Config::BASE_URL.'login');
  exit;
} 

else {
  foreach($validation_rules_array as $key => $val) {
    ${$key} = $data_array[$key];
  }
  $userVeridator = new UserVeridator();
  if($userVeridator->isReady2Active($memberID, $active)){
    $data_array = array();
    $data_array['active'] = "Yes";
    Database::get()->update("members", $data_array, "memberID", $memberID); 
    $msg->success("Your account is now active you may now log in.");
    header('Location: '.Config::BASE_URL.'login');
    exit;
  }
  //之後再做一個判斷active 狀態是否為yes然後返回帳號已經是active的通知 目前是直接返回you account not be activated
  else{
    $msg->error("Your account could not be activated.");
    echo $userVeridator->isReady2Active($memberID, $active);
    header('Location: '.Config::BASE_URL.'login');
    exit;
  }
}
