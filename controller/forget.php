<?php
sanitize::sanitizeArray($_GET);
sanitize::sanitizeArray($_POST);
//if form has been submitted process it
if(isset($_POST['submit']) AND isset($_POST['username']) AND isset($_POST['email'])) 
{
  $email = $_POST['email'];
  $username=$_POST['username'];
  $postVeridator = new PostVeridator();
  $userVeridator = new UserVeridator();
  $userAction = new UserAction();
  $log = new Log();
  if($postVeridator->isValidUserName($username) AND $postVeridator->isValidEmail($email)) { // 信箱是否合法 if($userVeridator->isEmailDuplicate($email)) { // 信箱是否存在
	  try{
        $memberID=$userAction->getMemberID($username,$email);
        $resetToken = $userAction->getResetToken($memberID); // 創建 Token 並存到資料庫
		$userAction->sendResetEmail($resetToken,$email); // 用 Token 組出重置信件並寄出
		if($memberID!=false or $resetToken!=false){
        	$userAction->redir2login(); // 重導向登入頁並顯示成功
		}
        
      }
	  catch(Exception $e){
		  $error[]='there has some thing wrong';
	  }
  }
  else{ 
    $log->warning('WRONG EMAIL or username: ' .$email);
    sleep(rand(1,2));
    $msg->warning('wrong username or email');
  }
}


//if logged in redirect to members page
if(UserVeridator::isLogin(isset($_SESSION['username'])?$_SESSION['username']:'')){
  header('Location: home'); 
  exit();
}
//define page title
$filename=basename($_SERVER['REDIRECT_URL']);
$title =$filename;
include('view/header/default.php'); // 載入共用的頁首
include('view/body/'.$filename.'.php');     // 載入登入用的頁面
include('view/footer/default.php'); // 載入共用的頁尾
