<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" type="text/css" href="<?=Config::BASE_URL;?>style/main.css">
<link rel="stylesheet" type="text/css" href="style/<?=$filename;?>.css">
</head>
<?php
if(isset($_SESSION['memberID'])){
  include("view/navbar/first/isLogin.php");
  include("view/navbar/second/isLogin.php");
}

else{
  include("view/navbar/first/unLogin.php");
  include("view/navbar/second/unLogin.php");
}

?>
<body>

