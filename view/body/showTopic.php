<div class='container'>
<ul class='nav nav-pill'>
<?php 
$sql="SELECT categories_name,categoriesID FROM categories";
///這個似乎只能執行一次, 我猜拭去取得categoreisnamearray食材會執行query
$categoriesArray=Database::get()->execute($sql);
if (isset($categoriesArray) AND count($categoriesArray) > 0){
  foreach($categoriesArray as $row){
    printf("<li class='nav-item'><a class='nav-link' href='?cid=%s'>%s</a></li>",$row['categoriesID'],$row['categories_name']);
  }
  
}
?>
</ul>
</div>
