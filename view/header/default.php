<?php
if(isset($_SESSION['memberID'])){
  include("view/header/isLogin.php");
}

else{
  include("view/header/unLogin.php");
}

