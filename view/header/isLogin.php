<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="<?=Config::BASE_URL;?>style/main.css">
</head>

<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
  <a class="navbar-brand" href="<?=Config::BASE_URL?>">
    <img src="<?=Config::BASE_URL?>pictures/手機桌布/l.jpg" alt='log' style='width:40px;'>
  </a>
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>logout">logout</a>
    </li>
    <li class="nav-item">

    </li>
  </ul>
</nav>

