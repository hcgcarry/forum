<?php
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
      try {
        $memberID=$userAction->getMemberID($username,$email);
        echo 'memberid: '.$memberID;
        echo 'username: '.$username;
        echo 'email: '.$email;
        $resetToken = $userAction->getResetToken($memberID); // 創建 Token 並存到資料庫
        $userAction->sendResetEmail($resetToken,$email); // 用 Token 組出重置信件並寄出
        
        $userAction->redir2login(); // 重導向登入頁並顯示成功
      } 
      catch(PDOException $e) {
        $error[] = $e->getMessage();
        $log->error(__FILE__, json_encode($error));
        
      }
    }
  else{ // 不存在就假裝成功, 避免被試出會員信箱
    $log->warning(__FILE__, 'WRONG EMAIL or username: ' .$email);
    sleep(rand(1,2));
    $msg->error('wrong username or email');
  }
} 


//if logged in redirect to members page
if(UserVeridator::isLogin(isset($_SESSION['username'])?$_SESSION['username']:'')){
  header('Location: home'); 
  exit();
}
//define page title
$title = 'Forget';
$filename=basename($_SERVER['REQUEST_URI']);
include('view/header/default.php'); // 載入共用的頁首
include('view/body/forget.html');    // 載入忘記密碼的頁面
include('view/footer/default.php'); // 載入共用的頁尾
