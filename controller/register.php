<?php
if(isset($_POST['submit'])) 
{
  $gump = new GUMP();

  $_POST = $gump->sanitize($_POST); 

  $validation_rules_array = array(
    'nickname'    => 'required|alpha_numeric|max_len,30|min_len,1',
    'username'    => 'required|alpha_numeric|max_len,20|min_len,3',
    'email'       => 'required|valid_email',
    'password'    => 'required|max_len,20|min_len,3',
    'passwordConfirm' => 'required'
  );
  $gump->validation_rules($validation_rules_array);

  $filter_rules_array = array(
    'nickname' => 'trim|sanitize_string',
    'username' => 'trim|sanitize_string',
    'email'    => 'trim|sanitize_email',
    'password' => 'trim',
    'passwordConfirm' => 'trim'
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
    $memberVeridator = new UserVeridator();
    $memberVeridator->isPasswordMatch($password, $passwordConfirm);
    $memberVeridator->isUsernameDuplicate($username);
    $memberVeridator->isEmailDuplicate($email);
    $error = $memberVeridator->getErrorArray();
  } 
  //if no errors have been created carry on
  if(count($error) == 0)
  {
    //hash the password
    $passwordObject = new Password();
    $hashedpassword = $passwordObject->password_hash($password, PASSWORD_BCRYPT);


    //create the random activasion code
    //信箱認証用的
    $activasion = md5(uniqid(rand(),true));
    $member_signup_date = date('Y-m-d h:i:s');
    echo 'member_signup_date:  '.$member_signup_date;

    try {
      // 新增到資料庫
      $table = 'members';
      $data_array = array(
        'nickname' => $nickname,
        'username' => $username,
        'password' => $hashedpassword,
        'email' => $email,
        'member_signup_date' => $member_signup_date,
        'active' => $activasion
      );
      Database::get()->insert($table, $data_array);
      $id = Database::get()->getLastId();

      if(isset($id) AND !empty($id) AND is_numeric($id)){
        // 寄出認證信
        $subject = "Registration Confirmation";
        $body = "<p>Thank you for registering at demo site.</p>
        <p>To activate your account, please click on this link: <a href='".Config::BASE_URL."activate/$id/$activasion'>".Config::BASE_URL."activate/$id/$activasion</a></p>
        <p>Regards Site Admin</p>";

        $mail = new Mail(Config::MAIL_USER_NAME, Config::MAIL_USER_PASSWROD);
        $mail->setFrom(Config::MAIL_FROM, Config::MAIL_FROM_NAME);
        $mail->addAddress($email);
        $mail->subject($subject);
        $mail->body($body);
        if($mail->send()){
        $msg->success('Registration successful, please check your email to activate your account.');
        }else{
        $msg->error('Sorry, unable to send Email.');
        }
      }
      else{
        $error[] = "Registration Error Occur on Database.";
      }
    //else catch the exception and show the error.
    }
    catch(PDOException $e) {
        $error[] = $e->getMessage();
    }
  }
  if(isset($error) AND count($error) > 0){
    foreach( $error as $e) {
      //msg is flash session
        $msg->error($e);
    }
  }
  else{
    header('Location: ' . Config::BASE_URL);
    exit;
  }
}
/**
 * 載入頁面
 */
//define page title
$title = 'Register';
$filename=basename($_SERVER['REQUEST_URI']);
include('view/header/default.php'); // 載入共用的頁首
include('view/body/register.html');  // 載入註冊用的表單
include('view/footer/default.php'); // 載入共用的頁尾
