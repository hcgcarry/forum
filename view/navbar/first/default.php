<div class='sticky-top'>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" >
    <img src="<?=Config::BASE_URL?>pictures/手機桌布/l.jpg" alt='log'> 
  <span class='sitename'>N.A.W | News Around The World</span>
  </a>
	<!-- to mr-auto-->
  <ul class="navbar-nav mr-auto">

  </ul>


    <?php
if(isset($_SESSION['username'])){
	//if login
  echo '
  <ul class="navbar-nav mr-3">
    <li class="nav-item">
		<img src="'.Config::BASE_URL.'pictures/手機桌布/l.jpg" alt="log" style="width:30px"> 
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
	  '.$_SESSION["username"].'
	  
      </a>
      <div class="dropdown-menu ">
		<a class="dropdown-item" href="'.Config::BASE_URL.'home">home</a>
	    <a class="dropdown-item" href="'.Config::BASE_URL.'logout">logout</a>
      </div>
    </li>
  </ul>
';
}
else{
	//if not login
	echo "
  <ul class='navbar-nav'>
    <li class='nav-item'>
      <a class='nav-link' href='".Config::BASE_URL."login?location=".urlencode($_SERVER['REQUEST_URI'])."'>登入</a>
    </li>
    <li class='nav-item'>
      <a class='nav-link' href='".Config::BASE_URL."register'>註冊</a>
    </li>

  </ul>
  ";

}
?>


</nav>