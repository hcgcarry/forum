<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" type="text/css" href="<?=Config::BASE_URL;?>style/default.css">
<link rel="stylesheet" type="text/css" href="style/<?=$filename;?>.css">
</head>
<body>
<?php
  include("view/navbar/first/default.php");
  include("view/navbar/second/default.php");

?>

