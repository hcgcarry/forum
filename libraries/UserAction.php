<?php
class UserAction {
    function getResetToken($memberID){
        $data_array['resetComplete'] = 'No';
        $data_array['resetToken'] = md5(rand().time());
        Database::get()->update('members', $data_array, "memberID", $memberID);
        return $data_array['resetToken'];
    }
    function getMemberID($username,$email){
      $table = "members";
      $condition = "username = :username AND email = :email";
      $order_by = "1";
      $fields = "memberID";
      $limit = "LIMIT 1";
      $data_array = array(":username" => $username,":email" => $email);
      $result = Database::get()->query($table, $condition, $order_by, $fields, $limit, $data_array);
      if(isset($result[0]['memberID'])){
        return $result[0]['memberID'];
      }
      else{
        return false;
      }

    }

    function sendResetEmail($resetToken,$email){
        $body = "<p>Someone requested that the password be reset.</p>
        <p>If this was a mistake, just ignore this email and nothing will happen.</p>
        <p>To reset your password, visit the following address: <a href='".Config::BASE_URL."reset/$resetToken'>".Config::BASE_URL."reset/$resetToken</a></p>";
        $mail = new Mail(Config::MAIL_USER_NAME, Config::MAIL_USER_PASSWROD);
        $mail->setFrom(Config::MAIL_FROM, Config::MAIL_FROM_NAME);
        $mail->addAddress($email);
        $mail->subject("Password Reset");
        $mail->body($body);
        $mail->send();
    }

    function redir2login(){
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success("Please check your inbox for a reset link.");
        header('Location: '.Config::BASE_URL.'login');
        exit;
    }
}
