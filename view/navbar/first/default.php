<div class='sticky-top'>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="<?=Config::BASE_URL?>">
    <img src="<?=Config::BASE_URL?>pictures/手機桌布/l.jpg" alt='log'> 
  <span class='sitename'>wryyy替身使者論壇</span>
  </a>
  <ul class="navbar-nav mr-auto">

  </ul>

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>logout">logout</a>
    </li>

    <?php
if(isset($_SESSION['username'])){
  echo '
    <li class="nav-item bg-info">
    <a class="nav-link" href="#">'.$_SESSION["username"].'</a>
    </li>
';
}
?>
    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>login">登入</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?=Config::BASE_URL;?>register">註冊</a>
    </li>

  </ul>
</nav>

