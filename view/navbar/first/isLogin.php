<div class='sticky-top'>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="<?=Config::BASE_URL?>">
    <img src="<?=Config::BASE_URL?>pictures/手機桌布/l.jpg" alt='log'> 
  </a>
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
    <a class="nav-link" href="<?=Config::BASE_URL;?>create_post">發表文章</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>modify_categories">修改類別</a>
    </li>
  </ul>

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>logout">logout</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="#"><?=$_SESSION['username']?></a>
    </li>

  </ul>
</nav>

